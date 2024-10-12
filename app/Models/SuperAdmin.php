<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperAdmin extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    // Add relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
