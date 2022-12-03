<?php 

  define("DB_HOST", "feedback-app.cijtcrrg0pnv.us-west-2.rds.amazonaws.com");
  define("DB_USER", "admin");
  define("DB_PASS", "passw0rd");
  define("DB_NAME", "sys");
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($conn->error)
{
  die("Connection failed: ({$conn->error})");
  
}
?>