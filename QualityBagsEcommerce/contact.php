<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if(isset($_POST["email"])){
     if(isset($_POST["name"])){
       if(isset($_POST["comments"])){

         $to      = $_POST["email"]; // Send email to our user
         $subject = 'Message from visitor '.$_POST["email"]; // Give the email a subject
         $message = ' Name: '.$_POST["name"].'Email: '.$_POST["email"].'Comments: '.$_POST["comments"].'';

         $headers = 'From:noreply@QualityBags.com' . "\r\n"; // Set from headers
         mail($to, $subject, $message, $headers); // Sending email

         echo '<h4> Thank you for your message </h4>';
         echo '<h6> We will get back to you soon. </h6>';

       }
     }
   }
}
?>


<div class="container-fluid bg-grey">
  <h2 class="text-center">Contact Us</h2>
  <div class="row">
    <div class="col-sm-5">
      <h4>Meet Us @</h4></br>
      <h6><span class="glyphicon glyphicon-map-marker"></span> Mt Albert, Auckland, New Zealand</h6>
      <h6><span class="glyphicon glyphicon-phone"></span> +22 01010101</h6>
      <h6><span class="glyphicon glyphicon-envelope"></span> admin@qualitybags.com</h6>
    </div>

    <div class="col-sm-7">
      <form action="index.php?content_page=contact" method="POST" role="form">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit"><span class="glyphicon glyphicon-envelope"></span> Send</button>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>
