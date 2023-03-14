<?php
include('database.php'); 

if (isset($_POST["invoice_id"]))
{

   $sql7="select commission_status from tblinvoices where id='$_POST[invoice_id]'";
   $res7=mysqli_query($con,$sql7);
   $fetch7=mysqli_fetch_array($res7);
   $commission_status = $fetch7["commission_status"];
?>   
   <select name="commission_status" id="commission_statuss" class="form-control" data-width="100%">
    <option value="">Select status</option>
    <option value="Paid" <?php if($commission_status=="Paid")echo "selected";?> >Paid</option>
    <option value="Unpaid" <?php if($commission_status=="Unpaid")echo "selected";?> >Unpaid</option>
   </select>
   
<?php 
} 
else
{
    echo "Bad Request";
}


?>