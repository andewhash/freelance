<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseCountry extends Model
{
    use HasFactory;

    protected $table = 'response_countries';
    protected $fillable = ['response_id', 'country_id'];
}
