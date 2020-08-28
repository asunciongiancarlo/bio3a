@extends('layouts/default')
@section('content')
<?php extract($data); ?>
    <h3>Transaction Details</h3>

{{ Form::open(array('url' => 'sales/filter', 'method'=>'post', 'class'=>'form-inline')) }}
    <div class="form-group">
        <label for="exampleInputName2">Date From</label>
        <input type="text" name="date_from" value="{{ $date_from }}" class="form-control datepicker1" id="exampleInputName2" placeholder="Enter Date From">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail2">Date To</label>
        <input type="text" name="date_to" value="{{ $date_to }}" class="form-control datepicker2" id="exampleInputEmail2" placeholder="Enter Date To">
    </div>
    <button type="submit" class="btn btn-primary">Filter Date</button>
    {{ link_to("/sales", 'Reset Table', array('class'=>'btn btn-primary')) }}
{{ Form::close() }}
<div class="export-button-div"></div>
<br/>
<hr>
<div>
    @if(count($transactions)>0)
            <table id='myTable' class="table-striped table-bordered">
            <thead>
            <tr>
                <td> Product Name		</td>
                <td>  No	    </td>
                <td> Quantity 	</td>
                <td> Unit Price / Item	        	    </td>
                <td> Income Type</td>
                <td> Income Amount</td>
                <td> PO No.	    </td>
                <td> BS	No.    </td>
                <td> Client Name	</td>
                <td> Date	        </td>
                <td> Due Date	        </td>
                <td> Overdue By	        </td>
                <td> Status	            </td>
            </tr>
            <tr>
                <td> Product Name		</td>
                <td>  No	    </td>
                <td> Quantity 	</td>
                <td> Unit Price / Item	        	    </td>
                <td> Income Type</td>
                <td> Income Amount</td>
                <td> PO No.	    </td>
                <td> BS	No.    </td>
                <td> Client Name	</td>
                <td> Date	        </td>
                <td> Due Date	        </td>
                <td> Overdue By	        </td>
                <td> Status	            </td>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td> <b>Total</b><br/> <b>Overall Total</b></td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            </tfoot>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>  {{$transaction->item_name }}  </td>
                    <td>  {{$transaction->quantity_no }}  </td>
                    <td>  {{$transaction->quantity_name }}  </td>
                    <td>  {{'₱ '.number_format($transaction->unit_price,2) }}   </td>
                    <td>  {{$transaction->income_type }}  </td>
                    <td>  {{'₱ '.number_format($transaction->income_amount,2) }}   </td>
                    <td>  {{$transaction->invoice_dr }}  </td>
                    <td>  {{$transaction->invoice_bs }}  </td>
                    <td>  {{$transaction->client_name }}  </td>
                    <td>  {{$transaction->invoice_date }}  </td>
                    <td>  {{$transaction->invoice_due_date }}  </td>
                    <td>  {{$transaction->due_date }}  </td>
                    <td>  {{$transaction->invoice_status }}  </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <label> No data! </label>
    @endif
</div>


<script type="text/javascript">

    $(document).ready(function(){
        //$('#myTable').DataTable();

        var class_no = 0;
        $('#myTable thead tr:first>td').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'"  class="form-control search-'+ class_no++ +'"/>' );
        } );

        $.fn.dataTable.moment( 'D MMM YYYY') ;
        var table = $('#myTable').DataTable( {
            columnDefs: [
                { type: 'signed-num', targets: [3,5,11] }
            ],
            buttons: [ {
                extend: 'excel',
                text: 'Export to Excel',
                autoPrint: false,
                footer: true
            } ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\₱ ,]/g, '')*1 :
                            typeof i === 'number' ?
                                    i : 0;
                };

                // Total over all pages
                total = api
                        .column( 3   )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Total over this page
                pageTotal = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Update footer
                $( api.column( 3 ).footer() ).html(
                        '<b>₱ '+numberWithCommas(parseFloat(pageTotal).toFixed(2)) +' <br>(₱ '+ numberWithCommas(parseFloat(total).toFixed(2)) +') </b>'
                );

                // Total over all pages
                total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Total over this page
                pageTotal = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Update footer
                $( api.column( 5 ).footer() ).html(
                        '<b>₱ '+numberWithCommas(parseFloat(pageTotal).toFixed(2)) +' <br>(₱ '+ numberWithCommas(parseFloat(total).toFixed(2)) +') </b>'
                );

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        } );

        table
                .buttons()
                .container()
                .appendTo( '.export-button-div' );

        <?php for($x=0;$x<13;$x++){ ?>
             $('.search-<?= $x ?>').on( 'keyup', function () {
                 table
                         .columns( <?= $x ?> )
                         .search( this.value )
                         .draw();
             });
        <?php } ?>

        $(".datepicker1, .datepicker2").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<style>
thead>tr>td{
    font-weight: 700;
}


#myTable{
    width: 100%!important;
}

#mytable .even { background-color: #aabbcc!important; }
#mytable .odd { background-color: #aabbcc!important; }

.export-button-div{
    padding-left: 42px;
    float: right;
    margin-top: -4px;
}
</style>

@stop