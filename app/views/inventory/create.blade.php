@extends('layouts/default')
@section('content')
<br/>
<h3>Inventory Details</h3>

<span style="
    color: red;
">*Please make sure that there is no duplicate entry of Product and Unit of Measurement on the inventory summary, to achieve accurate report.</span>
<br/>
<?php
extract($data);
if(Session::get('message')){
    echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
}

$_id = json_decode(json_encode($data['inventory_details'][0]),true);
?>

<?php
if($inventory_id==0)
    $url = "inventory/create";
else
    $url = "inventory/$inventory_id/edit";

echo 	Form::open(array('url'=>$url,'files'=>true, 'class'=>'invoiceForm'));
echo	Form::hidden('id');
?>

<!-- Phil 4:13 -->
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleSelect1">Product Name</label>
            <select name="product_id" class="form-control">
                @foreach ($items as $item)
                    <option value="{{ $item->id  }}" {{ ($_id['product_id'])==$item->id ? 'selected' : ''  }} > {{ $item->item_name }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="example-datetime-local-input">Unity of Measurement</label>
            <select name="quantity_id" class="form-control">
                @foreach ($item_quantity as $iq)
                    <option value="{{ $iq->id  }}" {{ ($_id['quantity_id'])==$iq->id ? 'selected' : ''  }}> {{ $iq->quantity_name }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="example-datetime-local-input">Stock Quantity</label>
            <input name="stock_quantity" class="form-control" data-parsley-required data-parsley-type="integer" value="{{ $_id['stock_quantity']  }}" >
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="example-datetime-local-input">To Order</label>
            <select name="to_order" class="form-control">
                <option value="Yes" {{  ($_id['to_order'])=='Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{  ($_id['to_order'])=='Yes' ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleSelect1">Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ $_id['notes'] }}</textarea>
        </div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn submit-form btn-primary">Save Changes</button>
        </div>
    </div>
</div>


<?php echo 	Form::close(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.invoiceForm').parsley();
    });
</script>

@stop



