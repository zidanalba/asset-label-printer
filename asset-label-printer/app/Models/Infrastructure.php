<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infrastructure extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Infrastructure::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Infrastructure::class, 'parent_id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'infrastructure_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'infrastructure_id');
    }
}
