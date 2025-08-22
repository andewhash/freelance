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

    

    // НОВЫЙ МЕТОД: Получить все категории с иерархией
    public static function getAllWithHierarchy()
    {
        return self::with(['children.children'])
            ->whereNull('parent_id')
            ->get()
            ->map(function($category) {
                return self::formatForSelect($category);
            });
    }

    // НОВЫЙ МЕТОД: Форматирование для select
    protected static function formatForSelect($category, $level = 0)
    {
        $formatted = [
            'id' => $category->id,
            'name' => $category->name,
            'level' => $level
        ];

        if ($category->children->isNotEmpty()) {
            $formatted['children'] = $category->children->map(function($child) use ($level) {
                return self::formatForSelect($child, $level + 1);
            });
        }

        return $formatted;
    }
    // В классе Category добавьте этот метод
public static function getHierarchicalForCheckboxes()
{
    return self::with(['children.children'])
        ->whereNull('parent_id')
        ->get()
        ->map(function($category) {
            return self::formatForCheckboxes($category);
        });
}

// И этот вспомогательный метод
protected static function formatForCheckboxes($category, $level = 0)
{
    $formatted = [
        'id' => $category->id,
        'name' => $category->name,
        'level' => $level,
        'has_children' => $category->children->isNotEmpty(),
        'is_selectable' => $level == 2 // Только третий уровень можно выбирать
    ];

    if ($category->children->isNotEmpty()) {
        $formatted['children'] = $category->children->map(function($child) use ($level) {
            return self::formatForCheckboxes($child, $level + 1);
        });
    }

    return $formatted;
}
}
