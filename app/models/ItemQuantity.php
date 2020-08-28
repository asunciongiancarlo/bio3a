<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class ItemQuantity extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
    protected $table  = 'item_quantity';

    public static function showUser($userID)
    {
        return ItemQuantity::find($userID)->first();
    }


    public static function storeUser()
    {
        //SAVE ItemQuantity
        $client                = New ItemQuantity;
        $client->quantity_name = Input::get('quantity_name');
        $client->save();
    }

    public static function updateUser()
    {
        $user               = ItemQuantity::find(Input::get('id'));
        $user->quantity_name  = Input::get('quantity_name');
        $user->save();
    }

    public static function editUser($userID)
    {
        return ItemQuantity::find($userID);
    }

    public static function destroyUser($userID)
    {
        $user = ItemQuantity::find($userID);
        $user->delete();
    }

}
