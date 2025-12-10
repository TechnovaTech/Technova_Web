<div class="container my-4">

   

    

    <!--Carousel Wrapper-->
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

      <!--Controls-->
      <div class="controls-top">
        <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
        <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
      </div>
      <!--/.Controls-->

      <!--Indicators-->
      <ol class="carousel-indicators">
        <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
        <li data-target="#multi-item-example" data-slide-to="1"></li>
        <li data-target="#multi-item-example" data-slide-to="2"></li>
      </ol>
      <!--/.Indicators-->

      <!--Slides-->
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item">

          <div class="row">
<?php 
include("front/include/functions.php");

$res = get_all_records('product');
        while($data = mysqli_fetch_assoc($res))
        {
            ?>
            
                <!--First slide-->
        
            <div class="col-md-4">
              <div class="card mb-2">
                <img class="card-img-top" src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>"
                  alt="Card image cap">
                
              </div>
            </div>

            

            
          

            <?php
        }
?>


</div>

        </div>
        
        <!--/.First slide-->



      </div>
      <!--/.Slides-->

    </div>
    <!--/.Carousel Wrapper-->


  </div>