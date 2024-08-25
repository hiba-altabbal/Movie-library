<?php

namespace App\Services;

use App\Models\User;

class UserService
{   /**
    *function to create new user 
    *@param data of user that i want to insert in table(user) 
    */
    public function createUser($data)
    {
        return User::create($data);
    }
    

    /**
     * function to update existing movie
     * @param user i want to update
     * @param newly data
     * @return user after update
     */
    public function updateUser(User $user, $data)
    {
        $user->update($data);
        return $user;
    }
    
    /**
     * function to delete user
     * @param user i want to delete
     * @return null
     */
    public function deleteUser(User $user)
    {
        $user->delete();
    }
}


?>