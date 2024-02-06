<?php

namespace App\Providers;


use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class MiDataProvider extends AbstractProvider implements Provider
{
    protected $scopes = ['email', 'name', 'with_roles'];

    protected $scopeSeparator = ' ';


    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://pbs.puzzle.ch/oauth/authorize', $state);
    }


    protected function getTokenUrl()
    {
        return 'https://pbs.puzzle.ch/oauth/token';
    }

    protected function getUserByToken($token)
    {

        $response = $this->getHttpClient()->get('https://pbs.puzzle.ch/oauth/profile', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'X-Scope' => 'with_roles',
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['nickname'],
            'firstname' => $user['first_name'],
            'lastname' => $user['last_name'],
            'email' => $user['email'],
        ]);
    }


}
