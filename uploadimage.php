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
			<a class="active" href="uploadimage.php"><img src="img/image.png" height="12" border=0></i> Upload Icon</a>
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
		if(isset($_POST["submit"])){
			$target_dir = $IconImagePath;
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$message = "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$message = "File is not an image.";
				$uploadOk = 0;
			}
			}

			// Check if file already exists
			if (file_exists($target_file)) {
				$message = "Sorry, file already exists.";
			$uploadOk = 0;
			}

			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				$message = "Sorry, your file is too large.";
			$uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "png") {
				$message = "Sorry, only PNG file are allowed.";
			$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$message = "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$message = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			} else {
				$message = "Sorry, there was an error uploading your file.";
			}
			}
		}
	?>


	<!--Main-->
	<div class="main">
		<div class="center">
		<center>
			
			<div class="containersearch">
				<h3 style="text-align:center;">ICT Bookmarks - Upload Image</h3>
			</div>
						
				<div class="tableFixHead">
					<form method="post" enctype="multipart/form-data">
						
						
						
						<table>
						
							<thead>
								<th width='20%'>&nbsp</th>
								<th style="text-align:right;" width='80%'>Use this form for add image for link</th>
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
								<p style="text-align:right;"><strong>Select image to upload:</strong></p>
							</td>
							<td width='80%'>
								
								<input type="file" name="fileToUpload" id="fileToUpload">
								
							</td>
							</tr>

							<!--<tr>
							<td colspan = "2" width='100%'>
								<?php
									$files = glob($IconImagePath . '/*.png');
									echo "<select>";
									foreach ($files as $file) {
									echo "<option>".pathinfo($file, PATHINFO_BASENAME)."</option>"; }
									echo "</select>";
								?>
							</td>
							</tr>-->
							
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
							<td colspan = "2" width='100%'>
								<p style="text-align:center;"><strong><?php echo $message; ?></strong></p>
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
									<input type="submit" value="Upload Image" name="submit">
								</p>
							</td>
							</tr>
							
							
						</table>	
						</form>
						
						<!--<form action="upload.php" method="post" enctype="multipart/form-data">
							
							<input type="file" name="fileToUpload" id="fileToUpload">
							<input type="submit" value="Upload Image" name="submit">
						</form>-->

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


