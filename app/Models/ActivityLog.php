<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';

    /**
     * Disable standard Eloquent updated_at timestamp since logs are write-only.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_name',
        'module_slug',
        'record_id',
        'action',
        'performed_by',
        'performed_by_name',
        'performed_by_role',
        'performed_by_type',
        'old_values',
        'new_values',
        'changed_fields',
        'description',
        'reference_no',
        'ip_address',
        'browser',
        'device',
        'operating_system',
        'url',
        'http_method',
        'request_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user who performed the activity.
     */
    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
