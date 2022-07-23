<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'image',
        'name',
        'description',
        'price',
        'stock',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function productOrders()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
