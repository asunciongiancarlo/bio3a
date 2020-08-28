<?php
/**
 * Created by PhpStorm.
 * User: gczasuncion
 * Date: 10/15/2018
 * Time: 4:27 PM
 */
class ResiboController extends BaseController {

    public function index()
    {
        $data['transactions']    = Resibo::getAll(Input::all());
        return View::make('resibo.index')->with('data',$data);
    }


    public function create()
    {
        $id = Resibo::insertNewTransaction();
        return Redirect::to("resibo/$id/edit");
    }

    public function edit($id)
    {
        $data['invoice_id']      = $id;
        $data['resibo_details']  = Resibo::getResibo($id);
        $data['resibo_items']    = ResiboTransactions::getResiboItems($id);

        if($_POST){
            Resibo::updateResibo($id);
            return Redirect::to("resibo/$id/edit")->with('message', 'Transaction has been save.');
        }

        return View::make('resibo.create')->with(['data'=>$data]);
    }

    public function destroy($userID)
    {
        Resibo::destroy($userID);
        Session::flash('message', 'Transaction was deleted');
        return Response::json(array('ok'));
    }


}