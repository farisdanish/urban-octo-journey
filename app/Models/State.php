<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'states';

    // Fillable properties to allow mass assignment
    protected $fillable = [
        'code', // State code (e.g., MY-01)
        'name', // State name (e.g., Johor)
    ];

    /**
     * Define a relationship with CustomerAddress.
     * A state can have many customer addresses.
     */
    public function customerAddresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    /**
     * Define a relationship with OrderDetail.
     * A state can have many order details.
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
