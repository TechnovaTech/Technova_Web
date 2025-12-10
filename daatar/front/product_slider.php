

<!-- //homeblock2-->
<section class="w3l-gallery" id="gallery">
    <div class="destionation-innf py-5">
        <div class="container py-lg-5 py-md-4 py-2">
            <div class="title-content">
                <h2 class="text-center mb-1">OUR PRODUCTS</h2>
                
            </div>
            <!--/coffee grids-grids-->

            <ul class="gallery_agile">
               <?php 
        $res = get_all_records('product');

        while($data = mysqli_fetch_assoc($res))
        {

          ?>
                <li>
                    <div class="w3_agile_portfolio_grid">
                        <a  target="_blank" href="#">
                            <img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" alt=" " class="img-fluid radius-image" />
                            
                        </a>
                        <div class="w3layouts_news_grid_pos">
                                <div class="wthree_text">
                                    <h3><?php echo $data['name']?></h3>
                                    <a  target="_top" href="<?php echo $config["app_url"]?>product/<?php echo str_replace(" ","-",$data['name'])?>" class="btn btn-style btn-primary mt-md-5 mt-4">Read more</a>
                                    <!--<a target="_blank" href="<?php echo $config["app_url"]?>product/<?php echo str_replace(" ","-",$data['name'])?>" class="">Read more</a>-->
                                </div>
                            </div>
                    </div>
                </li>
            <?php
          }
            ?>   
            </ul>
            <!--//coffee grids-grids-->
        </div>
    </div>
</section>