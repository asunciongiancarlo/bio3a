<h1> <img src="{{asset('images/bio-logo.png')}}" alt="Logo" height="60px"> Bio. Entomological Services & Trading International</h1>
<p class="address">
    #10526 Rd., 1 Bernardo Village, Mayondon, Los Bañoz, Laguna <br/>
    Tel. No. (049) 535-3104 * (02) 819-5697 <br/>
    ADRIANO T. Sapin - Proprietor
</p>

<?php
//extract($data);
//print_r($resibo_details); die();

$_id             = json_decode(json_encode($resibo_details[0]),true);
$resibo_items    = json_decode(json_encode($resibo_items),true);
?>

<h3 class="receipt-title">DELIVERY RECEIPT</h3>

<p class="date">Date: <?php echo date('M d, Y', strtotime($_id['resibo_date'])) ?> <br/>
    <span class="or"> BS No. {{ $_id['bs_no']  }} </span><br/>
    <span class="or"> PO No. {{ $_id['po_no']  }} </span><br/>
    <span class="or"> OR No. {{ $_id['or_no']  }} </span>
</p>

<p class="delivery-to">Delivered to: <span class="class"> {{ $_id['delivered_to']  }} </span>  <br/>
    Address: <span class="class"> {{ $_id['delivered_address']  }} </span>  </p>

<table class="table table-bordered">
    <tr>
        <th width="10px">QUANTITY</th>
        <th width="50px">UNIT</th>
        <th width="50px">BATCH NO.</th>
        <th width="350px">ARTICLES</th>
        <th width="80px">UNIT PRICE</th>
        <th width="80px">PRICE</th>
    </tr>

    <?php
    $sum = 0;
    $ctr = 0;
    ?>
    @foreach($resibo_items  as $pi)
        <?php
        $sum += $pi['income_amount'];
        $ctr++;
        ?>
        <tr>
            <td style="text-align: center;">{{ $pi['qty'] }}</td>
            <td>{{ $pi['unit'] }}</td>
            <td>{{ $pi['batch_no'] }}</td>
            <td>{{ $pi['articles'] }}</td>
            <td class="align-right">{{ number_format($pi['unit_price'],2)  }}</td>
            <td class="align-right">{{ number_format($pi['income_amount'],2) }}</td>
        </tr>
    @endforeach
    <?php  for($ctr=1; $ctr<=9; $ctr++ ){ ?>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" class="total-amount-due"> Total Amount Due </td>
        <td class="align-right"> {{ number_format($sum,2) }} </td>
    </tr>
</table>

<br/>
<p class="received-by">
    By: <span class="received-by-name"> {{ $_id['received_by']  }} </span> <br/>
    Received the above in good order and condition.
</p>


<style>
    img{
        margin-bottom: -30px;
    }

    body{ font-size: 18px; line-height: 1; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; margin: 5px;}

    @page{
        margin: 30px;
    }

    h1, .address, .receipt-title{
        text-align: center;
    }

    .or{
        color: black;
    }

    .receipt-title{
        text-decoration: underline;
    }

    .date, .received-by{
        text-align: right;
    }

    .delivery-to, .delivery-address{
        text-align: left;
    }

    .align-right{
        text-align: right;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .total-amount-due{
        text-align: right;
        font-weight: bold;
    }

    table, th, td {
        border: 1px solid black;
    }

    .received-by-name{
        width: 300px;
        text-decoration: underline;
    }

    .class-underline{
        text-decoration: underline;
    }

    tr:nth-child(even) {background-color: #f5f5f5;}

    th, td, tr {
        padding:2px;
    }
</style>