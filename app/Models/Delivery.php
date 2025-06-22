<?php
// Lokasi: app/Models/Delivery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';

    protected $fillable = [
        'transaction_id',
        'sales_id',
        'status',
        'estimated_arrival',
    ];

    protected $casts = [
        'estimated_arrival' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id_transaction');
    }

    public function salesPerson()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id_sales');
    }

    public function locationHistory()
    {
        return $this->hasMany(DeliveryLocationHistory::class, 'delivery_id');
    }
}
