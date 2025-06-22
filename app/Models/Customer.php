<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer';
    protected $primaryKey = 'id_customer';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';


    protected $fillable = [
        'name_store',
        'name_owner',
        'email',
        'no_phone',
        'password',
        'address',
        'status',
        'id_sales',
        'customer_tier_id',
        'credit_limit',
        'avatar', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];


    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    public function salesPerson()
    {
        return $this->belongsTo(Sales::class, 'id_sales', 'id_sales');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_customer', 'id_customer');
    }

    public function completedTransactions()
    {
        return $this->hasMany(Transaction::class, 'id_customer', 'id_customer')->where('status', 'FINISH');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'id_customer', 'id_customer');
    }

    public function tier()
    {
        return $this->belongsTo(CustomerTier::class, 'customer_tier_id');
    }
}
