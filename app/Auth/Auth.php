<?php

namespace App\Auth;

use Exception;
use App\Cookie\CookieJar;
use App\Auth\Hashing\Hasher;
use App\Session\SessionStore;
use App\Auth\Providers\UserProvider;

class Auth
{
    protected $user;
    protected $hash;
    protected $cookie;
    protected $session;
    protected $recaller;
    protected $userProvider;

    public function __construct(
        UserProvider $userProvider,
        Hasher $hash,
        SessionStore $session,
        CookieJar $cookie,
        Recaller $recaller
    )
    {
        $this->user = $user;
        $this->hash = $hash;
        $this->cookie = $cookie;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->userProvider = $userProvider;
    }

    public function attempt($username, $password, $remember = false)
    {
        $user = $this->userProvider->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }
        if ($this->needsRehash($user)) {
            $this->userProvider->updateUserPasswordHash($user->id, $this->hash->create($password));
        }
        $this->setUserSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }
        return true;
    }

    protected function hasValidCredentials($user, $password)
    {
        return $this->hash->check($password, $user->password);
    }

    protected function setUserSession($user)
    {
        $this->session->set($this->key(), $user->{$this->key()});
    }

    public function user()
    {
        return $this->user;
    }

    public function check()
    {
        return $this->hasUserInSession();
    }

    public function hasUserInSession()
    {
        return $this->session->exists($this->key());
    }

    public function setUserFromSession()
    {
        $user = $this->userProvider->getById($this->session->get($this->key()));
        if (!$user) {
            throw new Exception();
        }
        $this->user = $user;
    }

    public function logout()
    {
        $this->userProvider->clearUserRememberToken($this->user->id);
        $this->cookie->clear('remember');
        $this->session->clear($this->key());
    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
    }

    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->recaller->splitCookieValue(
            $this->cookie->get('remember')
        );
        // clear cookie if user does not exists
        if (!$user = $this->userProvider->getUserByRememberIdentifier($identifier)) {
            $this->cookie->clear('remember');
            return;
        }
        if (!$this->recaller->validateToken($token, $user->remember_token)) {
            // clear remember token & identifier in db for that user
            $this->userProvider->clearUserRememberToken($user->id);
            // clear cookie
            $this->cookie->clear('remember');
            throw new Exception();
        }
        // sign user in by setting user session
        $this->setUserSession($user);
    }

    protected function key()
    {
        return 'id';
    }

    protected function needsRehash($user)
    {
        return $this->hash->needRehash($user->password);
    }

    protected function setRememberToken($user)
    {
        list($identifier, $token) = $this->recaller->generate();
        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));
        $this->userProvider->setUserRememberToken($user->id, $identifier, $this->recaller->getTokenHashForDatabase($token));
    }
}