<?php
// Include MySQL class
require_once('/business_layer/suppliersController.php');
?>

<div class="container">

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = test_input($_POST["supplierName"]);
    $email = test_input($_POST["email"]);
    $address = test_input($_POST["address"]);
    $mobile = test_input($_POST["mobilePhone"]);
    $workPhone = test_input($_POST["workPhone"]);
    $homePhone = test_input($_POST["homePhone"]);
    $data_exist = 0;

    $sql = 'SELECT supplier_name FROM suppliers ORDER BY supplier_id';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
      if ($name == $row['supplier_name']){
        $data_exist = 1;
      }
    }
      if ($data_exist){
        echo '<h4>Supplier already exists. Please try again.</h4>';
      }
      else{
        $sql = "INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work, supplier_phone_home) VALUES ('$name', '$email', '$address', '$mobile', '$workPhone', '$homePhone')";
        $result = $db->query($sql);
        if($result){
          echo '<h4>A new supplier has been added.</h4>';
        }
        else {
          echo '<h4>Database: Failed to create new supplier</h4>';
        }
      }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

<!-- Trigger the modal with a button -->
<?php
if (isset($_SESSION['username'])){
  if($_SESSION['username'] == 'Admin'){
  echo '<div style="padding:10px">';
  echo '<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#supplierModal">Create a supplier</button>';
  echo '</div>';
  }
}
?>

<!-- Modal -->
 <div class="modal fade" id="supplierModal" role="dialog">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Create a new supplier</h4>
       </div>
       <div class="modal-body">
         <?php echo Supplier::displayCreateSupplierForm(); ?>
       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-success">Create</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
       </div>
     </div>
   </div>
 </div>
 </div>

<?php

echo Supplier::displaySuppliers();
?>
