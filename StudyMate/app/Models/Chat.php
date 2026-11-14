<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $primaryKey = 'id_chat';
    public $timestamps = false;

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'pesan',
        'waktu_kirim',
    ];

    protected $casts = [
        'waktu_kirim' => 'datetime',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id_user');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'id_penerima', 'id_user');
    }
}
