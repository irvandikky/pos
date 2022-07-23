<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'address' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
