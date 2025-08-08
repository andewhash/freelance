<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    use HasFactory;


    protected $table = 'request_categories';
    protected $fillable = ['request_id', 'category_id'];
}
