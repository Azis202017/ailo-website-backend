<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'short_title',
        'description',
        'icon',
        'foto'
    ];
    public function publications(){
        return $this->hasMany(ResearchPublication::class,'id_research_area');
    }
}
