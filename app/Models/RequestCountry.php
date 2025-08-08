<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCountry extends Model
{
    use HasFactory;

    protected $table = 'request_countries';
    protected $fillable = ['request_id', 'country_id'];
}
