<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'code',
        'category_id',
        'serial_number',
        'asset_photo',
        'asset_serial_number_photo',
    ];

    protected $casts = [
        'printed_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function instances()
    {
        return $this->hasMany(AssetInstance::class, 'asset_id');
    }
}
