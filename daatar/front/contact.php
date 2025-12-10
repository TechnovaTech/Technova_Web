<!-- include Header -->
<?php 
include('include/header.php');

if(isset($_POST['submit']))
{
    $message = 'Name : '.$_POST['name'].'<br>';
    $message .= 'Email : '.$_POST['email'].'<br>';
    $message .= 'Contact Number : '.$_POST['contact_number'].'<br>';
    $message .= 'Service : '.$_POST['subject'].'<br>';
    $message .= 'Message : '.$_POST['message'].'<br>';
    
    $mail->From = "admin@datarcertification.com";
                                      // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->addAddress('mahesh@datarengineers.com');   
     // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'New Inquiry From Website';
    $mail->Body    = $message;
    $msg=null;

            if(!$mail->send()) 
            { 
            //echo "Mailer Error: " . $mail->ErrorInfo;
            } 
            else 
            { 
            $msg="Inquiry has been sent successfully";        
            //echo "Message has been sent successfully"; 
            }
}
?>
<section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Contact Us</h2>
          <ol>
            <li><a href="<?php echo $config["app_url"];?>">Home</a></li>
            <li>Contact us</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

  <!-- ======= Contact Section ======= -->
    <section id="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h3>Contact Us</h3>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <!--<div class="map mb-4 mb-lg-0">
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 340px;" allowfullscreen></iframe>
            </div>-->
            <div class="col-lg-12">
                <?php 
                $data = get_contactus_details();
                while($row = mysqli_fetch_assoc($data)){
                    echo $row['content'];
                    echo $row['contact'];

                    ?>
                <?php
                }
                ?>    
            </div>
          </div>

          <div class="col-lg-6">
           

            <div class="form">
              <form action="<?php echo $config["app_url"];?>contact-us" method="post">
                <div class="row">
                  <div class="form-group ">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                  </div>
                  <div class="form-group mt-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" required>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                  <?php if(isset($msg)){?>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                  <?php  } ?>
                </div>
                <div class="text-center"><button type="submit" title="Send Message" name="submit" value="submit" style="background: #007bff;
    border: 0;
    border-radius: 20px;
    padding: 8px 30px;
    color: #fff;
    transition: 0.3s;">Send Message</button></div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

 
<!-- include Footer-->
<?php 
include('include/footer.php');
?>
