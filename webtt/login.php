<?php
	session_start();
	ob_start();
	include 'data.php';
	$dt = new database;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Đăng nhập</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="top">
	<img src="logo.jpg">
<?php
	if (!isset($_SESSION['TenDangNhap'])) {
		echo "<a href ='login.php'><img src = 'login.jpg'></a>";
		# code...
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
	<div class="content">
	<form method="post">
		<table width="50%" align="center">
			<tr>
				<td>Tên đăng nhập: </td>
				<td><input type="text" name="user" size="25"></td>
			</tr>
			<tr>
				<td>Mật khẩu: </td>
				<td><input type="password" name="pass" size="25"></td>
			</tr>
			<tr>
				<td align="right"><a href="dangky.php">Đăng ký</a></td>
				<td colspan="2" align="right">
					<input type="submit" name="login" value="Đăng nhập">
				</td>
			</tr>
		</table>
	</form>
	<?php
		if (isset($_POST['login'])) {
			if ($dt->CheckNull($_POST['user']) && $dt->CheckNull($_POST['pass'])) {
				$user = addslashes($_POST['user']);
				$pass = addslashes($_POST['pass']);
				$pass = md5($pass);
				$dt->select("SELECT * FROM thanhvien WHERE TenDangNhap = '$user' AND MatKhau = '$pass'");
				if ($dt->fetch()) {
					$_SESSION['TenDangNhap'] = $user;
					header('location:index.php');
				}else{
					echo "<br>Đăng nhập thất bại!";
				}
			}else {
				echo "Không được để trống tên đăng nhập hoặc mật khẩu!";
			}

		}
	?>
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