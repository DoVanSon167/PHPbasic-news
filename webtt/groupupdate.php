<?php
	session_start();
	include 'data.php';
	$dt = new database;
		if (isset($_GET['macm']) && $dt->CheckNull($_GET['macm']) && $dt->CheckNumber($_GET['macm'])) {
		$macm = $_GET['macm'];
		$macm = addslashes($macm);
		$dt->select("SELECT TenCM FROM chuyenmuc WHERE MaCM = '$macm'");
		$r = $dt->fetch();
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bản tin mới</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="top">
	<img src="logo.jpg">
	<?php
	if (!isset($_SESSION['TenDangNhap'])) {
		echo "<a href ='login.php'><img src = 'login.jpg'></a>";
	}else{
		echo "<a href ='logout.php'><img src = 'logout.png'></a>";
	}
?>
</div>
<div id="menu">
	<ul>
		<li class="home"><a href="index.php"><img src="home.png">Trang chủ</a></li>
		<li class="cn"><a href="#"><img src="Technology.png">Công nghệ</a></li>
		<li class="ds"><a href="#"><img src="human.png">Đời sống</a></li>
		<li class="kh"><a href="#"><img src="science1.png">Khám phá khoa học</a></li>
		<li class="sk"><a href="#"><img src="heart.png">Y học - Sức khoẻ</a></li>
	</ul>
</div>
<div id="wrapper">
	<div class="content">
	<h1>Sửa chuyên mục: <?php echo $r['TenCM'] ?></h1>
		<ul><li>
		<form method="post">
			Tên chuyên mục: <input type="text" name="tenchuyenmuc" size="40" value="<?php echo $r['TenCM']; ?>" />
			<input type="submit" name="update" value="Sửa">
		</form>		
		</li></ul>
		<?php
			if (isset($_POST['update'])) {
				$tencm = $_POST['tenchuyenmuc'];
				$dt->command("UPDATE chuyenmuc SET TenCM = '$tencm' WHERE MaCM = '$macm'");
				header('location:groupadd.php');
			}
		?>
	</div>
	<?php 
		}else {
			header('location:index.php');
		}
	?>
	<div class="leftbar">
		<ul>
			<?php
				$dt->select('SELECT * FROM chuyenmuc ORDER BY MaCM ASC');
				while ($r = $dt->fetch()) {
					$macm = $r['MaCM'];
					$tencm = $r['TenCM'];
					echo "<li><a href = 'news.php?macm=$macm'><img src='ic.png'>$tencm</a></li>";
				}
			?>
		</ul>
	</div>
	<div class="sidebar">
		<div class="list-title">Tiêu điểm</div>
		<ul>
		<?php
			$dt->select("SELECT * FROM baiviet bv INNER JOIN noidungbv nd ON bv.idBV = nd.idBV LIMIT 8");
			while ($r = $dt->fetch()) {
				$idnd = $r['idND'];
				$tieude = $r['TieuDe'];
				$hinh = $r['HinhAnh'];
				$macm = $r['maCM'];
				echo "<li>";
				echo "<a href='newsdetail.php?idnd=$idnd&macm=$macm'><img src='$hinh'>$tieude</a>";
				echo "</li>";
				# code...
			}
		?>
		</ul>
	</div>
</div>
<div style="clear: left;"></div>
<div id="bottom">Copyright © 2017 UTE 141103</div>
</body>
</html>