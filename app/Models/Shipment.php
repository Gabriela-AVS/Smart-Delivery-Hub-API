<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['order_id', 'provider', 'tracking_number', 'status', 'shipping_cost', 'currency', 'label'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
