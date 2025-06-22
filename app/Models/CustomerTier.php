<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTier extends Model
{
    use HasFactory;

    protected $table = 'customer_tiers';

    // PERBAIKAN DI SINI:
    // Memberitahu Eloquent nama primary key kustom Anda
    protected $primaryKey = 'id_customer_tier';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'min_monthly_purchase',
        'payment_term_days',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'min_monthly_purchase' => 'decimal:2',
        'payment_term_days' => 'integer',
    ];

    /**
     * Mendefinisikan relasi one-to-many: satu tier bisa dimiliki banyak customer.
     */
    public function customers()
    {
        // Parameter ketiga adalah local key (primary key) di tabel ini.
        return $this->hasMany(Customer::class, 'customer_tier_id', 'id_customer_tier');
    }
}
