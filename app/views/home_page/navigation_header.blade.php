<header id="header">
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-xs-4">
          <div class="top-number"><p><i class="fa fa-phone-square"></i>  0917-8157-840 / +63-02-463-3379</p></div>
        </div>
        <div class="col-sm-6 col-xs-8">
          <div class="social">
            <ul class="social-share">
              <li><a href="https://www.facebook.com/HealthCardsPH/"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/billevable"><i class="fa fa-twitter"></i></a></li>
              <li><a href="https://www.linkedin.com/in/billetemanel"><i class="fa fa-linkedin"></i></a></li>
              <li><a href="https://www.instagram.com/healthcardsph/"><i class="fa fa-instagram"></i></a></li>
            </ul>
            {{--<div class="search">--}}
              {{--<form role="form">--}}
                {{--<input type="text" class="search-form" autocomplete="off" placeholder="Search">--}}
                {{--<i class="fa fa-search"></i>--}}
              {{--</form>--}}
            {{--</div>--}}
          </div>
        </div>
      </div>
    </div><!--/.container-->
  </div><!--/.top-bar-->

  <nav class="navbar navbar-inverse" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{URL::to('/')}}">
          {{ HTML::image('/images/h/logo.png',null, array('class'=>'img-responsive', 'style'=>'height:65px;!important')) }}
        </a>
      </div>

      <div class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav">
          <li {{ ($active_page)=='home' ? 'class="active"' : ''  }} >  {{ HTML::link('/', 'Home', array(), false)}} </li>
          <li {{ ($active_page)=='articles' ? 'class="active"' : ''  }}> {{ HTML::link('/lists_of_categories', 'Blogs', array(), false)}} </li>
          <li {{ ($active_page)=='healthcard_comparison_table' ? 'class="active"' : ''  }} >  {{ HTML::link('/healthcard_comparison_table', 'Health Card Comparison', array(), false )}}</li>
        </ul>
      </div>
    </div><!--/.container-->
  </nav><!--/nav-->

</header>