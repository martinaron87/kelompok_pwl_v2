<?php
session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['logout'] = "Anda telah berhasil logout.";
header("Location: form_login.php");
exit();

?>
