<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function unauthenticated($request, array $guards)
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'error' => [
                    'phone' => [
                        'phone or password incorrect'
                    ]
                ]
            ]
        ])->setStatusCode(401));
    }
}
