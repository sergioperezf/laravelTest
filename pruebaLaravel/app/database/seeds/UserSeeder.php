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
                'username' => 'test',
                'password' => Hash::make("password"),
                'email' => 'seperezf@hotmail.com'
            ]
        ];
        foreach ($users as $user){
            User::create($user);
        }
    }
}
