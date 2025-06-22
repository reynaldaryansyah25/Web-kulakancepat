<?php
// Lokasi: app/Models/DeliveryLocationHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocationHistory extends Model
{
    use HasFactory;

    protected $table = 'delivery_location_history';

    // Tabel ini tidak memiliki updated_at
    const UPDATED_AT = null;
    // Kita bisa definisikan nama kolom created_at kustom kita
    const CREATED_AT = 'recorded_at';

    protected $fillable = [
        'delivery_id',
        'latitude',
        'longitude',
        // 'recorded_at' akan diisi otomatis
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'recorded_at' => 'datetime',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
}
