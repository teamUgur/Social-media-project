<?php

namespace App\Services;

use App\Http\Responses\UserMeta;
use App\Mail\ConfirmMail;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Fecades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserService
{
    private function normilizeEmail(string $email) 
    {
        return strtolower($email);
    }

    private function defaultNameFromEmail(string $email) 
    {
        return explode("@", $email)[0];
    }

    private function getUserById(string $id) : User | null
    {
        return User::query()->where("id", $id)->first();
    }

    private function getUserByEmail(string $email) : User | null
    {
        return User::query()->where("email", $email)->first();
    }

    private function getUserByUsername(string $username) : User | null
    {
        return User::query()->where("username", $username)->first();
    }

    private function userMetaCacheKey(string $id) 
    {
        return "meta_user:$id";
    }
}