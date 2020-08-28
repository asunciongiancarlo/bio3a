<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Client extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
    protected $table  = 'clients';

    public static function showUser($userID)
    {
        return Client::find($userID)->first();
    }


    public static function storeUser()
    {
        //SAVE Client
        $client              = New Client;
        $client->client_name = Input::get('client_name');
        $client->save();
    }

    public static function updateUser()
    {
        $user            = Client::find(Input::get('id'));
        $user->client_name  = Input::get('client_name');
        $user->save();
    }

    public static function editUser($userID)
    {
        return Client::find($userID);
    }

    public static function destroyUser($userID)
    {
        $user = Client::find($userID);
        $user->delete();
    }

}
