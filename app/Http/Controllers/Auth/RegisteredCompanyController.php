<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Governorate;
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

class RegisteredCompanyController extends Controller
{
      /**
     * Display the registration view.
     */
    public function create(): View
    {   $governorates = Governorate::all();
        $categories = Category::all();
        if(request('gov') !== null){

                $provinces = Province::where('governorate_id', intval(request('gov')))->get();
        }else{
                $provinces = Province::all();
    }
        return view('company.register',['governorates' => $governorates, 'provinces' => $provinces, 'categories' => $categories]);
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
            'province' => 'required|exists:provinces,id',
            'contact_address' => ['required', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'contact_website' => ['nullable', 'url', 'max:255'],
            'company_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:12288'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company'
        ]);
        $company= Company::create([
            'user_id' => $user->id,
            'province_id' =>$request->province,
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_website' => $request->contact_website,
            'contact_email' =>$request->email,
            'company_file' => $request->file('company_file')->store('company_files','private'),
            'category_id' =>$request->category_id
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('company.dashboard'));
    }
}
