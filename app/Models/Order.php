<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['customer_id', 'user_id', 'total', 'status'];

    protected $searchableFields = ['*'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderDetail::class);
    }
}
