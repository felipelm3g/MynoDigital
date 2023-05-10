<?php

session_start();
$_SESSION['USER'] = array();
session_unset();
session_destroy();

header('Location: ../');
exit();
?>
