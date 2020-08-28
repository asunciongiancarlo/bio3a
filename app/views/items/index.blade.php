@extends('layouts/default')
@section('content')

    <h3>Products</h3>
    <?php
    extract($data);
    if(Session::get('message')){
        echo "<div class='alert alert-success'>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
    }
    ?>

    <?php
    extract($data);
    if(isset($userData))
        echo 	Form::model($userData,array('url'=>'items/update/','files'=>true,'class'=>'myForm'));
    else
        echo 	Form::open(array('url'=>'items/store','files'=>true,'class'=>'myForm'));

    echo	Form::hidden('id');
    echo	Form::label('item_name', 'Products Name:');
    echo	Form::text('item_name',null,array('class'=>'form-control','data-parsley-required'=>'true'));
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
                    <td> Product Name		</td>
                    <td> Options		</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>  {{$user->item_name 						 												}}  </td>
                        <td>
                            {{ link_to("/items/{$user->i_id}/edit", 'Edit') 							 				    }}  |
                            {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($user->i_id)")) 	}}
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
                    url: '{{ action("items.destroy",'') }}'+"/"+id,
                    dataType: 'json',
                    success: (function(data){
                        location.reload();
                    })
                });
            }
        }

        $(document).ready(function(){
            $('#myTable').DataTable({ buttons: [
                'excel'
            ]});
            $('.myForm').parsley();
        });
    </script>
@stop



