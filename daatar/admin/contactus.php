<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');


$table_name = "contactus";

$result =get_record_by_id($table_name,1);
$data = mysqli_fetch_assoc($result);

if(isset($_POST['upload_product']))
{
 

  $data = array();
  
  

 

  

    // Set Parameters
    $data['content'] = $_POST['content'];
    $data['contact'] = $_POST['contact'];

    // Call Function
    $result = update_records_by_id($table_name,$data,1);
    // Cheack Function Call
    if($result == 1)
    {
      ?>
      <script type="text/javascript">
        alert("Contactus Content Updated Sucessfully");
      </script>
      <?php
    }
    else
    {
      ?>
      <script type="text/javascript">
        alert(" Fail To Upload Product");
      </script>
      <?php
    }
  

  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>contactus";
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
        Contact Us
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Contact Us</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Page Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="box-body">

                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                    <textarea id="editor1" name="content" rows="10" cols="80" required="">
                        <?php echo $data['content'] ?>
                    </textarea>
                  </div>



                <br>
                <div class="form-group">
                  <label for="exampleInputFile">Contact Number <b>(Separate multiple number with comma ,)</b></label>
                  <input type="text" class="form-control" name="contact" value="<?php echo $data['contact'] ?>">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="upload_product">Save</button>
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