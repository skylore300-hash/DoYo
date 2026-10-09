<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'discount_percent',
        'stock',
        'image_path',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_percent' => 'integer',
            'published' => 'boolean',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
