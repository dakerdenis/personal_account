<?php

namespace App\Repository\Eloquent;

use App\Models\Contact;
use App\Models\FeatureLine;
use App\Models\Product;
use App\Repository\ContactRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }


    public function create(array $attributes): Model
    {
        try {
            DB::beginTransaction();
            /** @var Product $product */
            $product = $this->model->create($attributes);
            $this->handleCategories($attributes, $product);
            $this->handleMedia($product, $attributes);
            $this->handleInsuranceBlocks($product, $attributes);
            $this->handleFeatureBlocks($product, $attributes);
            $this->handleFaqsBlocks($product, $attributes);
            $this->handleUsefulLinks($product, $attributes);
            $this->handleFiles($product, $attributes);
            $this->handleSpecialOffers($product, $attributes);
            $this->handlePackages($product, $attributes);
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            throw $e;
        }

        DB::commit();

        return $product;
    }

    public function handleInsuranceBlocks(Product $product, array $data): void
    {
        if (isset($data['delete_insuranceBlocks'])) {
            $product->insuranceConditions()->whereIn('id', $data['delete_insuranceBlocks'])->delete();
        }

        if (isset($data['insuranceBlocks'])) {
            $order_column = 0;
            foreach ($data['insuranceBlocks'] as $id => $block) {
                $condition = $product->insuranceConditions()->updateOrCreate(['id' => $id], $block + ['order_column' => $order_column]);
                $this->handleMedia($condition, $block);
            }
        }
    }

    public function handleFeatureBlocks(Product $product, array $data): void
    {
        if (isset($data['delete_features']) && $data['delete_features']) {
            $product->productFeatures()->whereIn('id', $data['delete_features'])->delete();
        }

        if (isset($data['delete_feature_lines']) && $data['delete_feature_lines']) {
            foreach ($data['delete_feature_lines'] as $id) {
                FeatureLine::find($id)->delete();
            }
        }

        if (isset($data['featureBlocks'])) {
            $order_column = 0;
            foreach ($data['featureBlocks'] as $id => $block) {
                $feature = $product->productFeatures()->updateOrCreate(['id' => $id], $block + ['order_column' => $order_column]);
                $order_column++;
                $order_column_lines = 0;
                foreach ($block['featureLines'] ?? [] as $idLine => $featureLine) {
                    $feature->featureLines()->updateOrCreate(['id' => $idLine], $featureLine + ['order_column' => $order_column_lines]);
                    $order_column_lines++;
                }
            }
        }
    }

    public function handleFaqsBlocks(Product $product, array $data): void
    {
        if (isset($data['delete_faqs']) && $data['delete_faqs']) {
            $product->faqs()->whereIn('id', $data['delete_faqs'])->delete();
        }

        if (isset($data['faqs'])) {
            $order_column = 0;
            foreach ($data['faqs'] as $id => $block) {
                $product->faqs()->updateOrCreate(['id' => $id], $block + ['order_column' => $order_column]);
            }
        }
    }

    public function handleUsefulLinks(Product $product, array &$data)
    {
        if ($data['useful_links'] ?? false) {
            $links = [];
            foreach ($data['useful_links'] as $order => $link) {
                $links[$link] = ['order' => $order];
            }
            $product->usefulLinks()->sync($links);
            unset($data['useful_links']);
        } else {
            $product->usefulLinks()->sync([]);
        }
    }

    public function handleFiles(Product $product, array &$data)
    {
        if ($data['files'] ?? false) {
            $files = [];
            foreach ($data['files'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $product->files()->sync($files);
            unset($data['files']);
        } else {
            $product->files()->sync([]);
        }
    }

    public function handleSpecialOffers(Product $product, array &$data)
    {
        if ($data['special_offers'] ?? false) {
            $articles = [];
            foreach ($data['special_offers'] as $order => $article) {
                $articles[$article] = ['order' => $order];
            }
            $product->articles()->sync($articles);
            unset($data['special_offers']);
        } else {
            $product->articles()->sync([]);
        }
    }

    public function handlePackages(Product $product, array &$data)
    {
        if ($data['packages'] ?? false) {
            $packages = [];
            foreach ($data['packages'] as $order => $package) {
                $packages[$package] = ['order' => $order];
            }
            $product->packages()->sync($packages);
            unset($data['packages']);
        } else {
            $product->packages()->sync([]);
        }
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        try {
            DB::beginTransaction();
            $product->update($data);
            $this->handleCategories($data, $product);
            $this->handleMedia($product, $data);
            $this->handleInsuranceBlocks($product, $data);
            $this->handleFeatureBlocks($product, $data);
            $this->handleFaqsBlocks($product, $data);
            $this->handleUsefulLinks($product, $data);
            $this->handleFiles($product, $data);
            $this->handleSpecialOffers($product, $data);
            $this->handlePackages($product, $data);
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable);

            return false;
        }

        DB::commit();

        return true;
    }
}
