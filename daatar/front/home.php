<!-- include Header -->
<?php 
include('include/header.php');
?>
<style type="text/css">
	p{
		text-align: justify;
	}
</style>

<!-- ======= Hero Section ======= -->
  <section id="hero" class="clearfix">
    <div class="container" data-aos="fade-up">

      <div class="hero-img" data-aos="zoom-out" data-aos-delay="200">
        <img src="assets/img/hero-img.svg" alt="" class="img-fluid">
      </div>

      <div class="hero-info" data-aos="zoom-in" data-aos-delay="100">
        <h2>We provide<br><span>solutions</span><br>for your business!</h2>
        <h3 style='color:#fff'><b>THE PROPER UTILIZATION OF 4M</b></h3>
      </div>

    </div>
  </section><!-- End Hero Section -->

<!-- main-slider -->
<section class="w3l-main-slider" id="home">
    <div class="companies20-content">
        <div class="owl-one owl-carousel owl-theme">
            <?php 
                $data = get_all_sliders();
                while($row = mysqli_fetch_assoc($data)){
                    ?>
                    <div class="item">
                        <li>
                            <div class="slider-info banner-view bg bg2" style="background-image: url('uploads/sliders/<?php echo $row['image'] ?>');">
                                <div class="banner-info">
                                    <div class="container">
                                        <div class="banner-info-bg">
                                            <h1 class="text-white"><?php echo $row['title']; ?></h1>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                     </div>
                    <?php
                }

             ?>  
        </div>
    </div>
</section>





<!-- /main-slider -->
<section class="w3l-servicesblock py-1 border-bottom" id="who">
    <div class="container py-lg-5 py-md-4 py-2">
        <div class="row">
            <div class="col-lg-7 about-right-faq align-self">
               
                <h4 class="title-big mx-0">Welcome to Datar Certification Support PVT LTD</h4>
                <?php 
                $data = get_home_details();
                while($row = mysqli_fetch_assoc($data)){
                    ?>
                    
                    <?php
                    echo $row['content'];
                
                    ?>
               
               
            </div>
            <div class="col-lg-5">
                <!--<div class="row">-->
                    <div class="col-md-12  left-wthree-img mt-lg-0 mt-5">
                        <img src="<?php echo $config["app_url"]; ?>uploads/home/<?php echo $row['home_image'];?>" alt=""  class=" img-fluid ">
                    </div>
                <!--</div>-->
            </div>
            <?php 
        }
            ?>
        </div>
    </div>
</section>

 
<!-- <section class="w3l-features-8" id="products">

    <div class="features py-5">
        <div class="container py-lg-5 py-md-4 py-2">
            
            <h3 class="title-big text-center mb-md-5 mb-4">How we work</h3>
            <div class="fea-gd-vv text-center row">


                <div class="float-top col-lg-4 col-md-6 ">
                    <div class="float-lt feature-gd work-box">

                        <i class="fa fa-link fa-3x" aria-hidden="true"></i>
                        <h6 class="text-secondary pt-2">Usable In Almost Any Industry.</h6>
                        <h3 class="pt-3"><a href="#url" >RELIABLE & LONG-LASTING</a> </h3>
                        <p class="pt-1">We manufacture hoses that not only can be used by fire fighters, but can also be used by in other industries like Oil Refineries, Petrochemical Industries, Oil & Gas Exploration, Power Plants & Electricity Boards, Atomic Energy Center, Shipping, Defense, Railways, High Rise Buildings, Steel Plants, & many more.</p>

                    </div>
                </div>


                <div class="float-top col-lg-4 col-md-6 mt-md-0 mt-5 ">
                    <div class="float-lt feature-gd work-box">

                        <i class="fa fa-bolt fa-3x pt-2" aria-hidden="true"></i>
                        <h6 class="text-secondary pt-2">Smartly Manufactured & Maintained.</h6>
                        <h3 class="pt-3"><a href="#url">POWERFUL PERFORMANCE</a> </h3>
                        <p>With our Careful manufacturing process & Rigorous testing of or range of Hoses & our after sales service, we strive to give you 100% Satisfaction with our products quality and delivery.</p>

                    </div>
                </div>
                <div class="float-top col-lg-4 col-md-6 mt-lg-0 mt-5 ">
                   
                    <div class="float-lt feature-gd work-box">
                        <i class="fa fa-sliders fa-3x" aria-hidden="true"></i>
                        <h6 class="text-secondary pt-2">Flexible & Customizable.</h6>
                        <h3 class="pt-3"><a href="#url">TRULY MULTI-PURPOSE</a> </h3>

                        <p> With our vast variety of Hose range we can give you the right kind of Hose for any kind of application you might have. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</section> -->





<!-- include Footer -->
<?php 
include('include/footer.php');
?>