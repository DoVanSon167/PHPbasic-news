<?php
	session_start();
	include 'data.php';
	$dt = new database;
	if (isset($_GET['macm'])) {
		$macm = $_GET['macm'];
		$dt->command("DELETE FROM chuyenmuc WHERE MaCM = '$macm'");
		header('location:groupadd.php');
	}
?>