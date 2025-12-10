<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');


$table_name = "aboutus";

$result =get_record_by_id($table_name,1);
$data = mysqli_fetch_assoc($result);

if(isset($_POST['upload_product']))
{
 

  $data = array();
  
  

  // Upload Images
  $targent_folder = "uploads/home/";
  $filename1 = $_FILES["image1"]["name"];
  $tempname1 = $_FILES["image1"]["tmp_name"];  

  if(move_uploaded_file($tempname1, $targent_folder.$filename1))
  {

    // Set Parameters
    $data['content'] = $_POST['content'];
    $data['about_image'] = $filename1;

    // Call Function
    $result = update_records_by_id($table_name,$data,1);
    // Cheack Function Call
    if($result == 1)
    {
      ?>
      <script type="text/javascript">
        alert("Aboutus Content Updated Sucessfully");
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
  }

  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>aboutus";
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
        About Us
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">About Us</li>
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




                <div>
                  <label>Image 1 Preview</label><br>
                  <img  src="<?php echo $config["app_url"];?>uploads/home/<?php echo $data['about_image'];?>"  height="200px" max-width="100%" class="img-preview" >
                </div>

                <br>
                <div class="form-group">
                  <label for="exampleInputFile">Image 1</label>
                  <input type="file" id="exampleInputFile" name="image1" >
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="upload_product">Upload And Save</button>
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