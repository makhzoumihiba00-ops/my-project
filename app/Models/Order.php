<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'package_id', 'customer_name', 'customer_email', 'customer_phone',
        'number_of_people', 'visit_date', 'message', 'total_price', 'status',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'total_price' => 'decimal:2',
            'number_of_people' => 'integer',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
