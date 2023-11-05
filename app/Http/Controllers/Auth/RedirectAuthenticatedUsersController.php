<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class RedirectAuthenticatedUsersController extends Controller
{
    //
    public function home()
    {   
        if (auth()->user()->role == 'client') {

            return redirect()->route("client.dashboard");
        }
        elseif(auth()->user()->role == 'company'){
            return redirect()->route("company.dashboard");
        }
        else{
            return auth()->logout();
        }
    }
}
