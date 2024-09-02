<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use Loggable;

    protected $fillable = [
        'first_name',
        'last_name',
        'surname',
        'personal_id',
        'phone',
        'email',
        'message',
        'complaint_status_id',
        'change_status_date',
    ];

    protected $casts = [
        'change_status_date' => 'date',
    ];

    public function complaintStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class);
    }
}
