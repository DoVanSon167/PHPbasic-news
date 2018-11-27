<?php
	session_start();
	include 'data.php';
	$dt = new database;
	if (isset($_GET['macm']) && isset($_GET['idnd'])) {
		$idnd = $_GET['idnd'];
		$macm = $_GET['macm'];
		$dt->select("SELECT idBV FROM noidungbv WHERE idND = '$idnd'");
		$r = $dt->fetch();
		$idbv = $r['idBV'];
		$dt->command("DELETE FROM noidungbv WHERE idND = '$idnd'");
		$dt->command("DELETE FROM baiviet WHERE idBV = '$idbv'");
		header('location:index.php');
	}
?>