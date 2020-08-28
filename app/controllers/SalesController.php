<?php
use Illuminate\Support\Collection;

class SalesController extends BaseController {

    public function index()
    {
        $data['items']           = Item::getAll();
        $data['clients']         = Client::all();

        $data['date_from'] = '';
        $data['date_to']   = '';
        $data['transactions']    = Sales::getAll(Input::all());

        return View::make('sales.index')->with('data',$data);
    }

    public function filter()
    {
        $data['date_from'] = '';
        $data['date_to']   = '';

        if (!empty(Input::get('date_from'))){
            $data['date_from'] = Input::get('date_from');
            $data['date_to']   = Input::get('date_to');
        }

        $data['transactions']    = Sales::getAll(Input::all());

        return View::make('sales.index')->with('data',$data);
    }
}
?>