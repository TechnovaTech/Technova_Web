<?php
$config["app_url"] = "https://chhatariya.in/";

if(isset($_POST['sendmail']))
{
         $to = "cfi_52@yahoo.co.in";
         $subject = $_POST['subject'];
         
         $message .= "<b>Name:</b> '".$_POST['name']."'<br>";
         $message .= "<b>Message</b> '".$_POST['message']."'<br>";
         
         
         $header = "From:'".$_POST['email']."'\r\n";
        
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            ?>
            <script type="text/javascript">
               alert("Message sent successfully...");
               location.href = "<?php echo $config["app_url"];?>contact-us";
            </script>
            
            <?php
         }else {
            ?>
            <script type="text/javascript">
               alert("Message could not be sent...");
               location.href = "<?php echo $config["app_url"];?>contact-us";
            </script>
            
            <?php
            
         }
}
      ?>