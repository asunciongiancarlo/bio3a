<?php

class Inventory extends \Eloquent
{

    protected $table = 'inventory';

    public static function getAll()
    {
        return $results = DB::select("SELECT  i.`id`, itm.`item_name`, qty.`quantity_name`, i.`stock_quantity`, i.`to_order`, i.`notes`
                                    FROM `inventory` i
                                    LEFT JOIN `items` itm ON itm.`id` = i.`product_id`
                                    LEFT JOIN `item_quantity` qty ON qty.`id` = i.`quantity_id`
                                    ", array());
    }

    public static function add()
    {
        $item = New Inventory();
        $item->product_id      = Input::get('product_id');
        $item->quantity_id     = Input::get('quantity_id');
        $item->stock_quantity  = Input::get('stock_quantity');
        $item->to_order        = Input::get('to_order');
        $item->notes           = Input::get('notes');
        $item->save();
        return $item->id;
    }

    public static function getInventory($id)
    {
        return DB::table('inventory')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }

    public static function updateInventory($id)
    {
        $item = Inventory::find($id);
        $item->product_id      = Input::get('product_id');
        $item->quantity_id     = Input::get('quantity_id');
        $item->stock_quantity  = Input::get('stock_quantity');
        $item->to_order        = Input::get('to_order');
        $item->notes           = Input::get('notes');

        $item->save();
    }

    public static function destroy($id)
    {
        $transaction = Inventory::find($id);
        $transaction->delete();
    }

}