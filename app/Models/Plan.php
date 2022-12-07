<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'meta' => AsCollection::class,
    ];

    /**
     * Get the cover paths.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function decodedDescription(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes) {
                $desc = html_entity_decode($attributes['description']);
                $i = str_replace('<li>', '', strip_tags($desc, '<li>'));
                return explode('</li>', $i);
            } 
            // ,
        );
    }
}
