<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');

if(isset($uri_segments[2]))
{
  $slider_id = $uri_segments[2];
}

$table_name = "certificate_verification";

$result =get_record_by_id($table_name,$slider_id);
$data = mysqli_fetch_assoc($result);

if(isset($_POST['add_status']))
{
	$data = array();
	

	 

	

		$data['company_name'] = $_POST['company_name'];
    $data['registration_number'] = $_POST['registration_number'];
    $data['status'] = $_POST['status'];
    $data['issue_date'] = $_POST['issue_date'];
    $data['expiry_date'] = $_POST['expiry_date'];
    $data['date_1st_surveillance'] = $_POST['date_1st_surveillance'];
    $data['date_2nd_surveillance'] = $_POST['date_2nd_surveillance'];
    $data['address'] = $_POST['address'];
    $data['standard'] = $_POST['standard'];
    $data['description'] = $_POST['description'];
		
		
    $table_name = "certificate_verification";

   $result = update_records_by_id($table_name,$data,$slider_id);
		if($result==1)
		{
			?>
			<script type="text/javascript">
				alert("Certification Status Updated Successfully");
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
				alert("Faile to  Uploaded Certification Status");
			</script>
			<?php
		}
		
	
	 

  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>certificationstatus";
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
        Certification Status
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Certication Status</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header d-flex justify-content-center">
              <h3 class="box-title">Add Certification Status</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form role="form" method="post" action="#" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="slidertext">Company Name</label>
                  <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter text" required="" value="<?php echo $data['company_name']?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Register Number</label>
                  <input type="text" name="registration_number" class="form-control" id="registration_number" placeholder="Enter text" required="" value="<?php echo $data['registration_number']?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Status</label>
                  <select class="form-control" name="status">
                    <option value="0" <?php echo ($data['registration_number']==0) ? "selected" : ""; ?> >Not Active</option>
                    <option value="1" <?php echo ($data['registration_number']==0) ? "selected" : ""; ?>>Active</option>
                    <option value="2" <?php echo ($data['registration_number']==0) ? "selected" : ""; ?>>Suspend</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="slidertext">Issue Date</label>
                  <input type="date" name="issue_date" class="form-control" id="issue_date" placeholder="Enter text" required="" value="<?php echo $data['issue_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Expiry Date</label>
                  <input type="date" name="expiry_date" class="form-control" id="expiry_date" placeholder="Enter text" required="" value="<?php echo $data['expiry_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Date of 1st Surveillance</label>
                  <input type="date" name="date_1st_surveillance" class="form-control" id="date_1st_surveillance" placeholder="Enter text" required="" value="<?php echo $data['date_1st_surveillance']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Date of 2nd Surveillance</label>
                  <input type="date" name="date_2nd_surveillance" class="form-control" id="date_2nd_surveillance" placeholder="Enter text" required="" value="<?php echo $data['date_2nd_surveillance']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Address</label>
                  <input type="text" name="address" class="form-control" id="address" placeholder="Enter text" required="" value="<?php echo $data['address']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Standard</label>
                  <input type="text" name="standard" class="form-control" id="standard" placeholder="Enter text" required="" value="<?php echo $data['standard']; ?>">
                </div>
                <div class="form-group">
                  <label for="slidertext">Remarks</label>
                  <input type="text" name="description" class="form-control" id="description" placeholder="Enter text" required="" value="<?php echo $data['description']; ?>">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="add_status" class="btn btn-primary">Update Status</button>
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