<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Illuminate\Support\Str;
use Mews\Captcha\Captcha;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, Captcha $captchaBuilder)
    {
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->create('flat', true);
        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha['key']], $expiredAt);

        $result = [
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_key' => $key,
            'captcha_img' => $captcha['img'],
        ];

        return response()->json($result, 201);
    }
}
