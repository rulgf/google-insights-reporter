<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Session;
use Auth;

use Socialite;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectAfterLogout = '/login';

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'signOut']]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        $token = $user->token;
        $userId = $user->getId();
        $userName = $user->getName();
        $usereMail = $user->getEmail();
        $userAvatar = $user->getAvatar();
        //dd($userAvatar);

        //Checo que el usuario tenga una cuenta DOOD para poder entrar
        $emailDomainOnly = preg_replace('/.+@/', '', $usereMail);
        if($emailDomainOnly == 'dood.mx'){
            //Checo si el usuario esta en la base de datos
            $usuariodb = User::where('email', $usereMail)->get()->first();
            if($usuariodb){
                Auth::login($usuariodb, true);
                Session::put('user', $usuariodb);
                return redirect()->to('/');
            }else{
                //Si no esta lo guardo en la base de datos
                $usuariodb = User::store($userId, $userName, $usereMail, $token, $userAvatar);

                if($usuariodb){
                    Auth::login($usuariodb, true);
                    Session::put('user', $usuariodb);
                    return redirect()->to('/');
                }
            }
        }else{
            return redirect()->to('/');
        }
    }

    public function signOut(){
        Auth::logout();
        Session::flush();
        return redirect('/');

    }
}
