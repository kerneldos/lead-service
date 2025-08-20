<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateLeadData
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'term' => 'required|integer',
            'policy_agreement' => 'required|boolean',
            'passport.series' => 'sometimes|required|string|size:4',
            'passport.number' => 'sometimes|required|string|size:6',
        ]);

        return $next($request);
    }
}
