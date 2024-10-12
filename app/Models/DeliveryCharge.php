<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryCharge extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'price', 'created_by', 'modified_by',
    ];

    protected $dates = ['deleted_at'];

    // Add relationships
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedByUser()
    {
        return $this->belongsTo(User::class, 'modified_by');
    } 
}
