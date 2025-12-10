<?php 

include('include/header.php');
include('include/nav.php');

if(isset($uri_segments[2]))
{
  $product_id = $uri_segments[2];
}
$table = "product";

$res = remove_record_by_id($table,$product_id);

if($res)
{
	?>
	<script type="text/javascript">
        alert("Product Deleted Sucessfully");
      </script>
	<?php 
}
else
{
	?>
	<script type="text/javascript">
        alert("Product Deletion Fail");
      </script>
	<?php
}
include("include/footer.php");
?>
<script type="text/javascript">
	location.href = "<?php echo $config["app_url"];?>productslist";
</script>