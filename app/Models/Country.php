<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    protected $fillable = ['name', 'code', 'flag'];

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_countries');
    }

    public function responses(): BelongsToMany
    {
        return $this->belongsToMany(Response::class, 'response_countries');
    }
}
