@extends('layouts/default')
@section('content')
    <br/>
    <h3>Invoice Details</h3>
    <?php
    extract($data);
    if(Session::get('message')){
        echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
    }
    ?>

    <?php
    extract($data);
    $_id             = json_decode(json_encode($data['resibo_details'][0]),true);
    $resibo_items    = json_decode(json_encode($data['resibo_items']),true);
    echo 	Form::open(array('url'=>"resibo/$invoice_id/edit",'files'=>true, 'class'=>'invoiceForm'));
    echo	Form::hidden('id', $_id['id']);
    ?>
    <!-- Phil 4:13 -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Delivered To</label>
                <input name="delivered_to" type="text" class="form-control" data-parsley-required value="{{ $_id['delivered_to']  }}" placeholder="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="example-datetime-local-input">Date</label>
                <input name="resibo_date" class="form-control datepicker" data-parsley-required type="date-local" value="{{ $_id['resibo_date']  }}" autocomplete="off">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="example-datetime-local-input">BS No.</label>
                <input name="bs_no" class="form-control" data-parsley-required value="{{ $_id['bs_no']  }}" >
            </div>
        </div>
        <div class="col-md-2">
            <label for="exampleInputEmail1">PO No.</label>
            <input name="po_no" type="text" class="form-control" data-parsley-required  value="{{ $_id['po_no']  }}" placeholder="">
        </div>
        <div class="col-md-2">
            <label for="exampleInputEmail1">OR No.</label>
            <input name="or_no" type="text" class="form-control" data-parsley-required value="{{ $_id['or_no']  }}" placeholder="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Address</label>
                <textarea name="delivered_address" data-parsley-required class="form-control" rows="3">{{ $_id['delivered_address'] }}</textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Received By</label>
                <input name="received_by" type="text" class="form-control" data-parsley-required  value="{{ $_id['received_by']  }}" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <label for="exampleSelect1"></label>
        </div>
    </div>
    <hr/>
    <label>Entries </label>
    <div class="row">
        <div class="col-md-1">
            <div class="form-group">
                <label for="exampleSelect1">QUANTITY</label>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="exampleSelect1">UNIT</label>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="exampleSelect1">BATCH NO.</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleSelect1">ARTICLES</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">UNIT PRICE</label>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="exampleSelect1">PRICE</label>
            </div>
        </div>
    </div>

    <div class="item-lists">
        <div class="row item-list-row">
            <div class="col-md-1">
                <div class="form-group">
                    <select name="qty[]" class="form-control">
                        <?php  for($int_ctr=1; $int_ctr<=10000; $int_ctr++ ){
                            echo "<option value='$int_ctr'> $int_ctr </option>";
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <input name="unit[]" type="text" class="form-control" data-parsley-required  placeholder="">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <input name="batch_no[]" type="text" class="form-control" data-parsley-required  placeholder="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <textarea name="articles[]" data-parsley-required class="form-control" rows="1"></textarea>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input name="unit_price[]" type="text monetary_value" class="form-control tl" aria-describedby="emailHelp" placeholder="" value="0.00">
                </div>
            </div>
            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-8 tl">
                        <div class="form-group">
                            <input name="income_amount[]" type="text monetary_value" class="form-control tl"  placeholder="" value="0.00">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-item-row" title="Delete item">x</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach($resibo_items  as $pi)
            <div class="row item-list-row">
                <div class="col-md-1">
                    <div class="form-group">
                        <select name="qty[]" class="form-control">
                            <?php  for($int_ctr=1; $int_ctr<=10000; $int_ctr++ ){
                                $selected = ($pi['qty']==$int_ctr) ? 'selected' : '';
                                echo "<option value='$int_ctr' $selected > $int_ctr </option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <input name="unit[]" type="text" class="form-control" data-parsley-required value="{{ $pi['unit'] }}" placeholder="">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <input name="batch_no[]" type="text" class="form-control" data-parsley-required value="{{ $pi['batch_no'] }}" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <textarea name="articles[]" data-parsley-required class="form-control" rows="1">{{ $pi['articles'] }}</textarea>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input name="unit_price[]" type="text" class="form-control tl" value="{{ number_format($pi['unit_price'],2)  }}"  aria-describedby="emailHelp" placeholder="" value="0.00">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-8 tl">
                            <div class="form-group">
                                <input name="income_amount[]" type="text" type="text monetary_value" class="form-control tl"  aria-describedby="emailHelp" placeholder="" value="{{ number_format($pi['income_amount'],2) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger remove-item-row" title="Delete item">x</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr/>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"><button type="button" class="btn btn-primary add-new-item">Add New Item</button></label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group" style="text-align: right">
                <label for="exampleSelect1"><b>Total Amount: </b></label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1"><b class="total_amount_div">₱ 0.00</b></label>
            </div>
        </div>
    </div>

    <div class="payment_lists">
        <div class="row payment_row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-3 less_payment_div">
            <div class="form-group">
                <label for="exampleSelect1">Less Payment</label><br/>
                <label for="exampleSelect1"><div class="payment_date"></div></label><br/> <input name="payment_date[]" type="hidden">
                <label for="exampleSelect1"><div class="payment_reference"></div></label><br/> <input name="payment_reference[]" type="hidden">
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-8 tl">
                    <div class="form-group">
                        <label for="exampleSelect1"><div class="payment_amount"></div></label><br/> <input name="payment_amount[]" value="0.00" type="hidden">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger delete_payment" title="Delete payment">x</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                {{--<label for="exampleSelect1"><button type="button" class="btn btn-primary print-preview">Print Preview</button></label>--}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1"></label>
            </div>
        </div>
        <div class="col-md-3 border-top-class" >
            <div class="form-group" style="margin-bottom: 0px">
                <label for="exampleSelect1" class="amount_due_div">AMOUNT DUE</label>
            </div>
        </div>
        <div class="col-md-3 border-top-class">
            <div class="form-group" style="margin-bottom: 0px">
                <label for="exampleSelect1" class="amount_due_div"> <div class="amount_due" style="margin-left: 74px;">P 0.00</div></label>
            </div>
        </div>
    </div>

    <hr/>
    <div id="receive-payment-div">
        <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-2">

        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-3">
            <div class="form-group">

            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <button type="button" class="btn submit-form btn-primary">Save Changes</button>
                <button type="button" class="btn print-form btn-success">Print </button>
            </div>
        </div>
    </div>
    <div>
    <?php echo 	Form::close(); ?>
    <script type="text/javascript">
        $(document).ready(function(){


            $('.print-preview').on('click', function(){
                $('.navbar, .btn, #receive-payment-div').toggle();
                $('body').css('background-color','#ffffff!important');
            });

            $('.submit-form').on('click', function(){
                if ($('input[name="invoice_date"]')!="")
                    $(".invoiceForm").submit();
                else
                    alert('Please add invoice date');
            });

            $('.print-form').on('click', function(){
                var resibo_id = $('input:hidden[name=id]').val();
                window.open("/invoice_pdf/"+resibo_id+"/view","_blank");
            });

            $('.back-to-list').on('click', function(){
                window.location.href = '{{  URL::to('transactions') }}';
            });

            $(".invoiceForm .datepicker, .datepicker2, .datepicker3").datepicker({
                dateFormat: 'yy-mm-dd'
            });

            //Add new item
            $('.add-new-item').on('click', function(){
                $('select').select2('destroy');
                var $item_row = $('.item-list-row').first().clone();
                $($item_row).find("input[type=monetary_value]").val("0.00");
                $($item_row).find("select[name='quantity_no[]'], select[name='quantity_id[]']").val("1");
                $('.item-lists').append($item_row);
                A3init();
            });

            //Add payment
            $('.add-payment').on('click', function(){

                //Get variables
                var receive_payment_date      = $("input[name='receive_payment_date']").val();
                var receive_payment_amount    = $("input[name='receive_payment_amount']").val().replace(/,/g, '');
                var receive_payment_reference = $("input[name='receive_payment_reference']").val();
                console.log(receive_payment_amount);
                if(receive_payment_date == "" || receive_payment_amount== "" || receive_payment_reference== "") {

                    alert('Please check payment date, amount and reference it should not be null.');
                }else {
                    if (isNaN(receive_payment_amount) == true)
                        receive_payment_amount = parseFloat('0').toFixed(2);
                    else
                        receive_payment_amount = parseFloat(receive_payment_amount).toFixed(2);


                    var $payment_row = $('.payment_row').first().clone();
                    $($payment_row).find(".payment_amount").html('₱ ' + numberWithCommas(parseFloat(receive_payment_amount).toFixed(2)));
                    $($payment_row).find("input[name='payment_amount[]']").val(parseFloat(receive_payment_amount).toFixed(2));
                    $($payment_row).find(".payment_date").html('Date: ' + receive_payment_date);
                    $($payment_row).find("input[name='payment_date[]']").val(receive_payment_date);
                    $($payment_row).find(".payment_reference").html('Reference: ' + receive_payment_reference);
                    $($payment_row).find("input[name='payment_reference[]']").val(receive_payment_reference);
                    $('.payment_lists').append($payment_row);

                    $("input[name='receive_payment_date'], input[name='receive_payment_amount'], input[name='receive_payment_reference']").val("");

                    A3init();
                    computeTotalAmount();
                }
            });

            A3init();
            computeTotalAmount();

            //$('.invoiceForm').parsley();
        });

        //remove item
        function A3init()
        {
            //Compute total amount based when quantity no is changes
            $("select[name='qty[]']").on('change', function(){
                var unit_price = $(this).closest('.item-list-row').find("input[name='unit_price[]']");

                console.log(unit_price.val);

                var quantity_no = $(this).val();
                var total_amount_holder = $(this).closest('.item-list-row').find("input[name='income_amount[]']");

                console.log(unit_price);

                unit_price = $(unit_price).val();
                unit_price = parseFloat(unit_price.replace(/,/g, ''));
                var total_amount = quantity_no * unit_price;

                total_amount = parseFloat(total_amount).toFixed(2);
                console.log(total_amount);
                $(total_amount_holder).val(numberWithCommas(parseFloat(total_amount).toFixed(2)));
                computeTotalAmount();
            });

            //Compute unit price when unit price is changes
            $("input[name='unit_price[]']").on('keyup', function(){
                var unit_price = $(this).val();
                var x = $(this).closest('.item-list-row').find('select')[0];
                var total_amount_holder = $(this).closest('.item-list-row').find("input[name='income_amount[]']");

                console.warn(total_amount_holder.val());

                var quantity = $(x).val();
                unit_price = parseFloat(unit_price.replace(/,/g, ''));
                var total_amount = quantity * unit_price;

                total_amount = parseFloat(total_amount).toFixed(2);

                $(total_amount_holder).val(numberWithCommas(parseFloat(total_amount).toFixed(2)));
                computeTotalAmount();
            });

            $('select').select2();

            $("input[name='income_amount[]'], input[name='receive_payment_amount'], input[name='unit_price[]']").ForceNumericOnly();

            $('.remove-item-row').on('click', function(){
                if($('.remove-item-row').length==1) {
                    return alert('Save at least one item.');
                }else {
                    $(this).closest('.item-list-row').remove();
                    computeTotalAmount();
                }
            });

            $('.delete_payment').on('click', function(){
                $(this).closest('.payment_row').remove();
                computeTotalAmount();
            });

            $("input[name='income_amount[]']").on('keyup',function(){
                computeTotalAmount();
            });

           // $('.invoiceForm').parsley().destroy();
           // $('.invoiceForm').parsley();
        }

        function computeTotalAmount()
        {
            //Compute total amount
            var totalAmount = 0.00;
            $("input[name='income_amount[]']").each(function(){
                totalAmount += parseFloat($(this).val().replace(/,/g, ''));
            });

            if(isNaN(totalAmount)==true)
                totalAmount = parseFloat('0').toFixed(2);
            else
                totalAmount = parseFloat(totalAmount).toFixed(2);

            $('.total_amount_div').html('₱ '+ numberWithCommas(totalAmount));

            var totalPayment = 0.00;
            $("input[name='payment_amount[]']").each(function(){
                totalPayment += parseFloat($(this).val().replace(/,/g, ''));
            });

            console.log('totalpayment'+totalPayment);

            if(isNaN(totalPayment)==true)
                totalPayment = parseFloat('0').toFixed(2);
            else
                totalPayment = parseFloat(totalPayment).toFixed(2);

            var totalDue = totalAmount - totalPayment;
            $('.amount_due').html('₱ ' + numberWithCommas(parseFloat(totalDue).toFixed(2)));
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        jQuery.fn.ForceNumericOnly =
        function()
        {
            return this.each(function()
            {
                $(this).keydown(function(e)
                {
                    var key = e.charCode || e.keyCode || 0;
                    // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                    // home, end, period, and numpad decimal
                    return (
                    key == 8 ||
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    key == 188 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
                });
            });
        };

    </script>
    <style>
        .payment_row:first-child, .item-list-row:first-child{
            display: none!important;
        }

        .amount_due_div{
            font-size: 26px!important;
        }

        .less_payment_div{
            text-align: right;
        }

        .less_payment_div  > .form-group >label{
            font-weight: normal;
        }

        .border-top-class{
            border-top: 1px solid gray;
            border-bottom: 5px solid gray;
            margin-bottom: 0px;
        }

        .less_payment_div{
            border-top: 1px dotted black;
            padding-top: 10px;
        }

        .less_payment_div + div{
            border-top: 1px dotted black;
            padding-top: 10px;
        }

        .payment_amount{
            color: rgba(0, 0, 255, 0.88);
        }

        .tl{
            text-align: right;
        }

        .total_amount_div{
            margin-left: 114px;
        }

    </style>
@stop



