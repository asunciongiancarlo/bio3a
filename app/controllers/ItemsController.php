<?php
use Illuminate\Support\Collection;

class ItemsController extends BaseController {

    public function index()
    {
        $data['users']   = Item::getAll();
        return View::make('items.index')->with('data',$data);
    }


    public function create()
    {
        $data['userData'] = array();
        return View::make('items.create')->with(['data'=>$data]);
    }

    function edit($id)
    {
        $data['userData'] = Item::editUser($id);
        $data['users']   = Item::getAll();
        return View::make('items.index')->with(['data'=>$data]);
    }

    public function store()
    {
        Item::storeUser(Input::all());
        Session::flash('message', 'Item was created');
        return Redirect::route('items.index');
    }

    public function update()
    {
        Item::updateUser(Input::all());
        Session::flash('message', 'Item was updated');
        return Redirect::route('items.index');
    }

    public function destroy($userID)
    {
        Item::destroyUser($userID);
        Session::flash('message', 'Item was deleted');
        return Response::json(array('ok'));
    }


}
?>