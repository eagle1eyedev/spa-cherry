<?php
if(!isset($_SESSION)) {
	session_start();
}
if(isset($_SESSION) && isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == true && $_SESSION['ur'] < 2) {
	echo '<meta http-equiv="refresh" content="0; url=../usercp.php" />';
}
else if(isset($_SESSION) && isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == true && $_SESSION['ur'] > 1) {

	echo '<meta http-equiv="refresh" content="0; url=../admin.php" />';
}
else {
	echo '<a href="../index.php">Влезте в системата</a>';
	echo '<a href="../register.php">Регистрирай се</a>';
}
?>

