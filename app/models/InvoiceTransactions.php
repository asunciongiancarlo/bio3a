<?php

class InvoiceTransactions extends \Eloquent {

    protected $table    = 'invoices_transactions';

    public static function getPurchasedItems($id)
    {
        return DB::table('invoices_transactions')
            ->select('*')
            ->where('invoice_id', '=', $id)
            ->orderBy('invoices_transactions.income_amount', 'DESC')
            ->get();
    }

}