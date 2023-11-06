<?php

namespace App\Repositories\Api;

use App\Models\Admin;

class AdminRepository
{

    protected Admin $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function create(array $data)
    {
        return $this->admin->create($data);
    }

    public function findByEmail($email)
    {
        return $this->admin->where('email', $email)->first();
    }
}