<?php
use Illuminate\Support\Collection;

class ItemQuantityController extends BaseController {

    public function index()
    {
        $data['users']   = ItemQuantity::all();
        return View::make('item_quantity.index')->with('data',$data);
    }


    public function create()
    {
        $data['userData'] = array();
        return View::make('users.create')->with(['data'=>$data]);
    }

    public function edit($id)
    {
        $data['userData'] = ItemQuantity::editUser($id);
        $data['users']   = ItemQuantity::all();
        return View::make('item_quantity.index')->with(['data'=>$data]);
    }

    public function store()
    {
        ItemQuantity::storeUser(Input::all());
        Session::flash('message', 'Item quantity was created');
        return Redirect::route('item_quantity.index');
    }

    public function update()
    {
        ItemQuantity::updateUser(Input::all());
        Session::flash('message', 'Item quantity was updated');
        return Redirect::route('item_quantity.index');
    }

    public function destroy($userID)
    {
        ItemQuantity::destroyUser($userID);
        Session::flash('message', 'Item quantity was deleted');
        return Response::json(array('ok'));
    }


}
?>