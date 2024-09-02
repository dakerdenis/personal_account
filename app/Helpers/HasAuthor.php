<?php


namespace App\Helpers;


use App\Models\Staff;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
