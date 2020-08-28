@extends('layouts/default')
@section('content')
    <?php extract($data); ?>
    <h3>Inventory Summary</h3>

    <?php
    if(Session::get('message')){
        echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
    } ?>

    {{ link_to("/inventory/create", 'Add New Inventory Item') 							 				    }}

    <div class="export-button-div"></div>
    <br/>
    <hr>
    <div>
        @if(count($items)>0)
            <table id='myTable' class="table-striped table-bordered">
                <thead>
                <tr>
                    <td> Product		</td>
                    <td> Quantity Name		</td>
                    <td> No of Stocks	</td>
                    <td> To Order	        </td>
                    <td> Notes	    </td>
                    <td> Options	    </td>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>  {{$item->item_name}}  </td>
                        <td>  {{$item->quantity_name }}  </td>
                        <td>  {{$item->stock_quantity }}  </td>
                        <td>  {{$item->to_order }}  </td>
                        <td>  {{$item->notes }}  </td>
                        <td>
                            {{ link_to("/inventory/{$item->id}/edit", 'Edit') 							 				}}  |
                            {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($item->id)")) 	}}
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
                    url: '{{  URL::to('inventory/destroy/') }}'+'/'+id,
                    dataType: 'json',
                    success: (function(data){
                        location.reload();
                    })
                });
            }
        }

        $(document).ready(function(){
            var table = $('#myTable').DataTable();

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