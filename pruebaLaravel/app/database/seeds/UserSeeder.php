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
                // learned that the Hash::make function uses a random salt by default, 
                // wich it stores along with the hash itself. no need to store the salt
                // in a separate db column then.
                'password' => Hash::make("password"),
                'email' => 'depowerwer@gmail.com'
            ],
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
