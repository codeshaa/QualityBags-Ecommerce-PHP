<?php

// Include functions
require_once('business_layer/shopping.inc.php');

// Process actions for this page
Shopping::processActions();
?>

<div id="shoppingcart">
  <div class="panel panel-success">
      <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Your Shopping Cart</div>
      <div class="panel-body">
        <?php
          echo Shopping::showCart();
        ?></br>
        <h4><a runat="server" href="index.php?content_page=Bags"><span class="glyphicon glyphicon-triangle-left"></span> Back to Shopping</a></h4>
      </div>
  </div>
</div>
