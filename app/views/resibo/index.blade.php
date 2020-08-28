@extends('layouts/default')
@section('content')
<?php extract($data); ?>
    <h3>Resibo Summary</h3>

<?php
if(Session::get('message')){
    echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
}
?>
<hr>
<div>
    @if(count($transactions)>0)
            <table id='myTable' class="table-striped table-bordered">
            <thead>
            <tr>
                <td> Delivered To		</td>
                <td> Address		</td>
                <td> Date	</td>
                <td> BS No.	        </td>
                <td> PO No.	    </td>
                <td> OR No.	    </td>
                <td> Total	    </td>
                <td> Options	    </td>
            </tr>
            <tr>
                <td> Delivered To		</td>
                <td> Address		</td>
                <td> Date	</td>
                <td> BS No.	        </td>
                <td> PO No.	    </td>
                <td> OR No.	    </td>
                <td> Total	    </td>
                <td> Options	    </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>  {{$transaction->delivered_to }}  </td>
                    <td>  {{$transaction->delivered_address }}  </td>
                    <td>  {{$transaction->resibo_date }}  </td>
                    <td>  {{$transaction->bs_no }}  </td>
                    <td>  {{$transaction->po_no }}  </td>
                    <td>  {{$transaction->or_no }}  </td>
                    <td>  {{'₱ '.number_format($transaction->income_amount,2) }}  </td>
                    <td>
                        {{ link_to("/invoice_pdf/{$transaction->resibo_id}/view", 'Print', array('target'=>'_newtab')) 							 				    }} |
                        {{ link_to("/resibo/{$transaction->resibo_id}/edit", 'Edit') 							 				    }}  |
                        {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($transaction->resibo_id)")) 	}}
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
                url: '{{  URL::to('resibo/destroy/') }}'+'/'+id,
                dataType: 'json',
                success: (function(data){
                    location.reload();
                })
            });
        }
    }

    $(document).ready(function(){


        var class_no = 0;
        $('#myTable thead tr:first>td').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'"  class="form-control search-'+ class_no++ +'"/>' );
        } );

        $.fn.dataTable.moment( 'D MMM YYYY') ;
        var table = $('#myTable').DataTable( {
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