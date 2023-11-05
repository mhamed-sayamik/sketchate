<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Client;
use App\Models\Province;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredClientController extends Controller
{
     /**
     * Display the registration view.
     */
    public function create(): View
    {   $governorates = Governorate::all();
        if(request('gov') !== null){

                $provinces = Province::where('governorate_id', intval(request('gov')))->get();
        }else{
                $provinces = Province::all();
    }
        return view('client.register',['governorates' => $governorates, 'provinces' => $provinces]);
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'governorate' => 'required|exists:governorates,id',
            'province' => 'required|exists:provinces,id'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client'
        ]);
        $client= Client::create([
            'user_id' => $user->id,
            'province_id' =>$request->province
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('client.dashboard'));
    }
}
