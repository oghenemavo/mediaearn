<?php

namespace App\Contracts;

use App\Models\Plan;

interface IPlan
{
    public function create(array $value);
    
    public function edit(array $value, Plan $plan);

    public function changeStatus(string $status, Plan $plan);
}