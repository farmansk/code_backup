<?php

include "config.php";

$id = base64_encode(mysqli_real_escape_string($link, $_POST['id']));
    
$query = mysqli_query($link, "Select UserEmail from users Where UserEmail = '".$id."' " );
$count = mysqli_num_rows($query);

if ( $count > 0 ) {
  
 echo "fail" ;
 
}
else{
  
 echo "succ" ;
  
}    


?>