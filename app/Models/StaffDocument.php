<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;

class StaffDocument extends Model
{
    use Auditable;
    protected $fillable = [
        'user_id',
        'document_name',
        'file_path',
        'file_original_name',
        'file_type',
    ];

    /**
     * Get the user associated with the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
