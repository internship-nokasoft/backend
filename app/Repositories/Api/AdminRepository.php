<?php

namespace App\Repositories\Api;
use App\Models\Admin;

class AdminRepository{
    
    public function create(array $data)
    {
        return Admin::create($data);
    }

    public function findByEmail($email)
    {
        return Admin::where('email', $email)->first();
    }
}