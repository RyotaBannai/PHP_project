<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // logout method が呼び出されている時以外の処理
    }

    // attempt return true or false
    public function login(Request $request, MessageBag $message_bag){
        //    if (Auth::attempt($credentials)) {
        //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) { // 組み込みLoginControllerを使用する場合、このコントローラが使用しているトレイトにより、"remember"ユーザーを確実に処理するロジックが実装済み
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ // , 'active' => 1 とかにして有無効を管理
                return redirect()->intended('home');
            }
            $message_bag->add('error', 'This is the error message');
            // dd($message_bag);
        //return redirect('login')->withInput($request->input())->with(['message'=>'Wrong username/password combination']); // session()->get('message') で取得
        // return redirect('login')->withInput($request->input())->withErrors($message_bag);
        return redirect('login')->withInput($request->input())->withErrors($message_bag, 'login'); // {{ $error->login->first('error')}}
        // ->withFlashMessage('Wrong username/password combination.'); // flash_message でアクセス可
    }


    /* // ログインフォームの表示関連設定
    public function showLoginForm(){
        return route('home');
    }
    */
}
