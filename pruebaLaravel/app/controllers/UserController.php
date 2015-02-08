<?php

class UserController extends Controller {

    public function login() {//TODO: make it so that refreshing (F5) the page does not resend the form.
        $data = [];
        if ($this->isPostRequest()) {
            $validator = $this->getLoginValidator();

            if ($validator->passes()) {
                $credentials = $this->getLoginCredentials();

                if (Auth::attempt($credentials)) {
                    return Redirect::route("user/profile");
                }
                $data['error'] = "Credentials invalid.";
            } else {
                $data["error"] = "All fields are required.";
            }
        }
        if (Auth::check()) {
            return Redirect::route("user/profile");
        }
        return View::make("user/login", $data);
    }

    protected function isPostRequest() {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    protected function getLoginValidator() {
        /*
         * the first argument for Validator::make is the data to validate, and 
         * the second is an array of rules.
         */
        return Validator::make(Input::all(), [
                    "username" => "required",
                    "password" => "required"
        ]);
    }

    protected function getLoginCredentials() {
        return [
            "email" => Input::get("username"),
            "password" => Input::get("password")
        ];
    }

    protected function getUserData() {
        return [
            "name" => Input::get("name"),
            "lastname" => Input::get("lastname"),
            "phone" => Input::get("phone"),
            "birthday" => Input::get("birthday"),
        ];
    }

    protected function getUserDataValidator() {
        return Validator::make(Input::all(), [
                    'phone' => 'numeric'
        ]);
    }

    public function profile() {
        if (Auth::check()) {
            return View::make("user/profile");
        }
        return Redirect::route("user/login");
    }

    public function edit() {
        $data = [];
        if ($this->isPostRequest()) {

            $validator = $this->getUserDataValidator();

            if ($validator->passes()) {
                $userData = $this->getUserData();
//                die(var_export($userData, true));
                Auth::user()->name = $userData['name'];
                Auth::user()->lastname = $userData['lastname'];
                Auth::user()->phone = $userData['phone'];
                Auth::user()->birthday = $userData['birthday'];
                Auth::user()->save();
                return Redirect::route("user/profile");
            } else {
                $data["error"] = "The form is invalid.";
            }
        }
        if (Auth::check()) {
            return View::make("user/edit", $data);
        }
        return Redirect::route("user/login");
    }

    public function logout() {
        Auth::logout();

        return Redirect::route("user/login");
    }

}
