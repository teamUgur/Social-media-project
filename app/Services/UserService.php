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