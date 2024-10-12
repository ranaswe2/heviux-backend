<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'percentage', 'start_date', 'end_date', 'created_by', 'modified_by', 
    ];

    protected $dates = ['start_date', 'end_date', 'deleted_at'];
    
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedByUser()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
