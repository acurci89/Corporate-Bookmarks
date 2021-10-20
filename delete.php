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


	$del_value = $_GET['delcode'];
	
	// read json file
	$data = file_get_contents($linkfile);

	// decode json to associative array
	$json_arr = json_decode($data, true);

	// get array index to delete
	$arr_index = array();
	foreach ($json_arr as $key => $value)
	{
		if ($value['Code'] == $del_value)
		{
			$arr_index[] = $key;
		}
	}

	// delete data
	foreach ($arr_index as $i)
	{
		unset($json_arr[$i]);
	}

	// rebase array
	$json_arr = array_values($json_arr);

	// encode array to json and save to file
	file_put_contents($linkfile, json_encode($json_arr));

	if($personalcheck) :
		echo "<script>window.location = 'personal.php'</script>";
	endif;
	if($groupselection) :
		echo "<script>window.location = 'index.php?group=".$groupselection."'</script>";
	endif; 
	if((!($groupselection)) and (!($personalcheck))) :
		echo "<script>window.location = 'index.php'</script>";
	endif; 


	//if($personalcheck == true) :
	//	
	//else:
	//	echo "<script>window.location = 'index.php'</script>";
	//endif;

?>