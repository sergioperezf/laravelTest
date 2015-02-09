<?php

class UserController extends Controller {
    /*
     * registers a new user
     */

    public function register() {
        // we must be logged out to be able to register a new user
        if (!Auth::check()) {
            $validator = $this->getRegisterValidator();
            if ($validator->passes()) {
                try {
                    $data = $this->getRegisterData();
                    $theUser = new User();
                    $theUser->username = $data['username'];
                    $theUser->email = $data['email'];
                    //the hash includes the salt
                    $theUser->password = Hash::make($data['password']);
                    $theUser->save();
                    $data['success'] = 'New user registered succesfully';
                    //finally we send the email
                    Mail::send('emails.welcome', array('user' => $theUser), function($message) use ($theUser) {
                        $message->to($theUser->email, $theUser->username)->subject('Welcome!');
                    });
                } catch (Exception $e) {
                    $data['error'] = 'An error occurred while trying to register the user: ' . $e->getMessage();
                }
            } else {
                $data['error'] = $this->addMessages($validator);
            }
            //if validation is not passed or the registration failed, 
            //redirect to login form with errors
            return Redirect::route("user/login")->with('data', $data);
        }
    }

    /*
     * this function adds as li elements each one of the error messages of the
     * validation to a atring
     */

    protected function addMessages($validator, $messages = '') {
        foreach ($validator->messages()->all('<li>:message</li>') as $message) {
            $messages .= $message . '<br/>';
        }
        return $messages;
    }

    /*
     * delete users
     */
    public function delete($id) {
        // only the current user can delete himself
        if (Auth::check() && Auth::user()->id == $id) {
            $theUser = User::find($id);
            $theUser->delete();
            // logout the app since it does not make sense to be logged in
            Auth::logout();
            return Redirect::route("user/login")->with('data', array('success' => 'Deleted.'));
        }
        // if some clever man tries to delete arbitrary users
        return Redirect::route("user/login")->with('data', array('error' => 'Not allowed.'));
    }

    /*
     * this function gets the validator of the register form
     */
    protected function getRegisterValidator() {
        return Validator::make(Input::all(), [
                    "username" => "required|alpha",
                    "email" => "required|email",
                    "password" => "required|alpha_num",
                    "password_repeat" => "required|same:password"
        ]);
    }

    /*
     * data of the register form
     */
    protected function getRegisterData() {
        return [
            "email" => Input::get("email"),
            "username" => Input::get("username"),
            "password" => Input::get("password"),
        ];
    }

    /*
     * logs in a user. Performs authentication via attempt method
     */
    public function login() {//TODO: make it so that refreshing (F5) the page does not resend the form.
        $data = Session::get('data') ? Session::get('data') : [];
        if ($this->isPostRequest()) {
            $validator = $this->getLoginValidator();

            if ($validator->passes()) {
                $credentials = $this->getLoginCredentials();

                if (Auth::attempt($credentials)) {
                    return Redirect::route("user/profile")->with('data', $data);
                }
                $data['error'] = "Credentials invalid.";
            } else {
                $data['error'] = $this->addMessages($validator);
            }
        }
        if (Auth::check()) {
            return Redirect::route("user/profile")->with('data', $data);
        }
        return View::make("user/login", $data);
    }

    /*
     * helper function to know whether a request is post
     */
    protected function isPostRequest() {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    /*
     * validator for login form
     */
    protected function getLoginValidator() {
        /*
         * the first argument for Validator::make is the data to validate, and 
         * the second is an array of rules.
         */
        return Validator::make(Input::all(), [
                    "email" => "required|email",
                    "password" => "required"
        ]);
    }

    protected function getLoginCredentials() {
        return [
            "email" => Input::get("email"),
            "password" => Input::get("password")
        ];
    }

    /*
     * data of the edit user form
     */
    protected function getUserData() {
        return [
            "name" => Input::get("name"),
            "lastname" => Input::get("lastname"),
            "phone" => Input::get("phone"),
            "birthday" => Input::get("birthday"),
            "picture_id" => Input::get("picture_id")[0]
        ];
    }

    /*
     * validator for edit user form
     */
    protected function getUserDataValidator() {//todo: validate picture_id[] is numeric
        return Validator::make(Input::all(), [
                    'phone' => 'numeric',
                    'birthday' => 'date_format:"Y-m-d"',
        ]);
    }

    /*
     * this controller shows the profile of the authenticated user
     */
    public function profile() {
        $data = Session::get('data') ? Session::get('data') : [];
        if (Auth::check()) {
            return View::make("user/profile", $data);
        }
        return Redirect::route("user/login");
    }

    /*
     * the edit action, to change user data
     */
    public function edit() {
        $data = [];
        //the post method handles data saving
        if ($this->isPostRequest() && Auth::check()) {
            $validator = $this->getUserDataValidator();
            if ($validator->passes()) {
                $userData = $this->getUserData();
                Auth::user()->name = $userData['name'];
                Auth::user()->lastname = $userData['lastname'];
                Auth::user()->phone = $userData['phone'];
                Auth::user()->birthday = $userData['birthday'];
                $picture = Picture::find($userData['picture_id']);
                //can only set the profile picture if the picture is previously
                //associated with the user.
                if ($picture && Picture::find($userData['picture_id'])->user_id == Auth::user()->id) {
                    Auth::user()->picture_id = $userData['picture_id'];
                }
                Auth::user()->save();
                $theUser = Auth::user();
                //finally, send the email
                Mail::send('emails.edited', array('user' => $theUser), function($message) use ($theUser) {
                    $message->to($theUser->email, $theUser->username)->subject('Profile edited!');
                });
                $data['success'] = 'Profile saved.';
                return Redirect::route("user/profile")->with('data', $data);
            } else {
                //validation did not succeed
                $data['error'] = $this->addMessages($validator);
            }
        }
        if (Auth::check()) {
            $pictures = Picture::ofUser(Auth::user()->id)->get();
            $data['pictures'] = $pictures;
            return View::make("user/edit", $data);
        }
        return Redirect::route("user/login");
    }

    /*
     * logs out a user
     */
    public function logout() {
        Auth::logout();

        return Redirect::route("user/login");
    }

}
