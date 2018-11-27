<?php
	session_start();
	include 'data.php';
	$dt = new database;
	if (isset($_GET['macm'])) {
		$macm = $_GET['macm'];
		$dt->select("SELECT * FROM chuyenmuc WHERE MaCM = '$macm'");
		$rows = $dt->fetch();
	
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bản tin mới</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src = "ckeditor/ckeditor.js"></script>
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
	<h1>Thêm bản tin mới: <?php echo $rows['TenCM'] ?></h1>
	<ul>
	<li>
	<form method="post">
		<h4>Tiêu đề: </h4>
		<input type="text" name="tieude" size="79">
		<h4>Tóm tắt: </h4>
		<textarea name="tomtat" cols="80" rows="7"></textarea>
		<h4>Hình ảnh: </h4>
		<input type="text" name="hinh" size="79" >
		<h4>Nội dung: </h4>
		<textarea name="noidung" id="cknoidung"></textarea>
		<script type="text/javascript">
			CKEDITOR.replace("cknoidung");
		</script><br>
		<input type="submit" name="them" value="Thêm">
	</form>
	</li>
	</ul>
	<?php
		if (isset($_POST['them'])) {
			$tendangnhap = $_SESSION['TenDangNhap'];
			$tieude = $_POST['tieude'];
			$tomtat = $_POST['tomtat'];
			$hinh = $_POST['hinh'];
			$noidung = $_POST['noidung'];

			$dt->command("INSERT INTO baiviet(maCM,TenDangNhap) VALUES ('$macm','$tendangnhap')");
			$dt->select("SELECT idBV FROM baiviet ORDER BY idBV DESC LIMIT 1");
			$r = $dt->fetch();
			$idbv = $r['idBV'];
			$dt->command("INSERT INTO noidungbv(TieuDe,TomTat,NoiDung,HinhAnh,idBV) VALUES ('$tieude','$tomtat','$noidung','$hinh','$idbv')");
			header("location:news.php?macm=$macm");
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