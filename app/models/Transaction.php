<?php

class Transaction extends \Eloquent
{

    protected $table = 'invoices';

    public static function getAll()
    {
       $cond = "AND `i`.`invoice_date` >= '".date('Y-01-31')."' and `i`.`invoice_date`<= '".date('Y-12-31')."'";
       if(!empty(Input::get('date_from')))
           $cond = "AND `i`.`invoice_date` >= '".Input::get('date_from')."' and `i`.`invoice_date`<= '".Input::get('date_to')."'";


       return $results = DB::select("SELECT
                                    i.`id` AS i_id,
                                    i.`invoice_dr`,
                                    i.`invoice_bs`,
                                    c.`client_name`,
                                    DATE_FORMAT(i.`invoice_date`,'%e %b %Y') AS invoice_date,
                                    DATE_FORMAT(i.`invoice_due_date`,'%e %b %Y') AS invoice_due_date,
                                    IF((i.`invoice_status`)!='Paid',
                                    CONCAT(DATEDIFF(i.`invoice_due_date`,CURDATE()),' day/s'),('0 day/s')) AS due_date,
                                    (
                                     SELECT SUM(`income_amount`) FROM `invoices_transactions` WHERE `invoice_id` = i.`id` GROUP BY `invoice_id`
                                    )AS total_amount,
                                    (
                                     SELECT SUM(`payment_amount`) FROM `invoice_payment` WHERE `invoice_id` = i.`id` GROUP BY `invoice_id`
                                    ) AS total_payment,
                                    (
                                    (SELECT SUM(`income_amount`) FROM `invoices_transactions` WHERE `invoice_id` = i.`id` GROUP BY `invoice_id`) -
                                     (SELECT SUM(`payment_amount`) FROM `invoice_payment` WHERE `invoice_id` = i.`id` GROUP BY `invoice_id`	)
                                    ) AS total_due,
                                    i.`invoice_status`
                                    FROM `invoices` i
                                    LEFT JOIN `invoice_payment` ip ON ip.`invoice_id` = i.`id`
                                    LEFT JOIN `invoices_transactions` it ON it.`invoice_id` = i.`id`
                                    LEFT JOIN `clients` c ON c.`id` = i.`client_id`
                                    WHERE i.`invoice_date` != '' $cond
                                    GROUP BY i.`id`
                                    ", array());
    }

    public static function insertNewTransaction()
    {
        $item = New Transaction;
        $item->save();
        return $item->id;
    }

    public static function getInvoice($id)
    {
        return DB::table('invoices')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }

    public static function updateInvoice($id)
    {
        $file = Input::file('blog_image');

        $invoice = Transaction::find($id);
        $invoice->client_id         = Input::get('client_id');
        $invoice->invoice_date      = Input::get('invoice_date');
        $invoice->invoice_due_date  = Input::get('invoice_due_date');
        $invoice->invoice_status    = Input::get('invoice_status');
        $invoice->invoice_note      = Input::get('invoice_note');
        $invoice->invoice_dr        = Input::get('invoice_dr');
        $invoice->invoice_bs        = Input::get('invoice_bs');

        //SAVE IMAGE
        if (Input::hasFile('invoice_image'))
        {
            $file            = Input::file('invoice_image');
            $destinationPath = 'img/invoices';
            $fileName = Str::random(12).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            $invoice->invoice_image = $fileName;
        }

        //Save items
        InvoiceTransactions::where('invoice_id', '=',$id)->delete();
        foreach($_POST['item_id'] as $key => $value)
        {
            if($_POST['income_amount'][$key]!='0.00') {
                $items = New InvoiceTransactions;
                $items->invoice_id = $id;
                $items->item_id = $value;
                $items->invoice_date = Input::get('invoice_date');
                $items->quantity_no = $_POST['quantity_no'][$key];
                $items->quantity_id = $_POST['quantity_id'][$key];
                $items->unit_price = str_replace(',', '', $_POST['unit_price'][$key]);
                $items->income_type = $_POST['income_type'][$key];
                $items->income_amount = str_replace(',', '', $_POST['income_amount'][$key]);

                if($invoice->update_inventory==1)
                    self::updateInventoryItem($value, $_POST['quantity_no'][$key], $_POST['quantity_id'][$key]);

                $items->save();
            }
        }

        $invoice->update_inventory = 0;
        $invoice->save();

        //Save invoices
        InvoicePayment::where('invoice_id', '=',$id)->delete();
        foreach($_POST['payment_date'] as $key => $value)
        {
            if($value!= '')
            {
                $items                    = New InvoicePayment;
                $items->invoice_id        = $id;
                $items->payment_date      = $value;
                $items->payment_amount    = $_POST['payment_amount'][$key];
                $items->payment_reference = $_POST['payment_reference'][$key];

                $items->save();
            }
        }
    }

    public static function updateInventoryItem($product_id, $quantity_no, $quantity_id)
    {
         //Check if item is found
        $inventory_item = DB::table('inventory')
                            ->select('*')
                            ->where('product_id', '=', $product_id)
                            ->where('quantity_id', '=', $quantity_id)
                            ->get();

        $inventory_item = json_decode(json_encode($inventory_item), True);

        if(count($inventory_item)==1){
            $item = Inventory::find($inventory_item[0]['id']);
            $item->stock_quantity = $inventory_item[0]['stock_quantity'] - $quantity_no;
            $item->save();
        }
    }

    public static function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        InvoiceTransactions::where('invoice_id', '=', $id)->delete();
        InvoicePayment::where('invoice_id', '=', $id)->delete();
    }

}