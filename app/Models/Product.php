<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title', 'category', 'sub_category', 'fabric', 'GSM', 'price', 'description', 'created_by', 'modified_by',
    ];

    protected $dates = ['deleted_at'];
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedByUser()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }


    
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

}
