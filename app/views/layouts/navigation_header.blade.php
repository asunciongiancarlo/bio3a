  <div class="navbar-wrapper">
    <div class="container">
      <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-header">
              <a class="navbar-brand" href="#">
                {{ HTML::image(URL().'/images/bio-logo.png', null, array('class'=>'lodenians-logo')); }}
              </a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Transactions <span class="caret"></span> | </a>
                <ul class="dropdown-menu" role="menu">
                  <li>  {{ link_to('sales', 'Transaction Details |', array('class'  =>'navbar-brand'))     }}    </li>
                  <li>  {{ link_to('transactions', 'Transaction Summary |', array('class'  =>'navbar-brand'))     }}    </li>
                  <li>   {{ link_to('transactions/create', 'Add New Transaction |', array('class'  =>'navbar-brand'))     }}     </li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Receipts <span class="caret"></span> | </a>
                <ul class="dropdown-menu" role="menu">
                  <li>  {{ link_to('resibo', 'Receipts List |', array('class'  =>'navbar-brand'))     }}    </li>
                  <li>  {{ link_to('resibo/create', 'Add New Receipt |', array('class'  =>'navbar-brand'))     }}    </li>
                </ul>
              </li>

              <li>     {{ link_to('clients', 'Clients |', array('class'  =>'navbar-brand'))     }}    </li>
              <li>     {{ link_to('items', 'Products |', array('class'  =>'navbar-brand'))     }}    </li>
              <li>     {{ link_to('item_quantity', 'Product Quantity |', array('class'  =>'navbar-brand'))     }}    </li>
              <li>     {{ link_to('inventory', 'Inventory |', array('class'  =>'navbar-brand'))     }}    </li>
              <li>     {{ link_to('users', 'Users |', array('class'                           =>'navbar-brand'))     }}    </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Hi {{ Auth::user()->username }}<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                   <li>     {{ link_to('sessions/destroy','Logout?') }}   </li> 
                </ul>
              </li>
            </ul>
        
          </div><!-- /.navbar-collapse -->
           
        </div><!-- /.container-fluid -->
      </nav>

  </div>
</div>


