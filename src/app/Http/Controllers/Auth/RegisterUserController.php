<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class RegisterUserController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Log::info('Registered event triggered for user: ' . $user->email);

        // 手動でリスナーを呼び出す
        $listener = new SendEmailVerificationNotification();
        $listener->handle(new Registered($user));
        Log::info('SendEmailVerificationNotification listener called for user: ' . $user->email);

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
