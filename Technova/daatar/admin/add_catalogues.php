<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');

if(isset($_POST['upload_catalogue']))
{ 
 
  $data = array();
  
  // Upload Images
  $targent_folder = "uploads/catalogues/";
  $filename1 = $_FILES["catalogues_file"]["name"];
  $tempname1 = $_FILES["catalogues_file"]["tmp_name"];  
 

  if(move_uploaded_file($tempname1, $targent_folder.$filename1) )
  {
    // Set Parameters
    $data['product_id'] = $_POST['product_id'];
  
    $data['file'] = $filename1;
    

    // Call Function
    $result = add_new_catalogue($data);


    // Cheack Function Call
    if($result == 1)
    {
      ?>
      <script type="text/javascript">
        alert("Catalogue Uploaded Sucessfully");
      </script>
      <?php
    }
    else
    {
      ?>
      <script type="text/javascript">
        alert("Fail To Uploaded Catalogue");
      </script>
      <?php
    }
   
  }

  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>catalogueslist";
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
        Add new Catalogue
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add new Catalogue</li>
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
              
              


                <div class="form-group">
                  <label for="exampleInputFile">File</label>
                  <input type="file" id="exampleInputFile" name="catalogues_file" required="">
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