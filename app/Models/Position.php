<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_positions');
    }
}
