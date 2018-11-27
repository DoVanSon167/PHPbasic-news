<?php
	session_start();
	unset($_SESSION['TenDangNhap']);
	header('location:index.php')
?>