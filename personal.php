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
	
	//Personal
	$linkfile = $personalpath."".$aduser1.".json";
	
	if (!file_exists($linkfile)) {
		touch($linkfile);
	}
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
	<script src="script/sorttable.js"></script>
	<script src="script/search.js"></script>
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
			<a href="newlink.php?personal=true"><img src="img/plus.png" height="12" border=0> New Link</a>
		<?php endif; ?>
		
		<?php if ((in_array($aduser, $Admin)) or ($UseUserAD == false)) : ?>
			<a href="uploadimage.php"><img src="img/image.png" height="12" border=0></i> Upload Icon</a>
		<?php endif; ?>

		<?php if ((in_array($aduser, $Admin)) or ($UseUserAD == false)) : ?>
			<a href="managegroup.php"><img src="img/group.png" height="12" border=0></i> Manage Group</a>
		<?php endif; ?>

		<div class="right-container">
			<?php if ($UseUserAD == true) : ?>
				<a class="active" href="personal.php"><img src="img/user.png" height="12" border=0></i> Personal</a>
			<?php endif; ?>
		</div>
				
		<div class="right-container-user">
			<a><?php echo $aduser1 ?></a>
		</div>

	</div>
	
	<!--Main-->
	<!--div class="loader"></div>-->
	<div class="main">
		<div class="center">
			
			<!--<img src="img/account.png" height="60" width="60" border=0>
			<h4>ICT Bookmarks - <?php echo $aduser1 ?></h4>-->
			<center>

			<div class="containersearch">
				<table width="100%">
					<tr>
						<td width='65%'><input id="myInput" type="text" placeholder="Search in Bookmarks ..."></td>
						<?php if ($GoogleSearch == true) : ?>
							
							<td width='35%'>
								<form action="https://www.google.com/search" onsubmit="this.submit(); this.reset(); return false;" target="_blank" method="get">	
								<table width="100%">
									<tr>
										
										<td>
											<input type="text" placeholder="Google Search..." name="q"/>
										</td>
										
										<td>
												<button class="submitgoogle" type="submit" value="Google Search">Google Search</button>
											
										</td>
									</tr>
								</table>
								</form>
							</td>

						<?php endif; ?>
							
					</tr>
				</table>
			</div>
			
			<div class="tableFixHead">
			<table id="tabletrcolor">
			<thead>
				<!--https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sort_table_desc-->
				<th width='20'></th>
				<th width='30%'>Name</th>
				<th width='70%'>Description</th>
				<th width='25'></th>
				<th width='25'></th>
				
			</thead>
			<tbody id="myTable">
			<?php
				$data = file_get_contents($linkfile);

				// decode json to associative array
				$json_arr = json_decode($data);
				
				//print_r($json_arr); //Print all array
				If ($json_arr) {
					foreach ($json_arr as $value) {
						$Iconlink = $value->{'favicon'};
						
						if (empty($Iconlink)){
							$Iconlink = '\img\favicon.ico';
						};

						echo "<tr>";
						echo "<td><img src='" . $Iconlink ."' width='15' border=0></td>";
						echo "<td class=\"nametable\"style='text-transform: uppercase;'><span style='font-weight:bold;'><a href='" . $value->{'link'} ."' target='_blank'>" . $value->{'Name'} . "</a></span></td>";
						echo "<td>" . $value->{'Description'} . "</td>";
						
						
						$code = $value->{'Code'};
						//Delete
						echo '<td> 
								<a href = "confirmdelete.php?personal=true&delcode='.$value->{'Code'}.'&delname='.$value->{'Name'}.'">
									<img src="img/x.png" height="20" width="20" border=0 title="Delete">
								</a>
							</td>';
						//Edit
						echo '<td> 
								<a href = "Edit.php?personal=true&editcode='.$value->{'Code'}.'&editname='.$value->{'Name'}.'&editDescription='.$value->{'Description'}.'&editlink='.$value->{'link'}.'&editfavicon='.$value->{'favicon'}.'">
									<img src="img/Edit.png" height="20" width="20" border=0 title="Edit">
								</a>
							</td>';
						
						echo "</tr>";
					}
				}	
			?>
			</tbody>
			</table>
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


