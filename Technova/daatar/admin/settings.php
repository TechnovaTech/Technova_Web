<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');

$table_name = "settings";

$result =get_record_by_id($table_name,1);
$data = mysqli_fetch_assoc($result);
if(isset($_POST['add_settings']))
{
	$data = array();
	
  if(isset($_FILES['image']))
  {
    $target_file = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'],"uploads/logo/".$target_file);
    $data['logo'] = $target_file;        
  }

	

		$data['keyword'] = $_POST['keyword'];
    $data['description'] = $_POST['description'];
    $data['whatsapp'] = $_POST['whatsapp'];
    $data['email'] = $_POST['email'];
		
		$result=update_records_by_id($table_name,$data,1);
		if($result==1)
		{
			?>
			<script type="text/javascript">
				alert("Settings Saved Successfully");
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
				alert("Faile to  Save Settings");
			</script>
			<?php
		}
		
	
	 

  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>settings";
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
        Clients
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header d-flex justify-content-center">
              <h3 class="box-title">Add Settings </h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form role="form" method="post" action="#" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="slidertext">Keyword</label>
                  <input type="text" name="keyword" class="form-control" id="certificationtext" placeholder="Enter Keyword" required="" value="<?php echo $data['keyword'];?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Description</label>
                  <input type="text" name="description" class="form-control" id="certificationtext" placeholder="Enter Description" required="" value="<?php echo $data['description'];?>"> 
                </div>
                <div class="form-group">
                  <label for="slidertext">WhatsApp Number</label>
                  <input type="text" name="whatsapp" class="form-control" id="certificationtext" placeholder="Enter WhatsApp Number" required="" value="<?php echo $data['whatsapp'];?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Email</label>
                  <input type="text" name="email" class="form-control" id="certificationtext" placeholder="Enter Email" required="" value="<?php echo $data['email'];?>">
                </div>
                <div>
                  <label>Image  Preview</label><br>
                  <img  src="<?php echo $config["app_url"];?>uploads/logo/<?php echo $data['logo'];?>"  height="200px" max-width="100%" class="img-preview" >
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <input type="file" name="image" id="exampleInputFile" accept="images/png,image/jpg,image/jpeg" >

                  
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="add_settings" class="btn btn-primary">Sav Settings</button>
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
<!--===========include Footer=============