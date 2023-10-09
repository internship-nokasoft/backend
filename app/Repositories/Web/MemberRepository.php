<?php 

namespace App\Repositories\Web;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberRepository{

    protected Member $member;

    public function __construct(Member $member){
        $this->member = $member;
    }

    public function createMember($data)
    {
        return $this->member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function findByEmail($email)
    {
        return $this->member::where('email', $email)->first();
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
        return $this->member::where('remember_token', $token)->first();
    }
}