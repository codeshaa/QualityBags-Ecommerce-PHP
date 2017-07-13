<?php
ob_start(); //set buffer on
session_start(); //set session on
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Quality Bags</title>

<link href="Bootstrap/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="stylesheets\home.css" rel="stylesheet" type="text/css" />
<script src="Bootstrap\jquery-1.10.2.js"></script>
<script src="Bootstrap/bootstrap.js"></script>
<script src="Bootstrap\modernizr-2.6.2.js"></script>
<script src="Bootstrap\respond.js"></script>


      -->
       <script type="text/javascript">
    		function current_time()
      		{
      			var currentTime = new Date()
      			var month = currentTime.getMonth() + 1
      			var day = currentTime.getDate()
      			var year = currentTime.getFullYear()
      			document.write( day+ "/" + month + "/" + year)
      		}
    </script>
</head>

<body>

<?php
//Retrieve the requested content page name and construct the file name
if (isset($_GET['content_page']))
{
   $page_name = $_GET['content_page'];
   $page_content = $page_name.'.php';
}
elseif (isset($_POST['content_page']))
{
   $page_name = $_POST['content_page'];
   $page_content = $page_name.'.php';
}
else
{$page_content = 'Home.php';}

//This must be below the setting of $page_content
include('QBMaster.php');
?>

</body>
</html>
