<?php
// Start the session
session_start();
include 'functions.php';
include 'config.php';
?>
<!DOCTYPE html>
<html lang="lv">
<head>
<title>MĀJASLAPA</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1 id="maintitle">MĀJASLAPA</h1>

<?php 
if (ielogojies())  {
	
$segvards = segvards();
echo "<div id='userinfo'>";
echo "Sveicināti, $segvards!<br>";
echo "<a href='index.php?profile=true'>Mans profils</a>";
echo "</div>";
}
?>


<div id="mainmenu">
<ul>
	<?php //izdrukājam sadaļu nosaukumus no datubāzes
$sql = "SELECT id, title FROM pages";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	echo '<li><a ';
	if (isset($_GET["id"]) && $_GET["id"] == $row["id"]) {
		echo 'class="active" ';
	}
	echo 'href="index.php?id='.$row["id"].'">'.$row["title"].'</a></li>';
  }
} 
?>
	  
	<?php if (ielogojies()) { ?>
	<li style="float:right"><a href="admin/index.php">Administrācijas panelis</a></li>
	<li style="float:right"><a href="logout.php">Atteikties</a></li>
	<?php } else { ?>
	<li style="float:right"><a href="login.php">Pieteikties</a></li>
	<?php } ?>

</ul>
</div>

<?php //izdrukājam sadaļu saturu
if (isset($_GET["id"])) {

	$sql = "SELECT id, title, content FROM pages WHERE id='".$_GET["id"]."'";
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc(); 	
		//echo '<h2>'.$row["title"].'</h2>';
		if ($row["title"] == "Jaunumi") {
		//ja sadaļas nosaukums ir jaunumi, tad drukājam ziņas
			include 'posts.php';
		} else {
			echo $row["content"];
		}
		
	}
} elseif (isset($_GET["profile"])) {
	include 'profile.php';
}
?>
</body>
</html>