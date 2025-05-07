<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    use HasFactory;
    protected $fillable = ['prov_id','prov_name','status'];
    
    public function Cities(){
        return $this->hasMany(cities::class,'prov_id','id');
    }
}
