<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Role extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'created_by',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')->withPivot('allowed');
    }
}
