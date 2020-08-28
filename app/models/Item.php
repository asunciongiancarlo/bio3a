<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Item extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
    protected $table  = 'items';


    public static function getAll()
    {
        return DB::table('items')
            ->select('*','id as i_id')
            ->get();
    }

    public static function showUser($userID)
    {
        return Item::find($userID)->first();
    }

    public static function storeUser()
    {
        //SAVE Client
        $client              = New Item;
        $client->item_name   = Input::get('item_name');
        $client->save();
    }

    public static function updateUser()
    {
        $client              = Item::find(Input::get('id'));
        $client->item_name   = Input::get('item_name');
        $client->save();
    }

    public static function editUser($userID)
    {
        return Item::find($userID);
    }

    public static function destroyUser($userID)
    {
        $user = Item::find($userID);
        $user->delete();
    }

}
