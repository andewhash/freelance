<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseImage extends Model
{
    use HasFactory;

    protected $table = 'response_images';
    protected $fillable = ['response_id', 'file_id'];
}
