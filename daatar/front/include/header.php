<?php 
include("front/include/functions.php");
$table_name = "settings";

$result =get_record_by_id($table_name,1);
$home = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Datar Certification Support PVT LTD</title>
  <meta content="<?php echo $home['keyword'];?>" name="description">
  <meta content="<?php echo $home['description'];?>" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo $config["app_url"]; ?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo $config["app_url"]; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo $config["app_url"]; ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo $config["app_url"]; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $config["app_url"]; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $config["app_url"]; ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo $config["app_url"]; ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo $config["app_url"]; ?>assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NewBiz
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/newbiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style type="text/css">
    .side-icon-whataspp
    {
          height: 75px;
    display: flex;
    position: fixed;
    z-index: 3;
    margin-top: 200px;
    }
    .side-icon-email
    {
          height: 70px;
    display: flex;
    position: fixed;
    z-index: 3;
    margin-top: 270px;
    }
  </style>
</head>

<body>
  <a href="mailto:<?php echo $home['email'];?>">
<img src="<?php echo $config["app_url"];?>/uploads/email.png" class="side-icon-email">
</a>
<a target="_blank" href="https://wa.me/<?php echo $home['whatsapp'];?>">
<img src="<?php echo $config["app_url"];?>/uploads/whatsapp.png" class="side-icon-whataspp">
</a>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between">

      <div class="logo">
        <!-- Uncomment below if you prefer to use an text logo -->
        <!-- <h1><a href="index.html">NewBiz</a></h1> -->
        <a href="<?php echo $config["app_url"];?>"><img src="<?php echo $config["app_url"]; ?>uploads/logo/<?php echo $home["logo"]; ?>" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="<?php echo $config["app_url"];?>">Home</a></li>
          <li><a class="nav-link scrollto" href="<?php echo $config["app_url"];?>about-us">About Us</a></li>
         <?php
         $data = get_all_products();
                
         ?>
          <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <?php
              while($row = mysqli_fetch_assoc($data)){
                if($row['page_type']==1)
                {
              ?>
              <li><a href="<?php echo $config["app_url"].'service/'.str_replace(' ', '-', $row['name']); ?>"><?php echo $row['name'];?></a></li>
              <?php
            }
            }
              ?>
            </ul>
          </li>

          <li class="dropdown"><a href="#"><span>Support From International Audit</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <?php
              $data = get_all_products();
              while($row = mysqli_fetch_assoc($data)){
                if($row['page_type']==2)
                {
              ?>
              <li><a href="<?php echo $config["app_url"].'service/'.str_replace(' ', '-', $row['name']); ?>"><?php echo $row['name'];?></a></li>
              <?php
            }
            }
              ?>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="<?php echo $config["app_url"];?>our-client">Our Clients</a></li>
          <li><a class="nav-link scrollto" href="<?php echo $config["app_url"];?>contact-us">Contact Us</a></li>
          <li><a class="nav-link scrollto" href="<?php echo $config["app_url"];?>verify-certificate">Verify Cerificate</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- #header -->