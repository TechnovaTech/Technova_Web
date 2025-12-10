<!--===========include header & navigation menu=============-->
<?php 
include('include/header.php');
include('include/nav.php');
?>
<!--===========include header & navigation menu=============-->



<!-- =====================main container====================-->

  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Catalogues 
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Catalogues</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header d-flex justify-content-center">
              <h3 class="box-title">Catalogues List</h3>
              <a href="addcatalogues" class="btn btn-primary add-product">Add New Catalogues</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Product Id</th>
                  <th>File</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>



                  <!-- Display all Catalogues-->
                  <?php 
                    $result = get_all_catalogues();
                    while($data = mysqli_fetch_assoc($result))
                    { 
                      ?>
                      <tr>
                        <td><?php echo $data['id'] ?></td>
                        <td><?php echo $data['product_id'] ?></td>
                        <td><?php echo $data['file'] ?></td>
                        <td>
                            <a href="updatecatalogues/<?php echo $data['id'] ?>" class=""><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                            <a onclick="doyou(<?php echo $data['id'] ?>)"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a> 
                        </td>
                      </tr>
                      
                      <?php
                    }
                  ?>
                  <!-- Display all Catalogues-->



                </tbody>
              </table>
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





<script type="text/javascript">
   function doyou(id)
   {
    var conf =  confirm("Do You Want to Delete");
    if(conf == true)
    {
      location.href = '<?php echo $config["app_url"]; ?>removecatalogues/'+id;
    }
   }
</script>
    

   
 


  

<!--===========include Footer=============-->
<?php 
include("include/footer.php");
?>
<!--===========include Footer=============>