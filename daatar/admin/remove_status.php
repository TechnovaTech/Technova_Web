<?php 

include('include/functions.php');
if(isset($uri_segments[2]))
{
  $product_id = $uri_segments[2];
}
$table = "certificate_verification";

$res = remove_record_by_id($table,$product_id);
if($res)
{
	?>
	<script type="text/javascript">
        alert("Certification Status Deleted Sucessfully");
      </script>
	<?php
}
else
{
	?>
	<script type="text/javascript">
        alert("Certification Deletion Fail");
      </script>
	<?php
}

?>
<script type="text/javascript">
	location.href = "<?php echo $config["app_url"];?>certificationstatus";
</script>