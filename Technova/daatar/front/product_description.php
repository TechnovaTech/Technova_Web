<!-- include Header -->
<?php 
include('include/header.php');
if(isset($uri_segments[2]))
{
    $product_name = str_replace("-"," ",$uri_segments[2]);
}
?>
<style type="text/css">
    p{
        text-align: justify;
    }
</style>
<!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $product_name;?></h2>
          <ol>
            <li><a href="<?php echo $config["app_url"];?>">Home</a></li>
            <li><?php echo $product_name;?></li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
<?php 

$product = get_product_by_name($product_name);
while($data = mysqli_fetch_assoc($product))
{
  ?>
  <div class="w3l-text py-5">
        <div class="container py-lg-5 py-4 ">
            <div class="row text-inner">
                <div class="col-lg-4 mt-lg-0 mt-4">
                    <img src="<?php echo $config['app_url']?>uploads/products/<?php echo $data['image1'];?>" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 pr-lg-5 align-self liner_unset">
                    <h3 class="title-big mb-4"><?php echo $data['name'];?></h3>
                    
                       <?php echo $data['description'];?> 
                    
                    <a class="btn btn-style btn-primary mt-sm-5 mt-4 mr-lg-3 mr-1" href="<?php echo $config['app_url']?>contact-us">Contact Us</a>
                    
                    <!-- dialog itself, mfp-hide class is required to make dialog hidden -->
                    
                </div>
                
            </div>
        </div>
    </div>


  <?php
}
?>




<!-- include Footer-->
<?php 
include('include/footer.php');
?>
