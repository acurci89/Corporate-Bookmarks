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

	if (!((in_array($aduser, $Admin)) or ($UseUserAD == false))) :
		header( "Location: unauthorized.php" );
	endif;

	$edit_value = $_GET['editcode'];
	$edit_name = $_GET['editname'];
	$edit_description = $_GET['editDescription'];
	$edit_link = $_GET['editlink'];
	$edit_favicon = $_GET['editfavicon'];

	//Group
	If (!(empty($_GET['group']))) :
		$groupselection = $_GET['group'];
		$linkfile = $GroupPath."".$groupselection.".json";
	else:
		$groupselection = "";
	endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>ICT Bookmarks <?php echo $groupselection;?></title>
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
	
	<?php
		$message = "";
		$error = '';
		$name = '';

		function clean_text($string) {
			$string = trim($string);
			$string = stripslashes($string);
			$string = htmlspecialchars($string);
			return $string;
		}

		if(isset($_POST["submit"])){
			$GroupName = clean_text($_POST["name"]);
			//$edit_favicon
			$edit_favicon = str_replace($IconImagePath, "", $edit_favicon);
			$edit_favicon = str_replace("..\\", "", $edit_favicon);
			$edit_favicon = str_replace("..", "", $edit_favicon);

			$editlinglocation = "newlink.php?editname=".$edit_name."&editDescription=".$edit_description."&editlink=".$edit_link."&editfavicon=".$edit_favicon."&group=".$GroupName;
			echo "<script>window.location ='".$editlinglocation."'</script>";
			
			//$error = $editlinglocation;
		}
	?>


	<!--Main-->
	<div class="main">
		<div class="center">
		<center>
			
			<div class="containersearch">
				<h3 style="text-align:center;">ICT Bookmarks - Move Link Group</h3>
			</div>
						
				<div class="tableFixHead">
					<form method="post" enctype="multipart/form-data">
											
						<table>
						
							<thead>
								<th width='20%'></th>
								<th style="text-align:right;" width='80%'>Move in group</th>
							</thead>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>Group Name</strong></p>
							</td>
							<td width='80%'>
								<?php
									$files = glob($GroupPath . '/*.json');
									$files = str_replace(".json", "", $files);
									echo "<select name=\"name\">";
									foreach ($files as $file) {
									echo "<option>".pathinfo($file, PATHINFO_BASENAME)."</option>"; }
									echo "</select>";
								?>
							</td>
							</tr>													
							
							<tr>
							<td colspan = "2" width='100%'>
								<p style="text-align:center;"><strong><?php echo $error; ?>&nbsp</strong></p>
							</td>
							</tr>

							
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							<td width='80%'>
								<p style="text-align:right;"><strong></strong></p>
							</td>
							</tr>
							
							
							
							<tr>
							<td width='20%'>
								<p style="text-align:left;">
									<input onclick="location.href='javascript:history.back()'" type="cancel" name="cancel" class="btn btn-info" value="Cancel" />
								</p>
							</td>
							<td width='80%'>
								<p style="text-align:right;">
									<input type="submit" value="Move" name="submit" onclick="return confirm('Are you sure you want to move link in the group?')">
								</p>
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

