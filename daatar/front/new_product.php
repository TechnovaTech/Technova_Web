<!-- include Header -->
<?php 
include('include/header.php');
?>
<!-- tabs team-->
<section class="team py-5" id="team">
    <div class="container py-lg-5 py-md-4 py-2">
        <ul class="nav nav-pills" id="pills-tab1" role="tablist">
            <?php  

        $res = get_all_records('product');
        while($data = mysqli_fetch_assoc($res))
        {
          ?>    
            <li class="nav-item" title="<?php echo $data["name"]?>" >
                <a class="nav-link active" id="#<?php echo $data['id'] ?>" data-toggle="pill" href="<?php echo $data['id'] ?>" role="tab" aria-controls="pills-team1" aria-selected="true"><img src="<?php echo $config['app_url'];?>uploads/products/<?php echo $data['image1']?>" class="img-fluid" alt="" /></a>
            </li>
          <?php 
        }
          ?>
            
            
        </ul>
        <div class="tab-content" id="pills-tabContent1">
            <div class="tab-pane fade show active" id="pills-team1" role="tabpanel" aria-labelledby="pills-team1-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/1.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Espresso <span>Short & Intense - $19.50</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team2" role="tabpanel" aria-labelledby="pills-team2-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/2.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Americano <span> Simple and smooth - $17.50</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team3" role="tabpanel" aria-labelledby="pills-team3-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/3.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Latte
                            <span>Mild & Milky - $11.90</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team4" role="tabpanel" aria-labelledby="pills-team4-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/4.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Cappuccino
                            <span>Famously frothy - $9.00</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-team5" role="tabpanel" aria-labelledby="pills-team1-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/1.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Cortado
                            <span>Small & Luxurious - $15.00</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team2" role="tabpanel" aria-labelledby="pills-team6-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/2.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Flat White
                            <span>Rich & Velvety - $11.99</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team3" role="tabpanel" aria-labelledby="pills-team7-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/3.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Espresso <span>Short & Intense - $19.50</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-team4" role="tabpanel" aria-labelledby="pills-team8-tab">
                <div class="team-grids row">
                    <div class="col-lg-6">
                        <img src="assets/images/4.png" class="img-fluid" alt="" />
                    </div>
                    <div class="col-lg-6 align-self mt-lg-0 mt-md-5 mt-4">
                        <h4>Latte
                            <span>Mild & Milky - $08.50</span></h4>
                        <p class="pt-3">Donec malesuada ex sit amet pretium sid ornare. Nulla congue scelerisque tellus, utpretium. Mauris suscipit
                        nisi ut ipsum egestas, et velit convallis. Phasellus rhoncus tempus. </p>
                        <a href="#buy" class="btn btn-style btn-primary mt-md-5 mt-4">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- include Footer -->
<?php 
include('include/footer.php');
?>