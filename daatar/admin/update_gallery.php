<!--===========include header & navigation menu=============-->
<?php 
include('admin/include/header.php');
include('admin/include/nav.php');

if(isset($uri_segments[2]))
{
  $id = $uri_segments[2];
}

$table_name = "gallery";

$result =get_record_by_id($table_name,$id);
$data = mysqli_fetch_assoc($result);


if(isset($_POST['update_gallery']))
{

  $new_data = array();
  $targent_folder ="uploads/gallery/";

  if(isset($_FILES['image']))
  {
    $filename1 = $_FILES["image"]["name"];
    $tempname1 = $_FILES["image"]["tmp_name"];
    if(move_uploaded_file($tempname1, $targent_folder.$filename1))
    {
      $new_data['image'] = $filename1;
    }
  }


  $new_data['title'] = $_POST['title'];
  $table_name = "gallery";
  
  
   $result = update_records_by_id($table_name,$new_data,$id);
   if($result==1)
   {
    ?>
    <script type="text/javascript">
      alert("Gallery Updated Sucessfully");
    </script>
    <?php
   }else
   {
    ?>
    <script type="text/javascript">
      alert("Gallery updation Fail");
    </script>
    <?php
   }
   ?>
    <script type="text/javascript">
      location.href = "<?php echo $config["app_url"];?>gallery";
    </script>
   <?php
}

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Gallery
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Gallery</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header d-flex justify-content-center">
              <h3 class="box-title">Update Gallery </h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form role="form" method="post" action="#" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="slidertext">Title</label>
                  <input type="text" name="title" class="form-control" id="certificationtext" placeholder="Enter text" required="" value="<?php echo $data['title'] ?> ">
                </div>

                <div>
                  <label>Image  Preview</label><br>
                  <img  src="<?php echo $config["app_url"];?>uploads/gallery/<?php echo $data['image'];?>"  height="200px" max-width="100%" class="img-preview" >
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <input type="file" name="image" id="exampleInputFile" accept="images/png,image/jpg,image/jpeg">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update_gallery" class="btn btn-primary">Submit</button>
              </div>
            </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->


</div>
<!-- /Content Wrapper. Contains page content -->



  
  

<!--===========include Footer=============-->
<?php 
include("include/footer.php");
?>
<!--===========include Footer=============>