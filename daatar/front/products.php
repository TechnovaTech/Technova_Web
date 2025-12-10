<?php 
  include("include/header.php");

?>

<section class="team py-5" id="team">
  <div class="container py-lg-5 py-md-4 py-2">
   
    <ul class="nav nav-pills" id="pills-tab1" role="tablist">


       <?php  

        $res = get_all_products_cat('0');
        while($data = mysqli_fetch_assoc($res))
        {
          ?>
            <li class="nav-item item-nav-img product-pill" title="<?php echo $data["name"]?>" onclick="display_product_content(<?php echo $data['id']?>)">
              <a class="nav-link active product-pill" id="#<?php echo $data['id'] ?>" data-toggle="pill" href="<?php echo $data['id'] ?>" role="tab" aria-controls="pills-team1" aria-selected="true">
                <img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" class="img-fluid product-nav-img" alt="" />
              </a>
           </li>
          <?php
        }
        ?>
        <?php  

        $res = get_all_products_cat('1');
        while($data = mysqli_fetch_assoc($res))
        {
          ?>
            <li class="nav-item item-nav-img product-pill" title="<?php echo $data["name"]?>" onclick="display_product_content(<?php echo $data['id']?>)">
              <a class="nav-link active product-pill" id="#<?php echo $data['id'] ?>" data-toggle="pill" href="<?php echo $data['id'] ?>" role="tab" aria-controls="pills-team1" aria-selected="true">
                <img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" class="img-fluid product-nav-img" alt="" />
              </a>
           </li>
          <?php
          break;
        }
        ?>
    </ul>

    <div class="tab-content" id="pills-tabContent1">

    <?php 
        $res = get_all_products_cat('0');

        while($data = mysqli_fetch_assoc($res))
        {

          ?>

          <div class="tab-pane fade   product_details" id="<?php echo $data['id'];?>" role="tabpanel" aria-labelledby="6">
              <div class="team-grids row">
                <div class="col-lg-6">
                  <img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" class="img-fluid" alt="" />
                </div>
                <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4 liner_unset">
                  <h4><?php echo $data['name']?></h4>
                  <p class="pt-3"><?php echo substr($data['description'],11,271)?>.....</p>
                  <a href="<?php echo $config["app_url"]?>product/<?php echo str_replace(" ","-",$data['name'])?>" class="btn btn-style btn-primary mt-md-5 mt-4">Read more</a>
                </div>
              </div>
            </div>
          <?php
        }

     ?>
     <div class="tab-pane fade   product_details" id="23" role="tabpanel" aria-labelledby="6">
              <div class="team-grids row">
     <?php 
        $res = get_all_products_cat('1');

        while($data = mysqli_fetch_assoc($res))
        {

          ?>

          
                <div class="col-lg-6">
                  <img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" class="img-fluid" alt="" />
                </div>
                <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4 liner_unset">
                  <h4><?php echo $data['name']?></h4>
                  <p class="pt-3"><?php echo substr($data['description'],11,271)?>.....</p>
                  <a href="<?php echo $config["app_url"]?>product/<?php echo str_replace(" ","-",$data['name'])?>" class="btn btn-style btn-primary mt-md-5 mt-4">Read more</a>
                </div>
              
          <?php
        }

     ?>
     </div>
            </div>


    </div>
  </div>
</section>



<?php 
  include("include/footer.php");
?>

