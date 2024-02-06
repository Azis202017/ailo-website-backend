<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kode_asistant',
        'jurusan',
        'tahun_asistant',
        'foto',
        'linkedin',
        'github',
        'discord',
        'twitter',
        'biography',
        'instagram',
        'is_assistant',
        'kategori_asistant',
        'google_schoolar',
        'jabatan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->foto = $model->foto ?? 'maskot.webp';
        });
    }
    public function expertise() {
        return $this->hasMany(UserExpertise::class,'id_user');
    }
    public function research() {
        return $this->hasMany(UserResearchPublication::class,'id_user');
    }
}
