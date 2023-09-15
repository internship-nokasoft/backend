<?php 

namespace App\Repositories\Web;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberRepository{


    public function createMember($data)
    {
        return Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function findByEmail($email)
    {
        return Member::where('email', $email)->first();
    }

    public function createOrUpdateToken(Member $member)
    {
        $member->remember_token = Str::random(30);
        $member->save();
    }

    public function resetPassword(Member $member, $password)
    {
        $member->password = Hash::make($password);
        $this->createOrUpdateToken($member); 
    }

    public function findByToken($token)
    {
        return Member::where('remember_token', $token)->first();
    }
}