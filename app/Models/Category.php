<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function categoryExists(string $category, $ignore_id = null)
    {
        $category = static::where('category', $category)->first();

        if ($category) {
            if ($category->id != $ignore_id) {
                return true;
            }
        }
        return false;
    }
    
}
