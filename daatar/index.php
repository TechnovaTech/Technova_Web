<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

$page_name = "";

$page = $uri_segments[1];//$_GET['page'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
$mail = new PHPMailer(true);

switch ($page) {

  //========== Home Page ===========
  case "home":
  include('admin/edithome.php');
  break;
  //================================
  case "aboutus":
  include('admin/aboutus.php');
  break;
  //================================
  case "contactus":
  include('admin/contactus.php');
  break;
  //========== Amin Dashboard========
  case "dashboard": 
    include('admin/dashboard.php');
    break;
  // =================================

  //========== Amin Login page========
  case "login":
    include('admin/login.php');
    break;
  // ==================================
  case "logout":
    include('admin/logout.php');
    break;
    
  //=============Products List=============
  case "pageslist":
    include("admin/productslist.php");
    break;
  //===================================

  //=============Add new Products =============
  case "addservice":
    include("admin/addproduct.php");
    break;
 //===================================

  //=============catalogues List =============
  case "catalogueslist":
    include("admin/catalogueslist.php");
    break;
  //===================================

  //=============catalogues List =============
  case "addcatalogues":
    include("admin/add_catalogues.php");
    break;
  //===================================


 case "sliders":
    include("admin/sliderslist.php");
    break;

  case "addslider":
    include("admin/addslider.php");
    break;


  case "certification":
    include("admin/certificationlist.php");
    break;

  case "addcertification":
    include("admin/addcertification.php");
    break;

  case "changepassword":
    include("admin/change_password.php");
    break;  
  
 

   case "clients":
    include("admin/gallery_list.php");
    break;

  case "addclient":
    include("admin/add_gallery.php");
    break;

  case "updatepage":
    include("admin/update_product.php");
    break;

  case "updateslider":
    include("admin/update_slider.php");
    break;
  case "updatecertification":
    include("admin/update_certification.php");
    break;
  case "updatecatalogues":
    include("admin/update_catalogues.php");
    break;
  case "updategallery":
    include("admin/update_gallery.php");
    break;


  case "removeproduct":
    include("admin/remove_product.php");
    break;

  case "removeslider":
    include("admin/remove_slider.php");
    break;
  case "removecertification":
    include("admin/remove_certification.php");
    break;
  case "removecatalogues":
    include("admin/remove_catalogues.php");
    break;
  case "removegallery":
    include("admin/remove_gallery.php");
    break;

    case "addcertificationstatus":
    include("admin/add_status.php");
    break;
case "updatecertificationstatus":
    include("admin/update_status.php");
    break;    
case "deletecertificationstatus":
    include("admin/remove_status.php");
    break;
case "certificationstatus":
    include("admin/list_status.php");
    break;    
  //===================Front===================== 
  case "":
   $page_name = "";
    include("front/home.php");
    break;

  case "about-us":
  $page_name = "about";
    include("front/about.php");
    break;

  case "products":
  $page_name = "products";
    include("front/products.php");
    break;

  case "contact-us":
  $page_name = "contact-us";
    include("front/contact.php");
    break;
    
  case "certificate":
  $page_name = "certificate";
    include("front/certificate.php");
    break;

  case "our-client":
  $page_name = "test";
    include("front/test.php");
    break;

case "verify-certificate":
  $page_name = "verify certificate";
    include("front/verify.php");
    break;  
    
  case "service":
  $page_name = "products";
    include("front/product_description.php");
    break;

  default:
    //header('location:http://localhost/datareng');
}
?>