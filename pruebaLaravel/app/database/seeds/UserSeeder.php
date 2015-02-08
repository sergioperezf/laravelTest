<?php

/**
 * UserSeeder
 *
 * @author sergio
 */
class UserSeeder extends DatabaseSeeder{
    public function run(){
        $users = [
            [
                'username' => 'seperezf',
                'password' => Hash::make("password"),
                'email' => 'depowerwer@gmail.com'
            ]
        ];
        foreach ($users as $user){
            User::create($user);
        }
    }
}
