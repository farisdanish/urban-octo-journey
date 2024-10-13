<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    // Adjust the fillable fields to match the new structure
    protected $fillable = ['type', 'address1', 'address2', 'city', 'state_id', 'zipcode', 'customer_id'];

    /**
     * Relationship to the Customer model.
     * A customer can have multiple addresses.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship to the State model.
     * Each address is associated with a state.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
