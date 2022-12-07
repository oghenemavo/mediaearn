<?php

namespace App\Repositories;

use App\Contracts\IPlan;
use App\Models\Plan;
use Illuminate\Support\Str;

class PlanRepository implements IPlan
{
    public function __construct(protected Plan $plan)
    {
        $this->plan = $plan;
    }

    public function create(array $attributes)
    {
        $meta = [
            'set_discount' => false,
            'discount' => '0.00',
            'max_views' => 3,
        ];
        return $this->plan->create([
            'title' => data_get($attributes, 'title'),
            'price' => data_get($attributes, 'price'),
            'description' => $this->clean(data_get($attributes, 'description')),
            'meta' => $meta,
            'status' => '1'
        ]);
    }

    public function edit(array $attributes, $plan)
    {
        $meta = [
            'set_discount' => (bool) data_get($attributes, 'set_discount'),
            'discount' => (float) data_get($attributes, 'discount'),
            'max_views' => (int) data_get($attributes, 'max_views'),
        ];
        
        return $plan->update([
            'title' => data_get($attributes, 'title', $plan->title),
            'price' => data_get($attributes, 'price', $plan->price),
            'description' => $this->clean(data_get($attributes, 'description', $plan->description)),
            'meta' => $meta,
        ]);
    }

    public function changeStatus(string $status, $plan)
    {
        return $plan->update([
            'status' => $status
        ]);
    }

    protected function clean($string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        return $string;
    }
}