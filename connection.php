<?php

$conn = mysqli_connect("localhost","root","","users");
if(!$conn){
    die("Error".mysqli_connect_error());
}else{
    echo "connected";
}
?>