<!-- include Header -->
<?php 
include('include/header.php');
?>
<!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Certificate</h2>
          <ol>
            <li><a href="<?php echo $config["app_url"];?>">Home</a></li>
            <li>Verify Certificate</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
<!-- ======= Clients Section ======= -->
    <section id="clients" class="section-bg" style="background: #fff;">

      <div class="container" data-aos="fade-up"  style="min-height: 500px;">

        <div class="section-header">
          <h3>Verify Your Certificate</h3>
          
        </div>

        
            

         <form action="#" > 
          <div class="input-group mb-3">
            
    <input type="text" class="form-control" name="num" placeholder="ENTER YOUR CERTIFICATE REGISTRATION NUMBER">
    <div class="input-group-append">
      <button class="btn btn-success" type="submit">Check Status</button>  
     </div>
  </div>
</form>
          <?php
          if(!empty($_REQUEST['num']))
          {
            $res = get_record_by_status('certificate_verification',$_REQUEST['num']);
        while($data = mysqli_fetch_assoc($res))
        {
            ?>
            <table class="table">
    
    <tbody>
      <tr>
        <td>Company Name</td>
        <td><?php echo $data['company_name'];?></td>
        
      </tr>      
      <tr >
        <td>Registration Number</td>
        <td><?php echo $data['registration_number'];?></td>
        
      </tr>
      <tr >
        <td>Status</td>
        <td>
            <?php 
            if($data['status']==0)
                echo "<b>Not Active</b>";
            else if($data['status']==1)
                echo "<b>Active</b>";
            else
                echo "<b>Suspend</b>";
            ?>
            
        
      </tr>
      <tr >
        <td>Issue Date</td>
        <td><?php echo $data['issue_date'];?></td>
        
      </tr>
      <tr >
        <td>Expiry Date</td>
        <td><?php echo $data['expiry_date'];?></td>
        
      </tr>
      <tr >
        <td>Address</td>
        <td><?php echo $data['address'];?></td>
        
      </tr>
      <tr >
        <td>Standard</td>
        <td><?php echo $data['standard'];?></td>
        
      </tr>
      <tr >
        <td>Description</td>
        <td><?php echo $data['description'];?></td>
        
      </tr>
    </tbody>
  </table>
            <?php
          }
          }
          ?>
          
          
          
          
       

      </div>

    </section><!-- End Clients Section -->

<!-- include Footer -->
<?php 
include('include/footer.php');
?>