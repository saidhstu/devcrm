<?php
include('database.php'); 

if (isset($_POST["invoice_id"]))
{
    $commission_status = $_POST["commission_status"];
    $invoice_id = $_POST["invoice_id"];
  
    $sql12 = "update tblinvoices set commission_status='$commission_status' where id='$invoice_id'";
    $res12 = mysqli_query($con, $sql12);
    if($res12)
    {
       $result["status"]="Success";
    }
    else
    {
       $result["status"]="Failed";   
    }
  echo json_encode($result);
}
else
{
echo "Bad Request";
}

?>