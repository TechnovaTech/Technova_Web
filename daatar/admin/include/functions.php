<?php 
include('session.php');
include('config/config.php');

// =======================================ADMIN LOIGN==================================================

function login($username,$password)
{
	global $connection;
	$password = md5($password);
	$sql = "select * from `users` where username = '".$username."' and password = '".$password."'";
	$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result) == 1)
	{
		set_admin_session($username);
		return 1;
	}
	else
	{
		return 0;
	}

}

// ===========Set Admin Session===============
function set_admin_session($admin)
{
	$_SESSION['auth_user'] = md5($admin);
}


// Change Password
function change_password($data)
{
	global $connection;
	$password = md5($data['new_password']);
	$sql = "UPDATE `users` SET `password`='".$password."' WHERE id=1";
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

// ======================================================================================================






//=====================Products Function()===========================


//=========Diplsay All Products================
function get_all_products()
{
	global $connection;
	$sql = "SELECT * FROM `product` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}

// ==============================================



//=========Add New Products=======================
function add_new_product($data)
{
	global $connection;
	$sql = "INSERT INTO `product`(`name`, `description`, `image1`, `image2`,`page_type`) VALUES ('".$data['name']."' , '".$data['description']."', '".$data['image1']."', '".$data['image2']."','".$data['page_type']."')";
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
// ================================================


//======================/Products Function()============================


// =======================Sliders Functions()======================
function get_all_slider()
{
	global $connection;
	$sql = "SELECT * FROM `slider`";
	$result = mysqli_query($connection,$sql);
	return $result;
}



function insert_slider($data)
{

	global $connection;
	$sql = "INSERT INTO `slider`(`title`, `text`, `image`) VALUES ('".$data['title']."','".$data['text']."','".$data['image']."')";



	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//======================/Sliders Functions()============================

// ============================Certificate Function()=========================
function get_all_certification()
{
	global $connection;
	$sql = "SELECT * FROM `certification`";
	$result = mysqli_query($connection,$sql);
	return $result;
}


function insert_certification($data)
{

	global $connection;
	$sql = "INSERT INTO `certification`(`title`, `image`) VALUES ('".$data['title']."','".$data['image']."')";
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function insert_certification_status($data)
{

	global $connection;
	$sql = "INSERT INTO `certificate_verification` (`company_name`, `registration_number`, `status`, `issue_date`, `expiry_date`, `date_1st_surveillance`, `date_2nd_surveillance`, `address`, `standard`, `description`) VALUES ('".$data['company_name']."','".$data['registration_number']."','".$data['status']."','".$data['issue_date']."','".$data['expiry_date']."','".$data['date_1st_surveillance']."','".$data['date_2nd_surveillance']."','".$data['address']."','".$data['standard']."','".$data['description']."')";
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
//============================/Certificate Function()=========================





//=============================Catalogue Functions()======================



//=========Diplsay All catalogue================
function get_all_catalogues()
{
	global $connection;
	$sql = "SELECT * FROM `catalogue` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
// ============================================

//=========Add New catalogue=======================
function add_new_catalogue($data)
{
	global $connection;
	$sql = "INSERT INTO `catalogue`( `product_id`, `file`) VALUES ('".$data['product_id']."' , '".$data['file']."')";
	
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
// ================================================



function get_products_name_list()
{
	global $connection;
	$sql = "SELECT `id`,`name` FROM `product` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}



//=============================/Catalogue Functions()======================



//===============Gallery Functions()======================

//=========Diplsay All catalogue================
function get_all_gallery()
{
	global $connection;
	$sql = "SELECT * FROM `gallery` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
// ============================================

function insert_gallery($data)
{

	global $connection;
	$sql = "INSERT INTO `gallery`(`title`, `image`) VALUES ('".$data['title']."','".$data['image']."')";
	$result = mysqli_query($connection,$sql);
	if(isset($result))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//===============/Gallery Functions()======================


function update_records_by_id($table_name,$data,$id)
{
	global $connection;
    $columns = '';
    $values = '';
    $set = '';
	foreach ($data as $col => $value) {

		$set .= "`".$col."`='".$value."',";

	}
	$set = substr_replace($set, "", -1);
	$sql =  "UPDATE `".$table_name."` SET ".$set." WHERE id='".$id."'";
	
	$result = mysqli_query($connection,$sql);
	if($result)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}



function get_record_by_id($table_name,$id)
{
	global $connection;
	$sql = "SELECT * FROM  `".$table_name."`  WHERE  id = '".$id."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}

function pre($data)
{
	echo "<pre>";
	echo $data;
	die();

}

function remove_record_by_id($table_name,$id)
{
	global $connection;
	$sql = "DELETE FROM `".$table_name."` WHERE id='".$id."'";
	$result = mysqli_query($connection,$sql);
	return $result;
}

function get_all_status()
{
	global $connection;
	$sql = "SELECT * FROM `certificate_verification` WHERE 1";
	$result = mysqli_query($connection,$sql);
	return $result;
}
?>