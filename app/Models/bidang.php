<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bidang extends Model
{
    use HasFactory;
    protected $fillable = ['id','bidang_name'];
    
    public function Seksis(){
        return $this->hasMany(seksi::class,'bidang_id','id');
    }
}
