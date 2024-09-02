<?php

namespace App\Repository\Eloquent;

use App\Models\Block;
use App\Models\Blockable;
use App\Models\ExtendedStat;
use App\Models\ExtendedStatInfo;
use App\Models\Product;
use App\Repository\BlockRepositoryInterface;
use App\Repository\RepeatableRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlockRepository extends BaseRepository implements BlockRepositoryInterface
{
    public function __construct(Block $model, public RepeatableRepositoryInterface $repeatableRepository)
    {
        parent::__construct($model);
    }

    public function update(int $id, array $data): bool
    {
        $block = $this->find($id);
        $this->handleMedia($block, $data);
        $this->handlePictures($data['images'] ?? [], $block, $data['delete_images'] ?? null);
        if (isset($data['video'])) {
            /** @var UploadedFile $video */
            $video = $data['video'];
            $link = $video->store('public/videos');
            $data['meta']['video'] = $link;
        }
        $block->touch();


        return $block->update($data);
    }

    public function createOrUpdateAndAssociate(array $data, Model $model, string $type, string $collection_name = null)
    {
        $order = 0;
        foreach ($data as $id => $block_data) {
            $block = $model->blocks()->updateOrCreate(
                ['blocks.id' => $id, 'type' => $type],
                $block_data + ['type' => $type]
            );
            $pivot = $block->blockables()->where('blockable_id', $model->id)->first();
            $pivot->order_column = $order;
            $pivot->save();
            $this->handleMedia($block, $block_data, $collection_name);
            $order++;
        }
    }

    public function getPageBlocks(string $blockable): mixed
    {
        return Blockable::with('block')->where('blockable_type', $blockable)->ordered()->get();
    }

    public function updatePageBlocks(array $data, string $blockable): bool
    {
        Blockable::where('blockable_type', $blockable)->delete();
        if (isset($data['blocks']) && $data['blocks']) {
            foreach ($data['blocks'] as $order_column => $block) {
                Blockable::create(
                    [
                        'block_id' => $block,
                        'blockable_type' => $blockable,
                        'order_column' => $order_column
                    ]
                );
            }
        }
        return true;
    }

    public function createRounds(array $data): ?Model
    {
        $block = $this->create($data);
        $this->repeatableRepository->handleRepeatable($data, $block);
        $this->handleStat($data, $block);

        return $block;
    }

    public function updateRounds(int $id, array $data): ?Model
    {
        $block = $this->find($id);
        $block->update($data);
        $this->repeatableRepository->handleRepeatable($data, $block);
        $this->handleStat($data, $block);

        return $block;
    }


    public function create(array $attributes): Model
    {
        if (isset($attributes['video'])) {
            /** @var UploadedFile $video */
            $video = $attributes['video'];
            $link = $video->store('public/videos');
            $attributes['meta']['video'] = $link;
        }
        $block = $this->model->create($attributes);
        $this->handleMedia($block, $attributes);
        if (isset($attributes['images'])) {
            $this->handlePictures($attributes['images'], $block);
        }
        return $block;
    }

    public function handlePictures(array $images, Block $product, ?array $delete = null): void
    {
        $order = 0;
        $media = null;
        foreach ($images as $image) {
            try {
                if (isset($image['id']) && $image['id']) {
                    $media = $this->fileRepository->find($image['id']);
                } elseif (isset($image['file']) && $image['file'] && Auth::guard('staff')->check()) {
                    $media = $product->addMedia($image['file'])->toMediaCollection('gallery');
                }
                if ($media) {
                    $media->update(['order_column' => $order]);
                    $order++;
                }
            } catch (FileDoesNotExist $exception) {
                Log::warning($exception->getMessage() . ' Image not found: ' . json_encode($image));
            }
        }
        if ($delete) {
            $images = Media::find($delete);
            $images->each->delete();
        }
    }


    public function handleStat(array $data, object $reference)
    {
        if (isset($data['delete_stat']) && $data['delete_stat']) {
            foreach ($data['delete_stat'] as $stat) {
                ExtendedStat::find($stat)?->delete();
            }
        }
        if (isset($data['stat']) && $data['stat']) {
            $order_column = 0;
            foreach ($data['stat'] as $id => $stat) {
                $statInfo = $this->updateOrCreateOnReference($id, $stat + ['order_column' => $order_column], $reference);
                $order_column++;
                $this->handleStatInfo($stat, $statInfo, $data);
            }
        }
    }


    public function handleStatInfo(array $stat, object $reference, $data)
    {
        if (isset($data['delete_stat_info']) && $data['delete_stat_info']) {
            foreach ($data['delete_stat_info'] as $stat) {
                ExtendedStatInfo::find($stat)?->delete();
            }
        }
        if (isset($stat['statInfo']) && $stat['statInfo']) {
            $order_column = 0;
            foreach ($stat['statInfo'] as $id => $statInfo) {
                $statInfo = $this->updateOrCreateOnReferenceInfo($id, $statInfo + ['order_column' => $order_column], $reference);
                $order_column++;
            }
        }
    }

    public function updateOrCreateOnReference(int|string $id, array $attributes, object $reference)
    {
        $stat = $reference->extendedStats()->updateOrCreate(['id' => $id], $attributes);
        $this->handleMedia($stat, $attributes);

        return $stat;
    }

    public function updateOrCreateOnReferenceInfo(int|string $id, array $attributes, object $reference)
    {
        $stat = $reference->extendedStatInfos()->updateOrCreate(['id' => $id], $attributes);

        return $stat;
    }
}
