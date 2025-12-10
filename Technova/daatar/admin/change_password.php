<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');

if(isset($_POST['change_pass']))
{
 
  $data = array();
  
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if($new_password == $confirm_password)
    {

      $data['new_password'] = $confirm_password;

      // Call Function
       $result = change_password($data);

        // Cheack Function Call
        if($result == 1)
        {
          ?>
          <script type="text/javascript">
            alert("Password Updated Sucessfully");
          </script>
          <?php
          
        }
        else
        {
          ?>
          <script type="text/javascript">
            alert("Password Update Fail");
          </script>
          <?php
        }
    }
    else
    {

      ?>
      <script type="text/javascript">
        alert("Confirm Password is not Match with New Password");
      </script>
      <?php

    }
    
    ?>
    <script type="text/javascript">
      location.href = "<?php echo $config["app_url"];?>dashboard";
    </script>
    <?php
  

}

?>
<!--===========include header & navigation menu=============-->



<!-- =====================main container====================-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="#" method="post" enctype="multipart/form-data">

              <div class="box-body">


                <div class="form-group">
                  <label for="exampleInputEmail1">New Password</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter New Password" name="new_password" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Confirm Password" name="confirm_password" required="">
                </div>

                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="change_pass">Change</button>
              </div>
            </form>
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ========================================================= -->


  

<!--===========include Footer=============-->
<?php 
include("include/footer.php");
?>
<!--===========include Footer=============>