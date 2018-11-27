<?php
	session_start();
	include 'data.php';
	$dt = new database;
	
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
	<ul>
	<li>
		<h1>Xử lý chuyên mục</h1>
		<table width="80%" align="center">
			<tr align="center">
				<th>STT</th><th>Mã chuyên mục</th><th>Tên chuyên mục</th><th>Xử lý</th>
			</tr>
		<?php
			$dt->select("SELECT * FROM chuyenmuc");
			$i = 0;
			while ($r = $dt->fetch()) {
				$i++;
				$macm = $r['MaCM'];
				$tencm = $r['TenCM'];
				echo "<tr align='center'>";
				echo "<td>$i</td><td>$macm</td><td>$tencm</td>";
				echo "<td>";
				echo "<a href = 'groupupdate.php?macm=$macm'><font color = 'blue'>Sửa</font></a>";
				echo " | <a href = 'groupdelete.php?macm=$macm'><font color = 'red'>Xóa</font></a>";
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
		</li>
		<li>
		<h1><font color = '#cc0000'>Thêm chuyên mục</font></h1>
			<form method="post">
				<table width="80%" align="center">
					<tr>
						<td>Tên chuyên mục: </td>
						<td><input type="text" name="name" size="25"></td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input type="submit" name="add" value="Thêm">
						</td>
					</tr>
				</table>
			</form>
		</li>
		</ul>
		<?php
			if (isset($_POST['add'])) {
				$tencm = $_POST['name'];
				$dt->command("INSERT INTO chuyenmuc(TenCM) VALUE ('$tencm')");
				header('location:groupadd.php');
			}
		?>
	</div>

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