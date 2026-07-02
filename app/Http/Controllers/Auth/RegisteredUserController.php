<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
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
            'prenom' => ['required', 'string', 'max:255'],
            'role' => ['required', Rule::in(['patient', 'medecin', 'secretaire', 'responsable_prestation'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'antecedents' => ['nullable', 'array'],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = $request->role;
            Role::findOrCreate($role, 'web');
            $user->assignRole($role);

            if ($role === 'patient') {
                Patient::create([
                    'user_id' => $user->id,
                    'code' => 'PAT-' . strtoupper(Str::random(6)),
                    'nom' => $request->name,
                    'prenom' => $request->prenom,
                    'antecedents' => $request->antecedents,
                ]);
            }

            if ($role === 'medecin') {
                Medecin::create([
                    'user_id' => $user->id,
                    'specialite' => 'généraliste',
                    'disponible' => true,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
