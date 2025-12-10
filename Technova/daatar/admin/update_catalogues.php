<!--===========include header & navigation menu=============-->
<?php 
include('admin/include/header.php');
include('admin/include/nav.php');

if(isset($uri_segments[2]))
{
  $id = $uri_segments[2];
}

$table_name = "catalogue";

$result =get_record_by_id($table_name,$id);
$data = mysqli_fetch_assoc($result);


if(isset($_POST['upload_catalogue']))
{

  $new_data = array();
  $targent_folder ="uploads/catalogues/";

  if(isset($_FILES['cat_file']))
  {
    $filename1 = $_FILES["cat_file"]["name"];
    $tempname1 = $_FILES["cat_file"]["tmp_name"];
    if(move_uploaded_file($tempname1, $targent_folder.$filename1))
    {
      $new_data['file'] = $filename1;
    }
  }


  $new_data['product_id'] = $_POST['product_id'];
  $table_name = "catalogue";
  
  
   $result = update_records_by_id($table_name,$new_data,$id);
   if($result==1)
   {
    ?>
    <script type="text/javascript">
      alert("Catalogue Updated Sucessfully");
    </script>
    <?php
   }else
   {
    ?>
    <script type="text/javascript">
      alert("Certification updation Fail");
    </script>
    <?php
   }
   ?>
    <script type="text/javascript">
      location.href = "<?php echo $config["app_url"];?>catalogueslist";
    </script>
   <?php
}

?>


<!-- =====================main container====================-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Catalogue
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Update Catalogue</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Example</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="box-body">

                
                
                <div class="form-group">
                <label>Minimal</label>
                <select class="form-control select2" style="width: 100%;" name="product_id" required="">
                  <?php 
                    $result = get_products_name_list();
                    while($row = mysqli_fetch_assoc($result))
                    {
                      ?>
                      <option value="<?php echo $row['id'];?>"><?php echo $row['name'] ?></option>
                      <?php
                    }
                   ?>
                </select>
              </div>
              
                <div>
                  <label>Old File</label><br>
                 <input type="text" name="old_file" disabled="" value="<?php echo $data['file'];?>">
                </div>



                <div class="form-group">
                  <label for="exampleInputFile">File</label>
                  <input type="file" id="exampleInputFile" name="cat_file" >
                </div>  

                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="upload_catalogue">Upload</button>
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