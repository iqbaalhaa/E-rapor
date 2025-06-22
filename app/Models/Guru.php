<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'nip',
        'email',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }
}
