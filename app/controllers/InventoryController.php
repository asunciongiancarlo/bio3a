<?php
use Illuminate\Support\Collection;

class InventoryController extends BaseController {

    public function index()
    {
        $data['items']           = Inventory::getAll();
        return View::make('inventory.index')->with('data',$data);
    }

    public function create()
    {
        $data['items']           = Item::getAll();
        $data['item_quantity']   = ItemQuantity::all();
        $data['inventory_id']    = 0;
        $data['inventory_details'] = array(0);

        if($_POST){
            Inventory::add();
            return Redirect::to("inventory")->with('message', 'Transaction has been save.');
        }

        return View::make('inventory.create')->with(['data'=>$data]);
    }

    public function edit($id)
    {
        $data['inventory_id']      = $id;
        $data['items']           = Item::getAll();
        $data['item_quantity']   = ItemQuantity::all();
        $data['inventory_details'] = Inventory::getInventory($id);

        if($_POST){
            Inventory::updateInventory($id);
            return Redirect::to("inventory")->with('message', 'Transaction has been updated.');
        }

        return View::make('inventory.create')->with(['data'=>$data]);
    }

    public function destroy($userID)
    {
        Inventory::destroy($userID);
        Session::flash('message', 'Item was deleted');
        return Response::json(array('ok'));
    }


}
?>