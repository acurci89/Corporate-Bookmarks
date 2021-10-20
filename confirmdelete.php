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
	
	$del_value = $_GET['delcode'];
	$del_name = $_GET['delname'];

	//Persoal
	If (!(empty($_GET['personal']))) :
		$personalcheck = $_GET['personal'];
		if($personalcheck == true) :
			$linkfile = $personalpath."".$aduser1.".json";
		endif;
	else:
		$personalcheck = "";
	endif;

	//Group
	If (!(empty($_GET['group']))) :
		$groupselection = $_GET['group'];
		$linkfile = $GroupPath."".$groupselection.".json";
	else:
		$groupselection = "";
	endif;

	if (!($personalcheck == true)) :
		if (!((in_array($aduser, $Admin)) or ($UseUserAD == false))) :
			header( "Location: unauthorized.php" );
		endif;
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
	<script src="script/jquery.min.js"></script>
	<script src="script/bootstrap.min.js"></script>
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
				<a <?php if($personalcheck == true) : echo "class='active'"; endif; ?> href="personal.php"><img src="img/user.png" height="12" border=0></i> Personal</a>
			<?php endif; ?>
		</div>
				
		<div class="right-container-user">
			<a><?php echo $aduser1 ?></a>
		</div>

	</div>
	
	<p>&nbsp;</p>

	<div class="main">
		<div class="center">
			<center>
			<p>&nbsp</p>
			<div class="containerask">
				<h1>Delete Record</h1>
      			<p>Are you sure you want to delete the record: <strong> <?php echo strtoupper($del_name) ?></strong> ?</p>
				<p>ID Record: <strong> <?php echo $del_value ?></strong></p>
				
				<p>&nbsp;</p>
				<div class="clearfix">
					<button type="button" onclick="window.location.href='index.php'" class="cancelbtn">Cancel</button>
					<?php
						if($personalcheck) :
							echo "<button type=\"button\" onclick=\"window.location.href='delete.php?personal=true&delcode=".$del_value."'\" class=\"deletebtn\">Delete</button>";
						endif;
						if($groupselection) :
							echo "<button type=\"button\" onclick=\"window.location.href='delete.php?group=".$groupselection."&delcode=".$del_value."'\" class=\"deletebtn\">Delete</button>";
						endif; 
						if((!($groupselection)) and (!($personalcheck))) :
							echo "<button type=\"button\" onclick=\"window.location.href='delete.php?delcode=".$del_value."'\" class=\"deletebtn\">Delete</button>";
						endif; 
						
					?>
					


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