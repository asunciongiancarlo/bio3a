@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>



<section id="contact-page">
    <div class="container">
        <div class="center">
            <p class="lead"></p>
            <h2>Health Card Comparison Table</h2>
        </div>
        <div class="">
            {{ $page_data->static_page_content }}
        </div>
    </div>
</section>

<style>
    @media screen and (max-width: 600px) {
        table {width:100%;}
        thead {display: none;}
        tr:nth-of-type(2n) {background-color: inherit;}
        tr td:first-child {background: #f0f0f0; font-weight:bold;font-size:1.3em;}
        tbody td {display: block;  text-align:center;}
        tbody td:before {
            content: attr(data-th);
            display: block;
            text-align:center;
        }
    }
</style>
<script>
    var headertext = [];
    var headers = document.querySelectorAll("thead");
    var tablebody = document.querySelectorAll("tbody");

    for (var i = 0; i < headers.length; i++) {
        headertext[i]=[];
        for (var j = 0, headrow; headrow = headers[i].rows[0].cells[j]; j++) {
            var current = headrow;
            headertext[i].push(current.textContent);
        }
    }

    for (var h = 0, tbody; tbody = tablebody[h]; h++) {
        for (var i = 0, row; row = tbody.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                col.setAttribute("data-th", headertext[h][j]);
            }
        }
    }
</script>

@stop



