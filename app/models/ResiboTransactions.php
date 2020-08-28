<?php
/**
 * Created by PhpStorm.
 * User: gczasuncion
 * Date: 10/22/2018
 * Time: 4:33 PM
 */

class ResiboTransactions extends \Eloquent {

    protected $table    = 'resibo_transactions';

    public static function getResiboItems($id)
    {
        return DB::table('resibo_transactions')
            ->select('*')
            ->where('resibo_id', '=', $id)
            ->orderBy('resibo_transactions.income_amount', 'DESC')
            ->get();
    }

}