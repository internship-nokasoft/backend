<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Password;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'admin';
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function sendPasswordResetNotification($token)
    {
        $response = Password::broker('admin')->createToken($this);
        $url = 'http://localhost:5173/#/auth/reset-password' . '?email=' . base64_encode($this->email) . '&token=' . $response;
        $this->notify(new ResetPasswordNotification($url));
    }
}
