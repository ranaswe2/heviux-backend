<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes; 

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image_name', 
        'image_path',
        'password',
        'address',
        'is_admin',
        'current_otp',
        'is_verified',
    ];

    

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    // Add hasMany relationships for models related to User
    public function createdProducts()
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    public function modifiedProducts()
    {
        return $this->hasMany(Product::class, 'modified_by');
    }

    public function createdProductImages()
    {
        return $this->hasMany(ProductImage::class, 'created_by');
    }

    public function modifiedProductImages()
    {
        return $this->hasMany(ProductImage::class, 'modified_by');
    }

    public function createdProductSizes()
    {
        return $this->hasMany(ProductSize::class, 'created_by');
    }

    public function modifiedProductSizes()
    {
        return $this->hasMany(ProductSize::class, 'modified_by');
    }

    public function createdOffers()
    {
        return $this->hasMany(Offer::class, 'created_by');
    }

    public function modifiedOffers()
    {
        return $this->hasMany(Offer::class, 'modified_by');
    }

    public function createdDiscounts()
    {
        return $this->hasMany(Discount::class, 'created_by');
    }

    public function modifiedDiscounts()
    {
        return $this->hasMany(Discount::class, 'modified_by');
    }

    public function createdDeliveryCharges()
    {
        return $this->hasMany(DeliveryCharge::class, 'created_by');
    }

    public function modifiedDeliveryCharges()
    {
        return $this->hasMany(DeliveryCharge::class, 'modified_by');
    }

    public function superAdmin()
    {
        return $this->hasOne(SuperAdmin::class, 'user_id');
    }
}