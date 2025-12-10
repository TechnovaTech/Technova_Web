<?php 
include('config/config.php');

function get_all_sliders()
{
	global $connection;
	$sql = "SELECT * FROM `slider` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_about_details()
{
	global $connection;
	$sql = "SELECT * FROM `aboutus` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_contactus_details()
{
	global $connection;
	$sql = "SELECT * FROM `contactus` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_home_details()
{
	global $connection;
	$sql = "SELECT * FROM `home` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_all_gallery_iamges()
{
	global $connection;
	$sql = "SELECT * FROM `gallery` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}

function get_all_products()
{
	global $connection;
	$sql = "SELECT * FROM `product` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_all_products_cat($type)
{
	global $connection;
	$sql = "SELECT * FROM `product` WHERE product_type=".$type;
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_all_records($table_name)
{
	global $connection;
	$sql = "SELECT * FROM `".$table_name."` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}

function get_product_by_id($id)
{
	global $connection;
	$sql = "SELECT * FROM `product` WHERE id='".$id."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}

function get_product_by_name($name)
{
	global $connection;
	$sql = "SELECT * FROM `product` WHERE name='".$name."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_all_certificate()
{
	global $connection;
	$sql = "SELECT * FROM `certification` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_record_by_id($table_name,$id)
{
	global $connection;
	$sql = "SELECT * FROM  `".$table_name."`  WHERE  id = '".$id."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}
function get_record_by_status($table_name,$id)
{
	global $connection;
	$sql = "SELECT * FROM  `".$table_name."`  WHERE  registration_number = '".$id."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}
?>