<?php
/**
 * Created by PhpStorm.
 * User: gczasuncion
 * Date: 10/15/2018
 * Time: 3:10 PM
 */

class InvoicePDFController extends BaseController {

    public function index()
    {
        $data['items']           = Item::getAll();
        $data['clients']         = Client::all();

        $data['date_from'] = '';
        $data['date_to']   = '';
        $data['transactions']    = Transaction::getAll(Input::all());

        return View::make('transactions.index')->with('data',$data);
    }

    public function filter()
    {
        $data['date_from'] = '';
        $data['date_to']   = '';

        if (!empty(Input::get('date_from'))){
            $data['date_from'] = Input::get('date_from');
            $data['date_to']   = Input::get('date_to');
        }

        $data['transactions']    = Transaction::getAll(Input::all());

        return View::make('transactions.index')->with('data',$data);
    }


    public function create()
    {
        $id = Transaction::insertNewTransaction();
        return Redirect::to("transactions/$id/edit");
    }

    public function edit($id)
    {
        $data['invoice_id']      = $id;
        $data['items']           = Item::getAll();
        $data['item_quantity']   = ItemQuantity::all();
        $data['clients']         = Client::all();
        $data['invoice_details'] = Transaction::getInvoice($id);
        $data['purchased_items'] = InvoiceTransactions::getPurchasedItems($id);
        $data['payments']        = InvoicePayment::getPurchasedItems($id);

        if($_POST){
            Transaction::updateInvoice($id);
            return Redirect::to("transactions/$id/edit")->with('message', 'Transaction has been save.');
        }

        return View::make('transactions.create')->with(['data'=>$data]);
    }

//    public function destroy($userID)
//    {
//        Transaction::destroy($userID);
//        Session::flash('message', 'Transaction was deleted');
//        return Response::json(array('ok'));
//    }


    public function view($record_id = 0)
    {
//        print_r($record_id); die();
        $data['resibo_details']  = Resibo::getResibo($record_id);
        $data['resibo_items']    = ResiboTransactions::getResiboItems($record_id);

        //print_r($data); die();

        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('B4');
        return $pdf->stream('download.pdf');

    }

}