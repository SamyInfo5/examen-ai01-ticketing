<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $fillable = ['name'];

    public function supports(): MorphMany
    {
        return $this->morphMany(Supports::class, 'role_id');
    }
}
