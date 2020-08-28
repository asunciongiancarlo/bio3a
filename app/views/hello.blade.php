@extends('home_page/default')
@section('content')
  <?php
  extract($data);
  ?>
  <section id="recent-works">
    <div class="container">
      <div class="center wow fadeInDown">
        <h2>BLOG, NEWS AND EVENTS</h2>
        <p class="lead"></p>
      </div>

      <div class="row">
      @foreach($featured_items as $featured_item)
          <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="recent-work-wrap">
              {{ HTML::image('/img/resize/'.$featured_item->image_name,null, array('class'=>'img-responsive')) }}

              <div class="overlay">
                <div class="recent-work-inner">
                  <h3><a href="#">{{  $featured_item->blog_title }}</a> </h3>
                  <p>{{  $featured_item->blog_intro }}</p>
                  {{ link_to('/preview_item/'.$featured_item->blog_id, 'Read More', array("class"=>"preview", "role"=>"button")) }}
                </div>
              </div>
            </div>
          </div>
      @endforeach
      </div><!--/.row-->
    </div><!--/.container-->
  </section><!--/#recent-works-->

  <section id="feature" >
    <div class="container">
      <div class="center wow fadeInDown">
        <h2>HEALTH CARD COVERAGE</h2>
        <p class="lead">What are the features of a health card?</p>
      </div>

      <div class="row">
        <div class="features">
          <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="feature-wrap">
              <i class="fa fa-hospital-o"></i>
              <h2>IN-PATIENT BENEFITS</h2>
              <h3>Coverage during confinement or hospitalization includes the miscellaneous charges like prescribed medicines, professional fees, surgery and operation</h3>
            </div>
          </div><!--/.col-md-4-->

          <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="feature-wrap">
              <i class="fa  fa-user"></i>
              <h2>OUT-PATIENT BENEFITS</h2>
              <h3>Coverage for procedure that does not require hospital admission and may also be performed outside the premises of a hospital</h3>
            </div>
          </div><!--/.col-md-4-->

          <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="feature-wrap">
              <i class="fa fa-ambulance"></i>
              <h2>EMERGENCY BENEFITS</h2>
              <h3>Coverage or treatment of emergency cases/conditions not leading to confinement provided by the out-patient department of a hospital or a licensed doctor in his clinic for a covered disability</h3>
            </div>
          </div><!--/.col-md-4-->

          <div class="col-md-6 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="feature-wrap">
              <i class="fa  fa-plus-square"></i>
              <h2>DENTAL BENEFIT</h2>
              <h3>Coverage of dental procedures done on dental clinics</h3>
            </div>
          </div><!--/.col-md-4-->

          <div class="col-md-6 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="feature-wrap">
              <i class="fa fa-heartbeat"></i>
              <h2>ANNUAL PHYSICAL EXAMINATION (APE)</h2>
              <h3>
                Coverage for Annual Check-up or the Annual Physical Examination are done on the provider's accredited clinic</h3>
            </div>
          </div><!--/.col-md-4-->

          <!--/.col-md-4-->
        </div><!--/.services-->
      </div><!--/.row-->
    </div><!--/.container-->
  </section><!--/#feature-->

  <section id="partner">
    <div class="container">
      <div class="center wow fadeInDown">
        <h2>Our Health Cards or Health Insurance</h2>
        <p class="lead"></p>
      </div>

      <div class="partners">
        <ul>
          <li> <a href="#"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms" src="images/h/1462539563_Eastwest.jpg"></a></li>
          <li> <a href="#"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms" src="images/h/1462538942_maxicare.jpg"></a></li>
          <li> <a href="#"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms" src="images/h/1462538998_Pacific Cross.jpg"></a></li>
          <li> <a href="#"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms" src="images/h/1462539260_PhilCare-Logo.jpg"></a></li>
          <li> <a href="#"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms" src="images/h/pru_life_uk-Business-Logo.jpg"></a></li>
        </ul>
      </div>
    </div><!--/.container-->
  </section><!--/#partner-->
  <section id="error" class="container text-center">
    <h2>Choose a Health Card</h2>
    <p></p>
    {{ link_to('/healthcard_comparison_table', 'Compare Now', array("class"=>"btn btn-primary", "role"=>"button")) }}
    {{ link_to('https://docs.google.com/forms/d/e/1FAIpQLSe4bOvjPwk3pGf-2lnR8CyRBr8tAu5a5gEq4ALTB5YfWolDPQ/viewform?c=0&w=1', 'Set An Appointment', array("class"=>"btn btn-primary", "role"=>"button")) }}
    {{ link_to('https://docs.google.com/forms/d/e/1FAIpQLSdj2bJ7YpYtcg19Mz8SjiJeSPZOSm-pH7O1lqVyKOiS0geMeg/viewform?c=0&w=1', 'Request for a Quotation', array("class"=>"btn btn-primary", "role"=>"button")) }}
  </section>
<hr>
  <section id="contact-page">
    <div class="container">
      <div class="center">
        <p class="lead"></p>
        <h2>Contact Us</h2>

      </div>
      <div class="row contact-wrap">
        <div class="status alert alert-success" style="display: none"></div>

        {{ Form::open(array('id'=>'CommentItemfrm','class'=>'contact-form')) }}
        <input type = "hidden" name = "id" value = "130">
          <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group">
              <label>Name *</label>
              {{ Form::text('name',null,['class' => 'form-control', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"50"]) }}
            </div>
            <div class="form-group">
              <label>Email *</label>
              {{ Form::text('email',null,['class' => 'form-control', 'data-parsley-required'=>'true', 'data-parsley-maxlength'=>'50','data-parsley-type'=>'email']) }}
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
            </div>
            <div class="form-group">
              <label>Message *</label>
              {{ Form::textarea('comment',null,['class' => 'form-control', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"255"]) }}
            </div>
            <div class="form-group">
              {{ Form::button('Submit your message',['class' => 'btn btn-primary btn-lg','id'=>'CommentfrmBtn']) }}
            </div>
          </div>
        {{ Form::close() }}
      </div><!--/.row-->
    </div><!--/.container-->
  </section><!--/#contact-page-->
  <hr>
  <section id="about-us">
    <div class="container">
      <!-- our-team -->
      <div class="team">
        <div class="center wow fadeInDown">
          <h2>About Us</h2>
          <p class="lead">We are experienced professionals dedicated in providing best health coverage solutions to tailorfit your needs.</p>
        </div>

        <div class="row clearfix">
          <div class="col-md-4 col-sm-6">
            <div class="single-profile-top wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="media">
                <div class="pull-left">
                  {{ HTML::image('/images/h/man1.jpg',null, array('class'=>'media-object','style'=>'height:137px;')) }}
                </div>
                <div class="media-body">
                  <h4>BILLE CRISTIANE TEMANEL</h4>
                  <h5>Founder, HealthCards.PH</h5>
                  <ul class="social_icons">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  </ul>
                </div>
              </div><!--/.media -->
              <p>Freelance Insurance/Health Card Specialist</p>
            </div>
          </div><!--/.col-lg-4 -->


          <div class="col-md-4 col-sm-6 col-md-offset-2">
            <div class="single-profile-top wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="media">
                <div class="pull-left">
                  {{ HTML::image('/images/h/man2.jpg',null, array('class'=>'media-object','style'=>'height:137px;')) }}
                </div>
                <div class="media-body">
                  <h4>NIKA VENTE</h4>
                  <h5>Content Manager, HealthCards.PH</h5>


                </div>
              </div><!--/.media -->
              <p>Freelance Writer, Health Card/ Insurance Specilaist</p>
            </div>
          </div><!--/.col-lg-4 -->
        </div> <!--/.row -->
        <div class="row team-bar">
          <div class="first-one-arrow hidden-xs">
            <hr>
          </div>
          <div class="first-arrow hidden-xs">
            <hr> <i class="fa fa-angle-up"></i>
          </div>
          <div class="second-arrow hidden-xs">
            <hr> <i class="fa fa-angle-down"></i>
          </div>
          <div class="third-arrow hidden-xs">
            <hr> <i class="fa fa-angle-up"></i>
          </div>
          <div class="fourth-arrow hidden-xs" style="display:none;visibility: hidden;">
            <hr> <i class="fa fa-angle-down"></i>
          </div>
        </div> <!--skill_border-->

        <div class="row clearfix">
          <div class="col-md-4 col-sm-6 col-md-offset-2">
            <div class="single-profile-bottom wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
              <div class="media">
                <div class="pull-left">
                  {{ HTML::image('/images/h/man3.jpg',null, array('class'=>'media-object','style'=>'height:137px;')) }}
                </div>

                <div class="media-body">
                  <h4>THIS COULD BE YOU</h4>
                  <h5>Team HealthCards.PH</h5>

                </div>
              </div><!--/.media -->
              <p>We are looking for Freelancers or Salespersons who handles different health cards. You may want to become a part of our team . Just message us below if you are interested.</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-md-offset-2">

          </div>
        </div>	<!--/.row-->
      </div><!--section-->
    </div><!--/.container-->
  </section><!--/about-us-->
 <hr>
  <section id="conatcat-info">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="media contact-info wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="pull-left">
              <i class="fa fa-phone"></i>
            </div>
            <div class="media-body">
              <h2>Have a question or need a custom quote?</h2>
              <p>0917-8157-840 / +63-02-463-3379 / bille.temanel@healthcards.ph</p>
            </div>
          </div>
        </div>
      </div>
    </div><!--/.container-->
  </section><!--/#conatcat-info-->
  <script>
    $('document').ready(function(){
      $('#CommentfrmBtn').on("click",function(){
        if($('#CommentItemfrm').parsley().validate()){
          $.ajax({
            method : "POST",
            url : '{{ action("cms_comments.store") }}',
            dataType : "JSON",
            data : $('form#CommentItemfrm').serialize(),
            success: function(){
              alert('Comment has been submitted to admin, but subjected for approval.');
              location.reload();
            }

          });
        }
      });
    });

  </script>

@stop



