@extends('layouts/default')
@section('content')
    <h3>Transaction Details</h3>
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
    $_id             = json_decode(json_encode($data['invoice_details'][0]),true);
    $purchased_items = json_decode(json_encode($data['purchased_items']),true);
    $payments        = json_decode(json_encode($data['payments']),true);
    echo 	Form::open(array('url'=>"transactions/$invoice_id/edit",'files'=>true, 'class'=>'invoiceForm'));
    echo	Form::hidden('id');
    ?>

    <!-- Phil 4:13 -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Client Name</label>
                <select name="client_id" class="form-control" data-parsley-required id="exampleSelect1">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id  }}" {{ ($_id['client_id'])==$client->id ? 'selected' : ''  }}  > {{ $client->client_name  }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="example-datetime-local-input">Date</label>
                <input name="invoice_date" class="form-control datepicker" data-parsley-required type="date-local" value="{{ $_id['invoice_date']  }}" >
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="example-datetime-local-input">Due Date</label>
                <input name="invoice_due_date" class="form-control datepicker2" data-parsley-required type="date-local" value="{{ $_id['invoice_due_date']  }}" >
            </div>
        </div>
        <div class="col-md-3">
            <label for="exampleInputEmail1">DR/BS</label>
            <input name="invoice_number" type="text" class="form-control" data-parsley-required id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $_id['invoice_number']  }}" placeholder="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Invoice Status</label>
                <select name="invoice_status" data-parsley-required class="form-control">
                    <option value="Awaiting Payment"  {{  ($_id['invoice_status'])=='Awaiting Payment' ? 'selected' : '' }}>Awaiting Payment</option>
                    <option value="Due" {{  ($_id['invoice_status'])=='Due' ? 'selected' : '' }}>Due</option>
                    <option value="Paid" {{  ($_id['invoice_status'])=='Paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Invoice Image</label>
                <label class="custom-file">
                    <input type="file" id="file" name="invoice_image" class="custom-file-input">
                    <span class="custom-file-control"></span>
                </label>
                <?php  if($_id['invoice_image']): ?>
                    <label> {{ link_to("/img/invoices/".$_id['invoice_image'], 'Invoice Preview', array('target'=>'_blank')) }}  </label>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <label for="exampleSelect1">Invoice Note</label>
            <textarea name="invoice_note" data-parsley-required class="form-control" rows="3">{{ $_id['invoice_note'] }}</textarea>
        </div>
    </div>
    <hr/>
    <label>Items List</label>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Item Name</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Quantity</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Unit Price</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Income Type</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Amount</label>
            </div>
        </div>
    </div>

    <div class="item-lists">
        <div class="row item-list-row">
            <div class="col-md-2">
                <div class="form-group">
                    <select name="item_id[]" class="form-control">
                        @foreach ($items as $item)
                            <option value="{{ $item->id  }}"> {{ $item->item_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="quantity_no[]" class="form-control">
                                <?php  for($int_ctr=1; $int_ctr<=1000; $int_ctr++ ){
                                    echo "<option value='$int_ctr'> $int_ctr </option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <select name="quantity_id[]" class="form-control">
                                @foreach ($item_quantity as $iq)
                                    <option value="{{ $iq->id  }}"> {{ $iq->quantity_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input name="unit_price[]" type="text" class="form-control tl" aria-describedby="emailHelp" placeholder="" value="0.00">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select name="income_type[]" class="form-control">
                        <option value="3A" >3A</option>
                        <option value="BIO">BIO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-8 tl">
                        <div class="form-group">
                            <input name="income_amount[]" type="text" class="form-control tl"  aria-describedby="emailHelp" placeholder="" value="0.00">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-item-row" title="Delete item">x</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach($purchased_items  as $pi)
            <div class="row item-list-row">
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="item_id[]" class="form-control">
                            @foreach ($items as $item)
                                <option value="{{ $item->id  }}"  {{ ($pi['item_id']==$item->id) ? 'selected' : ''   }}> {{ $item->item_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="quantity_no[]" class="form-control">
                                    <?php  for($int_ctr=1; $int_ctr<=1000; $int_ctr++ ){
                                        $selected = ($pi['quantity_no']==$int_ctr) ? 'selected' : '';

                                            echo "<option value='$int_ctr' $selected> $int_ctr </option>";

                                        $selected = '';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <select name="quantity_id[]" class="form-control">
                                    @foreach ($item_quantity as $iq)
                                        <option value="{{ $iq->id  }}"  {{ ($pi['quantity_id']==$iq->id) ? 'selected' : ''  }}> {{ $iq->quantity_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input name="unit_price[]" type="text" class="form-control tl" value="{{ number_format($pi['unit_price'],2)  }}"  aria-describedby="emailHelp" placeholder="" value="0.00">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="income_type[]" class="form-control">
                            <option value="3A" {{ ($pi['income_type']=="3A") ? 'selected' : ''  }}>3A</option>
                            <option value="BIO" {{ ($pi['income_type']=="BIO") ? 'selected' : ''  }}>BIO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-8 tl">
                            <div class="form-group">
                                <input name="income_amount[]" type="text" class="form-control tl"  aria-describedby="emailHelp" placeholder="" value="{{ number_format($pi['income_amount'],2) }}">
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

        @foreach($payments as $payment)
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
                        <label for="exampleSelect1"><div class="payment_date"> Date: {{ $payment['payment_date']  }} </div></label><br/> <input name="payment_date[]" type="hidden" value="{{ $payment['payment_date']  }}">
                        <label for="exampleSelect1"><div class="payment_reference"> Reference: {{ $payment['payment_reference']  }} </div></label><br/> <input name="payment_reference[]" type="hidden" value="{{ $payment['payment_reference']  }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-8 tl">
                            <div class="form-group">
                                <label for="exampleSelect1"><div class="payment_amount">₱ {{ number_format($payment['payment_amount'],2)  }}</div></label><br/> <input name="payment_amount[]" value="{{ $payment['payment_amount']  }}" type="hidden">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger delete_payment" title="Delete payment">x</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="row">
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
    <label>Receive Payment</label>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Date Paid</label>
                <input name="receive_payment_date" type="text" class="form-control datepicker3"  aria-describedby="emailHelp" placeholder="">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleSelect1">Amount</label>
                <input name="receive_payment_amount" type="text" class="form-control" aria-describedby="emailHelp" placeholder="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleSelect1">Payment Reference</label>
                <input name="receive_payment_reference" type="text" class="form-control"  aria-describedby="emailHelp" placeholder="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="button" class="btn btn-primary add-payment">Add Payment</button>
                <button type="button" class="btn btn-primary back-to-list">Back to List</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

    <?php echo 	Form::close(); ?>
    <script type="text/javascript">
        $(document).ready(function(){

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
                $($item_row).find("input[type=text]").val("0.00");
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
            margin-left: 90px;
        }

    </style>
@stop



