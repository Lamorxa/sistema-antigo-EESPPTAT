<?php
if(isset($link))
{
    session_destroy();  
 header("location:inicio.php");
}
?>
