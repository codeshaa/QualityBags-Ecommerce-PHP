<?php
require_once('business_layer\users\usersController.php');
?>

<!-- Navigation bar-->
    <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <!--Collapse button-->
    <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" runat="server" href="index.php?content_page=Home"><img class="img-responsive" src="images/qblogo.png" width="250" height="60"/></a>
    </div>
    <!--links-->
    <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
    <li><a runat="server" href="index.php?content_page=Home">Home</a></li>
    <li><a runat="server" href="index.php?content_page=Bags">Bags</a></li>
    <li><a runat="server" href="index.php?content_page=Categories">Categories</a></li>
    <li><a runat="server" href="index.php?content_page=Suppliers">Suppliers</a></li>
    <li><a runat="server" href="index.php?content_page=About">About Us</a></li>
    <li><a runat="server" href="index.php?content_page=Contact">Contact Us</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        if(!isset($_SESSION['username'])){
          echo '<li style="cursor:pointer"><a runat="server" data-toggle="modal" data-target="#loginModal" ><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
          echo '<li style="cursor:pointer"><a runat="server" data-toggle="modal" data-target="#registerModal" ><span class="glyphicon glyphicon-user"></span> Register</a></li>';
        }
        else {
          echo '<li style="cursor:pointer"><a runat="server" href="index.php?content_page=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
        }
      ?>
    </ul>
    </div>
    </div>
    </div>



<div id="header">
<div id="logo" onClick="location.href='index.php?content_page=Introduction'">
</div>
</div>

<!-- The body area -->
<div id="left" class="col-md-2"><?php include('Menu.php');?></div>
<div id="right" class="col-md-10"><?php include($page_content);?>
  <?php
  require_once('business_layer/shopping.inc.php');
  ?>

  <div id="shoppingcart">
  <?php
    if (isset($_SESSION['username'])){
      if($_SESSION['username'] != 'Admin'){
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</div>';
            echo '<div class="panel-body">';
                echo Shopping::writeShoppingCart();
            echo '</div></div>';
          }
      }
      else {
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</div>';
            echo '<div class="panel-body">';
                echo Shopping::writeShoppingCart();
            echo '</div></div>';
      }
  ?>
  </div>

</div>

 <!-- Footer -->
 <div style="position: fixed; bottom: 0px; left:0px;">
     <!-- Call javascript function -->
 <script type="text/javascript">
     current_time();
 </script>
 </div>
 <div style="position: fixed; bottom: 0px; right:0px;">
 &copy;2017 Quality Bags Ltd.
 </div>

 <!--Login Modal -->
  <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" align="center">Login</h4>
        </div>
        <div class="modal-body">
          <div class="container">
            <?php
            echo Users::displayLoginForm();
            ?>
        </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Login</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--Register Modal -->
   <div class="modal fade" id="registerModal" role="dialog">
     <div class="modal-dialog modal-md">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title" align="center">Register</h4>
         </div>
         <div class="modal-body">
           <div class="container">
             <?php
             echo Users::displayRegisterForm();
             ?>
         </div>
         </div>
         <div class="modal-footer">
           <button type="submit" class="btn btn-success">Register</button>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
           </form>
         </div>
       </div>
     </div>
   </div>
