<p>
  <?php
    if(isset($_SESSION['username'])){
      echo '<div class="greeting" style="padding: 10px; background-color: white;">';
      echo '<h5>Welcome, </h5>';
      echo '<h4>'.$_SESSION['username'].'</h4></div>';
    }
  ?>
  <div style="margin-top: 10px; padding: 5px; background-color: white;">
  <a runat="server" class="list-group-item" href="index.php?content_page=Bags">Shop Bags</a><br/>
  <a runat="server" class="list-group-item" href="index.php?content_page=categories">Categories</a><br/>
  <a runat="server" class="list-group-item" href="index.php?content_page=Suppliers">Suppliers</a><br/>
  <a runat="server" class="list-group-item" href="index.php?content_page=About">About Us</a><br/>
  <a runat="server" class="list-group-item" href="index.php?content_page=Contact">Contact Us</a><br/>

  <?php
    if(!isset($_SESSION['username'])){
      echo '<a runat="server" class="btn btn-default" href="index.php?content_page=login"><span class="glyphicon glyphicon-log-in"></span> Login</a> | ';
      echo '<a runat="server" class="btn btn-success" href="index.php?content_page=register"><span class="glyphicon glyphicon-user"></span> Register</a><br/>';
    }
    else {

        if($_SESSION['username'] == 'Admin'){
          echo '<a runat="server" class="list-group-item" href="index.php?content_page=orders">Orders</a><br/>';
          echo '<a runat="server" class="list-group-item" href="index.php?content_page=users">Users</a><br/>';
        }
        else {
          echo '<a runat="server" class="list-group-item" href="index.php?content_page=myOrders">My Orders</a><br/>';
        }

      echo '<a runat="server" href="index.php?content_page=logout"  class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
    }
  ?>
  </div>
</p>
