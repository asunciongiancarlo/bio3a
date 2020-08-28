@extends('layouts/default')
@section('content')
<?php extract($data); ?>
    <h3>Transaction Summary</h3>

<?php
if(Session::get('message')){
    echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
}
?>

{{ Form::open(array('url' => 'transactions/filter', 'method'=>'post', 'class'=>'form-inline')) }}
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
                <td> PO	No.	</td>
                <td> BS	No.	</td>
                <td> Client Name	</td>
                <td> Date	        </td>
                <td> Due Date	    </td>
                <td> Overdue By	    </td>
                <td> Total Amount	</td>
                <td> Payment	    </td>
                <td> Balance	    </td>
                <td> Status	        </td>
                <td> Options	    </td>
            </tr>
            <tr>
                <td> PO No.		</td>
                <td> BS No.		</td>
                <td> Client Name	</td>
                <td> Date	        </td>
                <td> Due Date	    </td>
                <td> Overdue By	    </td>
                <td> Total Amount	</td>
                <td> Payment	    </td>
                <td> Balance	    </td>
                <td> Status	        </td>
                <td> Options	    </td>
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
            </tr>
            </tfoot>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>  {{$transaction->invoice_dr }}  </td>
                    <td>  {{$transaction->invoice_bs }}  </td>
                    <td>  {{$transaction->client_name }}  </td>
                    <td>  {{$transaction->invoice_date }}  </td>
                    <td>  {{$transaction->invoice_due_date }}  </td>
                    <td>  {{$transaction->due_date }}  </td>
                    <td>  {{'₱ '.number_format($transaction->total_amount,2) }}  </td>
                    <td>  {{'₱ '.number_format($transaction->total_payment,2) }}  </td>
                    <td>  {{'₱ '.number_format($transaction->total_due,2) }}  </td>
                    <td>  {{$transaction->invoice_status }}  </td>
                    <td>
                        {{ link_to("/transactions/{$transaction->i_id}/edit", 'Edit') 							 				    }}  |
                        {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($transaction->i_id)")) 	}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <label> No data! </label>
    @endif
</div>


<script type="text/javascript">
    function delOption(id)
    {
        if(confirm('Are you sure you want to delete this item?'))
        {
            $.ajax({
                type: 'Delete',
                url: '{{  URL::to('transactions/destroy/') }}'+'/'+id,
                dataType: 'json',
                success: (function(data){
                    location.reload();
                })
            });
        }
    }

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
                { type: 'signed-num', targets: [5,6,7,8] }
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
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Total over this page
                pageTotal = api
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Update footer
                $( api.column( 6 ).footer() ).html(
                        '<b>₱ '+numberWithCommas(parseFloat(pageTotal).toFixed(2)) +' <br>(₱ '+ numberWithCommas(parseFloat(total).toFixed(2)) +') </b>'
                );

                // Total over all pages
                total = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Total over this page
                pageTotal = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Update footer
                $( api.column( 7 ).footer() ).html(
                        '<b>₱ '+numberWithCommas(parseFloat(pageTotal).toFixed(2)) +' <br>(₱ '+ numberWithCommas(parseFloat(total).toFixed(2)) +') </b>'
                );

                // Total over all pages
                total = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Total over this page
                pageTotal = api
                        .column( 8, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                // Update footer
                $( api.column( 8 ).footer() ).html(
                        '<b>₱ '+numberWithCommas(parseFloat(pageTotal).toFixed(2)) +' <br>(₱ '+ numberWithCommas(parseFloat(total).toFixed(2)) +') </b>'
                );



                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        } );

        <?php for($x=0;$x<10;$x++){ ?>
             $('.search-<?= $x ?>').on( 'keyup', function () {
            table
                    .columns( <?= $x ?> )
                    .search( this.value )
                    .draw();
        });
        <?php } ?>

        table
                .buttons()
                .container()
                .appendTo( '.export-button-div' );

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