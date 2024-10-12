<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSize extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'product_id', 'small', 'medium', 'large', 'xlarge', 'xxlarge', 'xxxlarge', 'created_by', 'modified_by',
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
}
