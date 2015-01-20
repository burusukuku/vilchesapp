<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    public function index()
    {
        return View::make('Home.index');
    }
    public function login()
    {
        return View::make('Home.login');
    }
    public function salir()
    {
        Auth::user()->logout();
        return Redirect::to('login');
    }
    public function recoverpassword()
    {
        return View::make('HomeController.recoverpassword');
    }
    public function resetpassword($type, $token)
    {
        return View::make('HomeController.resetpassword')->with('token',$token);
    }

}
