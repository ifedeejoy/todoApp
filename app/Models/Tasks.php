<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
