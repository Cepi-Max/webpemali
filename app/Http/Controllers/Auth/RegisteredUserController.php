<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $title = 'Daftar Desa Pemali';
        // dd($title);
        return view('auth.register', compact('title'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'number_phone' => ['required', 'string', 'max:20'], // <-- tambahkan validasi no HP
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        do {
            $nik = request()->nik;
        } while (User::where('nik', $nik)->exists());

        $user = User::create([
            'name' => $request->name,
            'nik' => $nik,
            'email' => $request->email,
            'number_phone' => $request->number_phone, 
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('show.dashboard', absolute: false));
    }

}
