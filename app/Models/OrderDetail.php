<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['order_id', 'product_id', 'qty', 'total'];

    protected $searchableFields = ['*'];

    protected $table = 'order_details';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
