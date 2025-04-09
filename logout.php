<!--logout.php-->
<?php
require_once('connect.php');
session_start();

session_unset();
session_destroy();

header('Location: loginForm.php');
exit();
?>