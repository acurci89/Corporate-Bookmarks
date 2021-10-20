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
	
	If (!(empty($_GET['editcode']))) :
		$edit_value = $_GET['editcode'];
	else:
		$edit_value = "";
	endif;

	If (!(empty($_GET['editname']))) :
		$edit_name = $_GET['editname'];
	else:
		$edit_name = "";
	endif;
	If (!(empty($_GET['editDescription']))) :
		$edit_description = $_GET['editDescription'];
	else:
		$edit_description = "";
	endif;
	If (!(empty($_GET['editlink']))) :
		$edit_link = $_GET['editlink'];
	else:
		$edit_link = "";
	endif;
	If (!(empty($_GET['editfavicon']))) :
		$edit_favicon = $_GET['editfavicon'];
	else:
		$edit_favicon = "";
	endif;

	//Group
	If (!(empty($_GET['group']))) :
		$groupselection = $_GET['group'];
		$linkfile = $GroupPath."".$groupselection.".json";
	else:
		$groupselection = "";
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

	if (!($personalcheck == true)) :
		if (!((in_array($aduser, $Admin)) or ($UseUserAD == false))) :
			header( "Location: unauthorized.php" );
		endif;
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
			<a class="active" href="newlink.php"><img src="img/plus.png" height="12" border=0> New Link</a>
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
	
	<?php

		$error = '';
		$name = '';
		$link = '';
		$favicon = '';
		$description = '';
		
		$data = file_get_contents($linkfile);
		$json_arr = json_decode($data);
			
			$Codes = array();
			if (!(empty($json_arr))) :
				foreach ($json_arr as $vcode) {
					$Codes[] = $vcode->{'Code'} ;
				}
			endif;
			
		$i = 0;	
		If ($Codes) {
			$i = (max($Codes)) + 1;
		}
		
		function clean_text($string) {
			$string = trim($string);
			$string = stripslashes($string);
			$string = htmlspecialchars($string);
			return $string;
		}

		
		if(isset($_POST["submit"])){
			$data = file_get_contents($linkfile);

			// decode json
			$json_arr = json_decode($data, true);
			
			$Iconlink = clean_text($_POST['favicon']);
			if (!(empty($Iconlink))){
				$newIconlink = str_replace($IconImagePath, "", $Iconlink);
				$Iconlink = "..\\".$IconImagePath . $newIconlink;
			}
			
			
			// add data
			$json_arr[] = array('Code'=>$i,'Name'=>clean_text($_POST["name"]), 'Description'=>clean_text($_POST["description"]), 'link'=>clean_text($_POST["link"]), 'favicon'=>$Iconlink);

			// encode json and save to file
			file_put_contents($linkfile, json_encode($json_arr));

			if($error == ''){
				if($personalcheck) :
					echo "<script>window.location = 'personal.php'</script>";
				endif;
				if($groupselection) :
					echo "<script>window.location = 'index.php?group=".$groupselection."'</script>";
				endif; 
				if((!($groupselection)) and (!($personalcheck))) :
					echo "<script>window.location = 'index.php'</script>";
				endif;
			}
		}
	?>


	<!--Main-->
	<div class="main">
		<div class="center">
		<center>
			
			<div class="containersearch">
				<h3 style="text-align:center;">ICT Bookmarks - ADD Link</h3>
			</div>
			
			
			
			
				<div class="tableFixHead">
					<form method="post">
						<?php echo $error; ?>
						
						
						<table>
						
							<thead>
								<th width='20%'>&nbsp</th>
								<th style="text-align:right;" width='80%'>Use this form for add new bookmark</th>
							</thead>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>&nbsp</strong></p>
							</td>
							<td width='80%'>
							&nbsp
							</td>
							</tr>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>Enter Name</strong></p>
							</td>
							<td width='80%'>
								<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $edit_name; ?>" required/>
							</td>
							</tr>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>Enter Link</strong></p>
							</td>
							<td width='80%'>
								<input type="text" name="link" class="form-control" placeholder="Enter the link" value="<?php echo $edit_link; ?>" required/>
							</td>
							</tr>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>Enter Description</strong></p>
							</td>
							<td width='80%'>
								<input type="text" name="description" class="form-control" placeholder="Enter the description" value="<?php echo $edit_description; ?>" />
							</td>
							</tr>

							<tr>
							<td width='20%'>
								<p style="text-align:right;"><strong>Enter link icon</strong></p>
							</td>
							<td width='80%'>
								<!--<input type="text" name="favicon" class="form-control" placeholder="Enter the favicon link" value="<?php echo $edit_favicon; ?>" />-->
								<?php
									$files = glob($IconImagePath . '/*.png');
									echo "<select name=\"favicon\">";
									echo "<option>".$edit_favicon."</option>";
									foreach ($files as $file) {
									echo "<option>".pathinfo($file, PATHINFO_BASENAME)."</option>"; }
									echo "<option></option>";
									echo "</select>";
								?>
								
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
									<input onclick="location.href='index.php';" type="cancel" name="cancel" class="btn btn-info" value="Cancel" />
								</p>
							</td>
							<td width='80%'>
								<p style="text-align:right;">
									<input type="submit" name="submit" class="btn btn-info" value="Save" />
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


