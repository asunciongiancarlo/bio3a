<?php

class InvoicePayment extends \Eloquent {

    protected $table    = 'invoice_payment';

    public static function getPurchasedItems($id)
    {
        return DB::table('invoice_payment')
            ->select('*')
            ->where('invoice_id', '=', $id)
            ->orderBy('invoice_payment.payment_date', 'DESC')
            ->get();
    }
}