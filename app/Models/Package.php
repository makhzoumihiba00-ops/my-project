<?php

namespace App\Models;

use Database\Factories\PackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    /** @use HasFactory<PackageFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'price', 'duration',
        'location', 'category', 'max_guests', 'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'max_guests' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
