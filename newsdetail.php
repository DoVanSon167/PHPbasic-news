<?php
	session_start();
	ob_start();
	include 'data.php';
	$dt = new database;
		if (isset($_GET['macm']) && isset($_GET['idnd']) && $dt->CheckNull($_GET['macm']) && $dt->CheckNumber($_GET['macm']) && $dt->CheckNull($_GET['idnd']) && $dt->CheckNumber($_GET['idnd'])) {
		$idnd = $_GET['idnd'];
		$idnd = addslashes($idnd);
		$macm = $_GET['macm'];
		$macm = addslashes($macm);
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chi tiết bản tin</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		.rating {
		  unicode-bidi: bidi-override;
		  direction: rtl;
		  text-align: center;
		}
		.rating > span {
		  display: inline-block;
		  position: relative;
		  width: 1.1em;
		}
		.rating > span:hover,
		.rating > span:hover ~ span {
		  color: transparent;
		}
		.rating > span:hover:before,
		.rating > span:hover ~ span:before {
		   content: "\2605";
		   position: absolute;
		   left: 0;
		   color: gold;
		}
	</style>
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
	<div class="content">
			<?php
			if (isset($_SESSION['TenDangNhap'])) {
				$tendangnhap = $_SESSION['TenDangNhap'];
				$dt->select("SELECT Quyen FROM phanquyen WHERE TenDangNhap = '$tendangnhap'");
				$r = $dt->fetch();
				$quyen = $r['Quyen'];
				if ($quyen =='ad') {
					echo "<p align='right'>";
					echo "<a href='newsadd.php?macm=$macm'><font color = 'blue'>Thêm bản tin mới</font></a>";
					echo " | <a href='newsupdate.php?macm=$macm&idnd=$idnd'><font color = 'blue'>Sửa bản tin này</font></a>";
					echo "</p>";
				}elseif ($quyen =='tbt') {
					echo "<p align='right'>";
					echo "<a href='newsadd.php?macm=$macm'><font color = 'blue'>Thêm bản tin mới</font></a>";
					echo " | <a href='newsupdate.php?macm=$macm&idnd=$idnd'><font color = 'blue'>Sửa bản tin này</font></a>";
					echo " | <a href='newsdelete.php?macm=$macm&idnd=$idnd'><font color = 'blue'>Xóa bản tin này</font></a>";
					echo "</p>";
				}
			}
			$dt->select("SELECT * FROM noidungbv WHERE idND = '$idnd'");
			$r = $dt->fetch();
			echo "<h1>";
			echo $r['TieuDe'];
			echo "</h1><br>";
			echo "<p id='p1'>";
			echo "<strong>";
			echo $r['TomTat'];
			echo "</strong>";
			echo "</p>";
			$hinh = $r['HinhAnh'];
			if ($r['HinhAnh'] != null)
				echo "<img src = '$hinh' width='650' height='421'><br>";
			echo "<p align=justify>";
			echo $r['NoiDung'];
			echo "</p>";
			echo "<h4>Xem thêm: </h4><br>";
			$dt->select("SELECT * FROM baiviet bv INNER JOIN noidungbv nd ON bv.idBV = nd.idBV WHERE idnd != '$idnd' AND maCM = '$macm' LIMIT 5");
			while ($row=$dt->fetch()) {
				echo "<img src = 'icon.jpg'>";
				$idtin = $row['idND'];
				$tieude = $row['TieuDe'];
				echo "<a href = 'newsdetail.php?macm=$macm&idnd=$idtin'>$tieude</a><br><br>";
			}
		?>
		<ul><li></li></ul>
		<?php
			if (isset($_SESSION['TenDangNhap'])) {
				$dt->select("SELECT * FROM noidungbv WHERE idND = '$idnd'");
				$rn = $dt->fetch();
				$idbaiviet = $rn['idBV'];
				$dt->select("SELECT * FROM binhluan WHERE idBV = '$idbaiviet'");
				echo "<form method='post'>";
				echo "<table width='50%'' align='left'>";
				echo "<tr>";
				echo "<td>Đánh giá: </td>";
					echo "<td><div class='rating'><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>Bình luận: </td>";
					echo "<td><textarea name='bl' cols='80' rows='7' placeholder='Thêm bình luận...'></textarea></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td colspan='2' align='right'>";
						echo "<input type='submit' name='bluan' value='Đăng'>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "<ul><li></li></ul>";
				while ($r = $dt->fetch()) {
						$ngbl = $r['TenDangNhap'];
						$ndbl = $r['BinhLuan'];
						$tg = $r['ThoiGian'];
						echo "$ngbl<br>";
						echo "$ndbl<br>";
						echo "$tg<br><br><br>";
					}
			}
			if (isset($_POST['bluan'])) {
				if ($dt->CheckNull($_POST['bl'])) {
					$bl = $_POST['bl'];
					$idnd = $_GET['idnd'];
					$tendangnhap = $_SESSION['TenDangNhap'];
					date_default_timezone_set('Asia/Ho_Chi_Minh');
					$date = date("Y-m-d H:i:s");
					$dt->command("INSERT INTO binhluan(TenDangNhap,BinhLuan,ThoiGian,idBV) VALUES ('$tendangnhap','$bl','$date','$idbaiviet')");
					header("location:newsdetail.php?idnd=$idnd&macm=$macm");
				}else{
					echo "khong duoc de trong binh luan!";
				}
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