<?php
$sitename="Bakery Distribution System";
$conn=mysqli_connect("localhost", "root", "", "bakerydistributiondb");
if(!$conn){
    die(mysqli_error($conn)."Error connecting Database!");
}
?>
     