@extends('layouts/default')
@section('content')
    <?php
    extract($data);
    ?>

    <h3>Product Quantity</h3>

    <?php
    if(Session::get('message')){
        echo "<div class='alert alert-success'>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
    }

    extract($data);
    if(isset($userData))
        echo 	Form::model($userData,array('url'=>'item_quantity/update/','files'=>true,'class'=>'myForm'));
    else
        echo 	Form::open(array('url'=>'item_quantity/store','files'=>true,'class'=>'myForm'));

    echo	Form::hidden('id');
    echo	Form::label('item_quantity', 'Product Quantity:');
    echo	Form::text('quantity_name',null,array('class'=>'form-control','data-parsley-required'=>'true'));
    echo    "<br/>";
    echo 	Form::submit('Submit',array('class'=>'btn btn-primary'));
    echo 	Form::close();
    echo    "<br/>";
    ?>

    <ul>
        @if(count($users)>0)
            <table id='myTable' class="table-striped table-bordered">
                <thead>
                <tr>
                    <td> Product Quantity		</td>
                    <td> Options		</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>  {{$user->quantity_name }}  </td>
                        <td>
                            {{ link_to("/item_quantity/{$user->id}/edit", 'Edit') 							 				    }}  |
                            {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($user->id)")) 	}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <li> No data! </li>
        @endif
    </ul>


    <script type="text/javascript">
        function delOption(id)
        {
            if(confirm('Are you sure you want to delete this item?'))
            {
                $.ajax({
                    type: 'Delete',
                    url: '{{ action("item_quantity.destroy",'') }}'+"/"+id,
                    dataType: 'json',
                    success: (function(data){
                        location.reload();
                    })
                });
            }
        }

        $(document).ready(function(){
            $('#myTable').DataTable();
            $('.myForm').parsley();
        });
    </script>
@stop



