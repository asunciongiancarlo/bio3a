@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>    
  <div class="container marketing">
  <h3 class="searchResultLabel">Search results: <i>{{ $key }}</i></h3>
  
  <table id='resultTable'>
    <thead>
     <tr>
      <td> &nbsp;          </td>
      <td> Title           </td>
      <td> Category        </td>
      <td> Description     </td>
      <td> &nbsp;          </td>
      <td> Price           </td>
     </tr>
    </thead>
    <tbody>
    @foreach ($blogs as $blog)
    <tr> 
      <td>  {{ HTML::image('/img/thumbnail/'.$blog->blog_image,null, array('class' =>'img-rounded'))      }}     </td>
      <td>  
          {{ link_to('/preview_item/'.$blog->id, Str::limit($blog->blog_title, 50), NULL) }}
      </td>     
      <td>  {{ $blog->category_name                                                                            }}     </td>     
      <td>  {{ $blog->blog_intro                                                                               }}     </td>     
      <td class='blogPriceTdP'> 
          <p class='blogPrice'>  ₱ </p>  
      </td>     
      <td class='blogPriceTD'>   
        <p class='blogPrice'> {{ number_format($blog->price, 2, '.', ',')                                   }}</p> 
      </td>
     </tr>
    @endforeach
    </tbody>
  </table>
  </div><!-- /.container -->

  <script type="text/javascript">
  $(document).ready( function() {
  $('#resultTable').dataTable( {
    "oLanguage": {
      "sSearch": "Additional Filter:"
    }
  } );
} );
</script>
@stop



