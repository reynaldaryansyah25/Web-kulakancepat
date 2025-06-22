<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'products_category'; // Nama tabel di database
    protected $primaryKey = 'id_product_category'; // Primary key kustom
    public $timestamps = false; // Tabel ini tidak memiliki kolom created_at/updated_at standar

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        // Parameter kedua adalah foreign key di tabel products
        // Parameter ketiga adalah local key (primary key) di tabel products_category
        return $this->hasMany(Product::class, 'id_product_category', 'id_product_category');
    }
}
