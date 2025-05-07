<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seksi extends Model
{
    use HasFactory;
    protected $fillable = ['id','seksi_name'];
}
