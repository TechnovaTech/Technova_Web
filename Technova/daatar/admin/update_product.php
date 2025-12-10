<!--===========include header & navigation menu=============-->
<?php 
include('admin/include/header.php');
include('admin/include/nav.php');

if(isset($uri_segments[2]))
{
  $product_id = $uri_segments[2];
}

$table_name = "product";

$result =get_record_by_id($table_name,$product_id);
$data = mysqli_fetch_assoc($result);

if(isset($_POST['update_product']))
{

  $new_data = array();
  $targent_folder ="uploads/products/";

  if(isset($_FILES['image1']))
  {
    
    $filename1 = $_FILES["image1"]["name"];
    $tempname1 = $_FILES["image1"]["tmp_name"];
    if(move_uploaded_file($tempname1, $targent_folder.$filename1))
    {
      $new_data['image1'] = $filename1;
    }
  }

  if(isset($_FILES['image2']))
  {
    
    $filename2 = $_FILES["image2"]["name"];
    $tempname2 = $_FILES["image2"]["tmp_name"];
    if(move_uploaded_file($tempname2, $targent_folder.$filename2))
    {
      $new_data['image2'] = $filename2;
    }
  }

  $new_data['name'] = $_POST['product_name'];
  $new_data['description'] = $_POST['product_description'];
  $new_data['page_type'] = $_POST['page_type'];
  $table_name = "product";

   $result = update_records_by_id($table_name,$new_data,$product_id);
   if($result==1)
   {
    ?>
    <script type="text/javascript">
      alert("Product Updated Sucessfully");
    </script>
    <?php
   }else
   {
    ?>
    <script type="text/javascript">
      alert("Product updation Fail");
    </script>
    <?php
   }
   ?>
    <script type="text/javascript">
      //location.href = "<?php echo $config["app_url"];?>pageslist";
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
        Update Page
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Update Page</li>
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
                  <label for="exampleInputEmail1">Page Type</label>
                  <select class="form-control" id="page_type" name="page_type">
                    <option value="1" <?php echo ($data['page_type']==1) ? "selected" : ""; ?> >Service</option>
                    <option value="2" <?php echo ($data['page_type']==2) ? "selected" : ""; ?> >Support From International Audit</option>
                    
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Page Title" name="product_name" required="" value=" <?php echo $data['name'] ?> ">
                </div>
                

                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                    <textarea id="editor1" name="product_description" rows="10" cols="80" required="" value="">
                        <?php echo $data['description'] ?>
                    </textarea>
                  </div>



                <div>
                  <label>Image 1 Preview</label><br>
                  <img  src="<?php echo $config["app_url"];?>uploads/products/<?php echo $data['image1'];?>"  height="200px" max-width="100%" class="img-preview" >
                </div>

                <br>
                <div class="form-group">
                  <label for="exampleInputFile">Image 1</label>
                  <input type="file" id="exampleInputFile" name="image1" >
                </div>

                <div>
                  <label>Image 2 Preview</label><br>
                  <img  src="<?php echo $config["app_url"];?>uploads/products/<?php echo $data['image2'];?>"  height="200px" max-width="100%" class="img-preview">
                </div>

                 <br>
                 <div class="form-group">
                    <label for="exampleInputFile">Image 2</label>
                    <input type="file" id="exampleInputFile" name="image2" >
                  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="update_product">Update Page</button>
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