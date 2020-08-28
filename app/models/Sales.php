<?php

class Sales extends \Eloquent
{

    protected $table = 'invoices';

    public static function getAll()
    {
        $cond = "AND `inv`.`invoice_date` >= '".date('Y-01-31')."' and `inv`.`invoice_date`<= '".date('Y-12-31')."'";
        if(!empty(Input::get('date_from')))
            $cond = "AND `inv`.`invoice_date` >= '".Input::get('date_from')."' and `inv`.`invoice_date`<= '".Input::get('date_to')."'";


        return $results = DB::select(" SELECT
                                        i.item_name,
                                        iq.`quantity_name`,
                                        it.`quantity_no`,
                                        it.`unit_price`,
                                        it.`income_type`,
                                        it.`income_amount`,
                                        inv.`invoice_dr`,
                                        inv.`invoice_bs`,
                                        c.`client_name`,
                                        DATE_FORMAT(inv.`invoice_date`,'%e %b %Y') AS invoice_date,
                                        DATE_FORMAT(inv.`invoice_due_date`,'%e %b %Y') AS invoice_due_date,
                                        IF((inv.`invoice_status`)!='Paid',
                                        CONCAT(DATEDIFF(inv.`invoice_due_date`,CURDATE()),' day/s'),('0 day/s')) AS due_date,
                                        inv.`invoice_status`
                                     FROM  `invoices_transactions` it LEFT JOIN `items` i ON i.`id` = it.`item_id`
                                     LEFT JOIN `item_quantity` iq ON iq.`id` = it.`quantity_id`
                                     LEFT JOIN `invoices` inv ON inv.`id` = it.`invoice_id`
                                     LEFT JOIN `clients` c ON c.`id` = inv.`client_id`
                                     WHERE inv.`invoice_date` != '' $cond
                                     GROUP BY it.`id`
                                    ", array());
    }


}