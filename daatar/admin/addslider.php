 <!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');


if(isset($_POST['add_slider']))
{
	$data = array();
	

	 $target_file = basename($_FILES['image']['name']);

	if(move_uploaded_file($_FILES['image']['tmp_name'],"uploads/sliders/".$target_file))
	{

		$data['text'] = $_POST['text'];
		$data['image'] = $target_file;
    $data['title'] = $_POST['title'];
		$result=insert_slider($data);
  
		if($result==1)
		{
			?>
			<script type="text/javascript">
				alert("Silder Added Sucessfully");
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
				alert("Fail To upload Silder");
			</script>
			<?php
		}
		
	}
  ?>
  <script type="text/javascript">
    location.href = "<?php echo $config["app_url"];?>sliders";
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
        Sliders 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Sliders</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header d-flex justify-content-center">
              <h3 class="box-title">Add new Slider</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form role="form" method="post" action="#" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="slidertext">Slider Title</label>
                  <input type="text" name="title" class="form-control" id="slidertext" placeholder="Enter Title" required="">
                </div>

                <div class="form-group">
                  <label for="slidertext">Slider Text</label>
                  <input type="text" name="text" class="form-control" id="slidertext" placeholder="Enter text" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="image" id="exampleInputFile" accept="images/png,image/jpg,image/jpeg" required="">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="add_slider" class="btn btn-primary">Submit</button>
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