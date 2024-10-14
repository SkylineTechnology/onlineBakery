<?php
include '../includes/connection.php';
if(!empty($_POST["state_id"]))
{
$query =mysqli_query($conn,"SELECT * FROM locals WHERE state_id = '" . $_POST["state_id"] . "'");
?>
<option value="">Select L G A</option>
<?php
while($row=mysqli_fetch_array($query))
{
?>
<option value="<?php echo $row["local_id"]; ?>"><?php echo $row["local_name"]; ?></option>
<?php
}
}
?>
