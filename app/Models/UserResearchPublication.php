<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResearchPublication extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'id_user'
    ];
}
