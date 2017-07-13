<?php
// Include MySQL class
require_once('/../data_layer/data.inc.php');

class Shopping {

  public static function writeShoppingCart() {
  	if (isset($_SESSION['cart']))
    	{
    	   $cart = $_SESSION['cart'];
    	}

  	if (!isset($cart) || $cart=='') {
  		return '<h4>You have no items in your shopping cart.<a href="index.php?content_page=bags"> Shop now</a></h4>';
  	}
    else {
  		// Parse the cart session variable
  		$items = explode(',',$cart);
  		$s = (count($items) > 1) ? 's':'';
  		return '<h4>You have <a href="index.php?content_page=cart&action=display">'.count($items).' item'.$s.' in your shopping cart</a></h4>';
  	}
  }


  public static function showCart() {
  	global $db;
  	$cart = $_SESSION['cart'];
  	if ($cart) {
  		$items = explode(',',$cart);
  		$contents = array();
  		$total = 0;
  		foreach ($items as $item) {
  			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
  		}
  		$output[] = '<form action="index.php?content_page=cart&action=update" method="post" id="cart">';
  		$output[] = '<table class="table">';
  		foreach ($contents as $id=>$qty) {
  			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
  			$result = $db->query($sql);
  			$row = $result->fetch();
  			extract($row);
  			$output[] = '<tr>';
        $output[] = '<td><img class="img-responsive" src='.$bag_image_link.' width="60" height="auto"></td>';
        $output[] = '<td>'.$bag_name.'</td>';
        $output[] = '<td>'.$bag_description.'</td>';
  			$output[] = '<td>NZ$: '.$bag_price.'</td>';
        $output[] = '<td><input type="number" name="qty'.$id.'" value="'.$qty.'" size="3" maxlength="3" /></td>';
  			$output[] = '<td>NZ$: '.($bag_price * $qty).'</td>';
  			$output[] = '<td><a href="index.php?content_page=cart&action=delete&id='.$id.'" class="r">Remove</a></td>';

  			$total += $bag_price * $qty;
        $gst = ($total/100) * 15;
        $total = number_format($total, 2);
        $gst = number_format($gst, 2);

  			$output[] = '</tr>';
  		}
  		$output[] = '</table>';
  		$output[] = '<h4>Grand total: <strong>NZ$: '.$total.'</strong></h4>';
      $output[] = '<h4>GST Included: <strong>NZ$: '.$gst.'</strong></h4>';
      $output[] = '<div class="row">';
  		$output[] = '<div class="col-sm-4"><button type="submit" class="btn btn-info">Update cart</button></div>';
      $output[] = '<div class="col-sm-4"></div>';
      $output[] = '<div class="col-sm-4"><a href="index.php?content_page=cart&action=clearall" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Clear Cart</a></div>';
      $output[] = '</div>';
  		$output[] = '</form></br></br>';
      $output[] = '<h4><a runat="server" href="index.php?content_page=purchased" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-triangle-right"></span> Place Order</a></h4>';
  	}
    else {
  		$output[] = '<h4>Your shopping cart is empty.</h4>';
  	}
  	return join('',$output);
  }


  public static function processActions() {
  	if (isset($_SESSION['cart']))
  	{
      $cart = $_SESSION['cart'];
  	}

  	if (isset($_GET['action']))
  	{
  		$action = $_GET['action'];
  	}

      switch ($action) {
      	case 'add':
          		if (isset($cart) && $cart!='') {
          			$cart .= ','.$_GET['id'];
          		} else {
          			$cart = $_GET['id'];
          		}
      		break;
        case 'clearall':
              if (!empty($cart)) {
                $cart = NULL;
                $_SESSION['cart'] = NULL;
              }
        	break;
      	case 'delete':
          		if ($cart) {
          			$items = explode(',',$cart);
          			$newcart = '';
          			foreach ($items as $item) {
          				if ($_GET['id'] != $item) {
          					if ($newcart != '') {
          						$newcart .= ','.$item;
          					} else {
          						$newcart = $item;
          					}
          				}
          			}
          			$cart = $newcart;
          		}
      		break;
      	case 'update':
          	if ($cart) {
          		$newcart = '';
          		foreach ($_POST as $key=>$value) {
          			if (stristr($key,'qty')) {
          				$id = str_replace('qty','',$key);
          				$items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
          				$newcart = '';
          				foreach ($items as $item) {
          					if ($id != $item) {
          						if ($newcart != '') {
          							$newcart .= ','.$item;
          						} else {
          							$newcart = $item;
          						}
          					}
          				}
          				for ($i=1;$i<=$value;$i++) {
          					if ($newcart != '') {
          						$newcart .= ','.$id;
          					}
                    else {
          						$newcart = $id;
          					}
          				}
          			}
          		}
        	  }
            $cart = $newcart;
    	  break;
    }
    $_SESSION['cart'] = $cart;
  }

}
?>
