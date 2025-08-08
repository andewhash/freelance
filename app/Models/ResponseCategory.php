<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseCategory extends Model
{
    use HasFactory;

    protected $table = 'response_categories';
    protected $fillable = ['response_id', 'category_id'];
}
