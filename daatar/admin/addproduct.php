<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');

if(isset($_POST['upload_product']))
{
 

  $data = array();
  
  

  // Upload Images
  $targent_folder = "uploads/products/";
  $filename1 = $_FILES["image1"]["name"];
  $tempname1 = $_FILES["image1"]["tmp_name"];  
  $filename2 = $_FILES["image2"]["name"];
  $tempname2 = $_FILES["image2"]["tmp_name"];  

  if(move_uploaded_file($tempname1, $targent_folder.$filename1) && move_uploaded_file($tempname2, $targent_folder.$filename2))
  {

    // Set Parameters
    $data['name'] = $_POST['product_name'];
    $data['description'] = $_POST['product_description'];
    $data['image1'] = $filename1;
    $data['image2'] = $filename2;
    $data['page_type']  = $_POST['page_type'];


    // Call Function
    $result = add_new_product($data);
    // Cheack Function Call
    if($result == 1)
    {
      ?>
      <script type="text/javascript">
        alert("Service Inserted Sucessfully");
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
    location.href = "<?php echo $config["app_url"];?>pageslist";
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
        Add Pages
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add Pages</li>
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
                    <option value="1">Service</option>
                    <option value="2">Support From International Audit</option>
                    
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Page Title" name="product_name" required="">
                </div>
                

                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                    <textarea id="editor1" name="product_description" rows="10" cols="80" required="">
                        
                    </textarea>
                  </div>




                <div class="form-group">
                  <label for="exampleInputFile">Image 1</label>
                  <input type="file" id="exampleInputFile" name="image1" required="">
                </div>

                 <div class="form-group">
                    <label for="exampleInputFile">Image 2</label>
                    <input type="file" id="exampleInputFile" name="image2" required="">
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