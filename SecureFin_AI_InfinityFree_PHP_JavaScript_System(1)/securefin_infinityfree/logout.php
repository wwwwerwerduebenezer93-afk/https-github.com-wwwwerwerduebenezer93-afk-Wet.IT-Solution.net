<?php require 'includes/bootstrap.php';if($u=me())audit('logout',(int)$u['id']);session_unset();session_destroy();go('index.php');
