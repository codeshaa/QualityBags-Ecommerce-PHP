
<?php
if(isset($_SESSION['username'])){
  header("Location: index.php?content_page=Home"); /* Redirect browser */
}
require_once('business_layer\users\usersController.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["email"]) && isset($_POST["password"])){

    $lastName = test_input($_POST["lastName"]);
    $middleName = test_input($_POST["middleName"]);
    $firstName = test_input($_POST["firstName"]);
    $email = test_input($_POST["email"]);
    $address = test_input($_POST["address"]);
    $mobilePhone = test_input($_POST["mobilePhone"]);
    $homePhone = test_input($_POST["homePhone"]);
    $password = test_input($_POST["password"]);
    $password = sha256_encrypt($password);
    $username = $email;
    $hash = md5( rand(0,1000) );
    $status = 1;
    $data_exist = 0;

    $sql = 'SELECT username FROM users ORDER BY user_id';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
      if ($username == $row['username']){
        $data_exist = 1;
        break;
      }
    }
      if ($data_exist){
        echo '<h4>Username already exists. Please try again.</h4>';
      }
      else{
        $sql = "INSERT INTO users (last_name, middle_name, first_name, email, address, home_phone, mobile_phone, username, password, hash, status) VALUES ('$lastName', '$middleName', '$firstName', '$email', '$address', $homePhone, $mobilePhone, '$username', '$password', '$hash', '$status')";
        $result = $db->query($sql);
        if($result){
          send_mail($email, $hash);
          echo '<h4>A verification code has been sent to your email. Please verify.</h4>';
        }
        else {
          echo '<h4>Database Error: Your registration is unsuccessful. Please retry.</h4>';
        }
      }
  }
  else {
    trigger_error("Register Error: Email and password not provided", E_USER_ERROR);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// send mail function
function send_mail($email, $hash) {
  $to      = $email; // Send email to our user
  $subject = 'Signup | Verification - QualityBags.com'; // Give the email a subject
  $message = '

  Thanks for Registering on our site!
  Your account has been created. Please verify your email address by clicking the link below.'."\r\n".'


  Please click this link to activate your account:'."\r\n".'
  http://'.$_SERVER["HTTP_HOST"].'/johns08/qualitybagsecommerce/index.php?content_page=verification&email='.$email.'&hash='.$hash.'

  ';

  $headers = 'From:noreply@QualityBags.com' . "\r\n"; // Set from headers
  mail($to, $subject, $message, $headers); // Sending email
}
?>

<div class="panel panel-success">
<div class="panel-heading"><h2 align="center" style="padding:10px;"> Register </h2></div>
  <div class="panel-body">
    <div class="container">
      <?php
      echo Users::displayRegisterForm();
      ?>
      <button type="submit" class="btn btn-success">Register</button>
      <a href="index.php?content_page=login" class="btn btn-default">Login</a>
      </form>
    </div>
  </div>
</div>
</div>
