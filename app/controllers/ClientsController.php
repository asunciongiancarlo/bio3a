<?php
use Illuminate\Support\Collection;

class ClientsController extends BaseController {

    public function index()
    {
        $data['users']   = Client::all();
        return View::make('clients.index')->with('data',$data);
    }


    public function create()
    {
        $data['userData'] = array();
        return View::make('users.create')->with(['data'=>$data]);
    }

    public function edit($id)
    {
        $data['userData'] = Client::editUser($id);
        $data['users']   = Client::all();
        return View::make('clients.index')->with(['data'=>$data]);
    }

    public function store()
    {
        Client::storeUser(Input::all());
        Session::flash('message', 'Client was created');
        return Redirect::route('clients.index');
    }

    public function update()
    {
        Client::updateUser(Input::all());
        Session::flash('message', 'Client was updated');
        return Redirect::route('clients.index');
    }

    public function destroy($userID)
    {
        Client::destroyUser($userID);
        Session::flash('message', 'Client was deleted');
        return Response::json(array('ok'));
    }


}
?>