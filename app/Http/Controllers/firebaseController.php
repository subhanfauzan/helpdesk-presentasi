<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class firebaseController extends Controller
{
    public function getFirebaseData(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        if (validateSessionToken($get_session_token)) {

            $array_config_firebase = array(
                "apiKey" => encrypt_("AIzaSyAos_Eym4X5UTv8uz-rJENfwupjCeLj3MM"),
                "authDomain" => encrypt_("reflected-alpha-202905.firebaseapp.com"),
                "databaseURL" => encrypt_("https://reflected-alpha-202905-default-rtdb.firebaseio.com"),
                "projectId" => encrypt_("reflected-alpha-202905"),
                "storageBucket" => encrypt_("reflected-alpha-202905.appspot.com"),
                "messagingSenderId" => encrypt_("871479843775"),
                "appId" => encrypt_("1:871479843775:web:d8192d00b89a174308df0a"),
                "measurementId" => encrypt_("G-3P4H1K1YCW")
            );

            return response()->json(['array_config_firebase' => $array_config_firebase, 'kode' => 201]);
        };
    }
}
