<!-- include Header -->
<?php 
include('include/header.php');
?>


<section class="w3l-servicesblock py-5" id="about">
    <div class="container pt-3">
   
        <div class="row pt-5">
           

             <div class="title-content col-lg-12 text-center">
                <h3 class="title-big text-center mb-md-5 mb-4">Certification</h3>
                 <h5 class="title-small text-center mb-1">CHHATARIYA RUBBER & CHEMICAL INDUSTRIES is recognized and certified by the following</h5>
             </div>


        </div>
        <div class="col-lg-12 pl-lg-5 mt-lg-0 mt-5 pt-5">
                <div class="row">

                    <!-- <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/ISI636.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">LICENSEE OF BUREAU OF INDIAN STANDARD (BIS)</h5>
                            
                        </div>
                    </div>

                    <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/ISI-14933.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">LICENSEE OF BUREAU OF INDIAN STANDARD (BIS)</h5>
                        </div>
                    </div>

                     <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/ISI-8423.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">LICENSEE OF BUREAU OF INDIAN STANDARD (BIS)</h5>
                        </div>
                    </div>

                    <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/UL.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">LISTED BY UNDERWRITER
                            LABORATORY INC. USA</h5>
                        </div>
                    </div>

                      <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/Lloyds.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">LLOYD'S REGISTER OF SHIPPING,U.K.</h5>
                        </div>
                    </div>

                      <div class="col-sm-4 grids-feature pt-2">
                         <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/MED-wheel-mark.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">MED WHEELMARK APPROVED UNDER EN 14540 (2004)</h5>
                        </div>
                    </div>
                   
                    <div class="col-sm-4 grids-feature pt-2">
                         <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/rohs.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">ISO 9001:2015 COMPANY CERTIFIED BY ROHS CERTIFICATION AND ACCREDITED BY IAF</h5>
                        </div>
                    </div>
 -->                    
                    <?php 
                        $result = get_all_certificate();
                        while($data = mysqli_fetch_assoc($result))
                        {
                           

                            ?>
                            <div class="col-sm-4 grids-feature pt-2">
                                <div class="area-box">
                                    <img src="<?php echo $config["app_url"];?>uploads/certification/<?php echo $data['image'] ?>" class="set-border-radious test-images " >
                                    <h5 class="pt-4"><?php echo $data["title"]?></h5>
                                </div>
                            </div>
                            <?php
                        }   

                     ?>




                    <!-- <div class="col-sm-4 grids-feature pt-2">
                        <div class="area-box">
                            <img src="<?php echo $config["app_url"];?>front/assets/images/certificate/iaf.jpg" class="rounded-circle test-images">
                            <h5 class="pt-4">MEMBERS OF MULTILATERAL RECOGNITION ARRANGEMENT.</a></h5>
                        </div>
                    </div> -->
                
                </div>
            </div>
        <div class="row  mt-5 approve_box">
        	
                <div class="col-lg-12">
                    <h3 class="title-big m-5 text-center">APPROVED BY</h3>
                </div>
        
            <div class="col-lg-12 row">
                <div class="col-lg-3">
                  <!-- <img src="<?php echo $config["app_url"];?>front/assets/images/CFI.png" width="300px" alt=""> -->
                </div>
               
            <div class="col-lg-6 text-center approved_by">
                
                <h5>DIRECTOR GENERAL OF SHIPPING, MUMBAI</h5>
                <h5>LICENSEE OF BUREAU OF INDUSTRIAL STANDARD(BIS)</h5>
               
                 <h5>MINISTRY OF SHIPPING, ROAD TRANSPORT & HIGHWAYS,</h5>
                <h5>MERCANTILE MARINE DEPARTMENT, GOVT. OF INDIA.</h5>
                <h5>TARIFF ADVISORY COMMITTEE, TAC-MUMBAI</h5>
                <h5>DIRECTOR GENERAL OF QUALITY ASSURANCE FOR</h5>
                <h5>REGISTERED AND APPROVED SUPPLIER IN INDIAN ARMY</h5>
                <h5>NAVY AND AIRFOECE</h5>

            </div>
            <div class="col-lg-3 approved_by">
              <!--  <h5>APPROVED SUPPLIER TO INDIAN ARMY, NAVY AND AIRFORCE</h5>
               <h5>DIRECTOR GENERAL OF SUPPLIES AND DISPOSAL-NEW DELHI</h5>
               <h5>APPROVED SUPPLIER UNDER RATE CONTRACT TO STATE FIRE SERVICES</h5>
               <h5>ORDINANCE FACTORIES AND OTHER GOVT. / SEMI GOVT. BODIES</h5> -->

            </div>
         </div>
      </div>  	
    </div>
</section>

<!-- include Footer -->
<?php 
include('include/footer.php');
?>