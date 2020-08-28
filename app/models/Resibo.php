<?php
/**
 * Created by PhpStorm.
 * User: gczasuncion
 * Date: 10/18/2018
 * Time: 2:55 PM
 */

class Resibo extends \Eloquent
{

    protected $table = 'resibo';

    public static function getAll()
    {
        return $results = DB::select("SELECT 
                                        `r`.`id`  AS resibo_id, 
                                        r.delivered_to,
                                        r.`delivered_address`,
                                        DATE_FORMAT(r.`resibo_date`,'%e %b %Y') AS resibo_date,
                                        r.bs_no AS bs_no,
                                        r.po_no,
                                        or_no,
                                        SUM(rt.`income_amount`) AS income_amount
                                        FROM `resibo` AS r
                                        RIGHT JOIN `resibo_transactions` AS rt ON rt.`resibo_id` = r.`id` 
                                        WHERE r.id != 1
                                        GROUP BY r.id
                                    ", array());
    }

    public static function getLastOR()
    {
        return $results = DB::select("SELECT SUM(`r`.`id`), LPAD((r.`or_no`+1),6,0) AS last_or 
                                        FROM `resibo` AS r
                                        RIGHT JOIN `resibo_transactions` AS rt ON rt.`resibo_id` = r.`id` 
                                        GROUP BY r.id
                                        ORDER BY r.id 
                                        DESC LIMIT 1  ", array());
    }

    public static function insertNewTransaction()
    {
        $item = New Resibo;
        $item->or_no = Resibo::getLastOR()[0]->last_or;
        $item->save();
        return $item->id;
    }

    public static function getResibo($id)
    {
        return DB::table('resibo')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }

    public static function updateResibo($id)
    {
        $invoice = Resibo::find($id);
        $invoice->delivered_to      = Input::get('delivered_to');
        $invoice->resibo_date       = Input::get('resibo_date');
        $invoice->bs_no             = Input::get('bs_no');
        $invoice->po_no             = Input::get('po_no');
        $invoice->or_no             = Input::get('or_no');
        $invoice->received_by             = Input::get('received_by');
        $invoice->delivered_address = Input::get('delivered_address');

        //Save items
        ResiboTransactions::where('resibo_id', '=',$id)->delete();
        foreach($_POST['qty'] as $key => $value)
        {
            if($_POST['income_amount'][$key]!='0.00') {
                $items = New ResiboTransactions;
                $items->resibo_id = $id;
                $items->qty = $_POST['qty'][$key];
                $items->unit = $_POST['unit'][$key];
                $items->batch_no = $_POST['batch_no'][$key];
                $items->articles = $_POST['articles'][$key];
                $items->unit_price = str_replace(',', '', $_POST['unit_price'][$key]);
                $items->income_amount = str_replace(',', '', $_POST['income_amount'][$key]);
                $items->save();
            }
        }

        $invoice->save();

    }

    public static function destroy($id)
    {
        $transaction = Resibo::find($id);
        $transaction->delete();
        ResiboTransactions::where('resibo_id', '=', $id)->delete();
    }

}