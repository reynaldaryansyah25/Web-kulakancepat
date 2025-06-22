<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Sales extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'sales';
    protected $primaryKey = 'id_sales';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'name',
        'email',
        'no_phone',
        'password',
        'target_sales',
        'wilayah',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'target_sales' => 'decimal:2',
    ];

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * Relasi one-to-many: satu sales bisa menangani banyak customer.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'id_sales', 'id_sales');
    }

    /**
     * Relasi HasManyThrough: satu sales memiliki banyak transaksi melalui customer.
     * Ini digunakan untuk menghitung total pencapaian sales.
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Customer::class,
            'id_sales',     // Foreign key di tabel customer
            'id_customer',  // Foreign key di tabel transaction
            'id_sales',     // Local key di tabel sales
            'id_customer'   // Local key di tabel customer
        );
    }
}
