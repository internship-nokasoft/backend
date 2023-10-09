<?php 

namespace App\Services\Api;
use App\Repositories\Api\AdminRepository;
use Illuminate\Support\Facades\Hash;

class AdminService{

    protected AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository){
        $this->adminRepository = $adminRepository;
    }

    public function register(array $data){

        $data['password'] = Hash::make($data['password']);
        return $this->adminRepository->create($data);
    }

    public function login(array $credentials){

        $admin = $this->adminRepository->findByEmail($credentials['email']);
        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return ['message' => 'Bad creds'];
        }

        auth()->login($admin);
        return ['admin' => $admin, 'token' => $admin->createToken('admin-access-token')->plainTextToken];
    }
}