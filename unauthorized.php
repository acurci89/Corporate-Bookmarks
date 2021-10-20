<?php
	require('config.php');
	if($UseUserAD == true) :
		$aduser = strtoupper($_SERVER['AUTH_USER']);
		$aduser1 = (preg_replace("/^.+\\\\/", "", $_SERVER["AUTH_USER"]));
		if (empty($Admin)){
			$Admin = array ($aduser);
		};
	else:
		$aduser = "Guest";
		$aduser1 = "Guest";
	endif;

	//Persoal
	If (!(empty($_GET['personal']))) :
		$personalcheck = $_GET['personal'];
		if($personalcheck == true) :
			$linkfile = $personalpath."".$aduser1.".json";
		endif;
	else:
		$personalcheck = "";
	endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>ICT Bookmarks</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/group.css">
	<link rel="shortcut icon" href="img/favicon.ico" />	
	<script src="script/menugroup.js"></script>
</head>
<body>
	<!--Group Menu-->
	<?php
		
			echo '<div id="mySidenav" class="sidenav">';
			echo '<h2>Link Groups</h2>';
			echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>';
			$dir = $GroupPath;
			foreach(scandir($dir) as $item){
				if (!($item == '.')) {
					if (!($item == '..')) {
						$item = str_replace(".json", "", $item);
						echo '<a href="index.php?group='.$item.'">'.$item.'</a>';
						 
			}}}
			echo '</div>';
	?>
	<!--End Group Menu -->
	<div id="main">

	<!--Menu-->
	<div class="topnav">
		<div class="right-container-menu">
			<!--<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>-->
			<img src="img/menu2.png" width="20" border=0 onclick="openNav()">  
			
		</div>


		<div class="right-container-title">
			<a><strong>ICT Bookmarks - <?php echo $CompanyName ?></strong></a>
		</div>
		
		<a href="index.php"><img src="img/home.png" height="12" border=0> Home</a>
		<?php if ((in_array($aduser, $Admin)) or ($UseUserAD == false)) : ?>
			<a href="newlink.php"><img src="img/plus.png" height="12" border=0> New Link</a>
		<?php endif; ?>
		
		<?php if ((in_array($aduser, $Admin)) or ($UseUserAD == false)) : ?>
			<a href="uploadimage.php"><img src="img/image.png" height="12" border=0></i> Upload Icon</a>
		<?php endif; ?>

		<?php if ((in_array($aduser, $Admin)) or ($UseUserAD == false)) : ?>
			<a href="managegroup.php"><img src="img/group.png" height="12" border=0></i> Manage Group</a>
		<?php endif; ?>

		<div class="right-container">
			<?php if ($UseUserAD == true) : ?>
				<a href="personal.php"><img src="img/user.png" height="12" border=0></i> Personal</a>
			<?php endif; ?>
		</div>
				
		<div class="right-container-user">
			<a><?php echo $aduser1 ?></a>
		</div>

	</div>
	
	

	<!--Main-->
	<div class="main">
		<div class="center">
		<center>
			
			<div class="containersearch">
				<h3 style="text-align:center;">ICT Bookmarks - Unauthorized</h3>
			</div>
						
				<div class="tableFixHead">
					<form method="post" enctype="multipart/form-data">
						
						
						
						<table>
						
							<thead>
								
								<th style="text-align:center;" width='100%'><p style="text-align:center;"></p></th>
							</thead>

							<tr>
							<td width='100%'>
								<p style="text-align:center;"></p>
							</td>
							</tr>

							<tr>
							<td width='100%'>
								<p style="text-align:center;"><img src="img/unauthorized.png" width="128" border=0></p>
							</td>
							</tr>

							<tr>
							<td width='100%'>
								<p style="text-align:center;"></p>
							</td>
							</tr>

							<tr>
							<td width='100%'>
								<p style="text-align:center;"></p>
							</td>
							</tr>

							<tr>
							<td width='100%' style="text-align:center;">
								<p style="text-align:center;"><h1><strong>Unauthorized</strong></h1></p>
							</td>
							</tr>
							
							
							
						</table>	
						</form>
						

					</div>
				</div>
			</center>
		</div>
	</div>
	<div id="footer">
		<img src="img/ftppittogramma.png" width="20" border=0>  Powered by F.T.P. S.r.l.
	</div>
	</div>
</body>

</html>


