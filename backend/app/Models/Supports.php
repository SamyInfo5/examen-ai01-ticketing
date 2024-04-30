<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Supports extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id'
    ];
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
    public function status()
    {
        return $this->belongsToMany(Status::class);
    }
}
