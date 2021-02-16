<?php


namespace App;


use Illuminate\Support\Facades\Auth;

class APContext {

	public static function getUserIdLogIn() {
		return Auth::id();
	}

	public static function getUserLogin() {
		return Auth::user();
	}
}
