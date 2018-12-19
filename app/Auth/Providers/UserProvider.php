<?php
namespace App\Auth\Providers;

interface UserProvider
{
    public function getById($id);

    public function getByUsername($username);

    public function getUserByRememberIdentifier($identifier);

    public function setUserRememberToken($id, $identifier, $hash);

    public function clearUserRememberToken($id);

    public function updateUserPasswordHash($id, $hash);

}