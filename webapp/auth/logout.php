<?php
   ob_start();
   session_start();
   session_unset();
   session_destroy();
   session_write_close();
   setcookie(session_name(),'',0,'/', null, null, true);
   session_regenerate_id(true);
   header("Location: ../index.html");
?>