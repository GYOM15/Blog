<?php

namespace App\Http\Controllers;

use to;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login () : View {
        return view('auth.login');
    }

    // Il est important de noter que nous devons changer le nom de notre route dans le fichier Authentificate.php dans middleware 
    public function logout () {
        Auth::logout();
        return to_route('auth.login');
    }

    public function doLogin (LoginRequest $request) {
        
        $credentials = $request->validated();

        // On vérifie si l'utilisateur est connecté
        if(Auth::attempt($credentials)){
            // Si oui, on régénère la session
            $request->session()->regenerate();
            //return redirect()->route('blog.index'); mais dans notre intended est plus adapté car il permet d'acceder au lien que l'utilisateur avait démandé au départ
            return redirect()->intended(route('blog.index'));
        }
        // S'il s'est trompé, on le redirige vers l'authentification. onlyInput permet de conserver uniquemment la valeur de email
        return to_route('auth.login')->withErrors([
            'email' => 'Email invalid'
        ])->onlyInput('email');
    }
    
}
