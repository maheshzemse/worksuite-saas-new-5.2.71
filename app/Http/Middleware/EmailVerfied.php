<?php

namespace App\Http\Middleware;

use App\Models\GlobalSetting;
use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EmailVerfied extends EnsureEmailIsVerified
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $globalSetting = GlobalSetting::first();

        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail() &&
            $globalSetting->email_verification)) {
            return $request->expectsJson() ? abort(403, 'Your email address is not verified.') : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
        }

        return $next($request);
    }

}
