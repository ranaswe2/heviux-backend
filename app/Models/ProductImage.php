<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'product_id', 'image_name', 'path', 'description', 'created_by', 'modified_by',
    ];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedByUser()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
