<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class archive extends Model
{
    use HasFactory;
    protected $fillable = ['bidang_id','seksi_id','kategori_id','tanggal_arsip','nama_arsip','nomor_arsip','keterangan_arsip','cover_arsip','arsip_file'];

    protected $casts = [
        'arsip_file' => 'array',
        'original_filename' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function bidang()
    {
        return $this->belongsTo(bidang::class, 'bidang_id', 'id');
    }

    public function seksi()
    {
        return $this->belongsTo(seksi::class, 'seksi_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategoris::class, 'kategori_id', 'id');
    }
}
