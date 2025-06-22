<?php
// Lokasi: app/Models/SystemRecommendationLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRecommendationLog extends Model
{
    use HasFactory;

    protected $table = 'system_recommendation_logs';

    // Laravel mengasumsikan created_at & updated_at. 
    // Tabel kita punya sent_at, jadi kita nonaktifkan timestamp default.
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'type',
        'message',
        'sent_at',
        'metadata',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'metadata' => 'array', // Otomatis encode/decode ke/dari JSON
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id_customer');
    }
}
