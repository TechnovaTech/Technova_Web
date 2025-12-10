<!-- include Header -->
<?php 
include('include/header.php');
?>
<!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Clients</h2>
          <ol>
            <li><a href="<?php echo $config["app_url"];?>">Home</a></li>
            <li>Our Clients</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
<!-- ======= Clients Section ======= -->
    <section id="clients" class="section-bg" style="background: #fff;">

      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h3>Our CLients</h3>
          
        </div>

        <div class="row g-0 clients-wrap clearfix" data-aos="zoom-in" data-aos-delay="100">
            <?php
            $clients = get_all_gallery_iamges();
            while($row = mysqli_fetch_assoc($clients)){

            ?>
          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="<?php echo $config["app_url"]; ?>uploads/gallery/<?php echo $row['image'];?>" class="img-fluid" alt="">
            </div>
          </div>
          <?php
      }
          ?>

          
          
          
          
          
          
          
        </div>

      </div>

    </section><!-- End Clients Section -->

<!-- include Footer -->
<?php 
include('include/footer.php');
?>