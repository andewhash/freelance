<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Category extends Model
{
    use HasFactory;

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_categories');
    }

    public function responses(): BelongsToMany
    {
        return $this->belongsToMany(Response::class, 'response_categories');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories');
    }


    // Родительская категория
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Все предки (родители, дедушки и т.д.)
    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    public function getAncestorsAttribute()
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }
}
