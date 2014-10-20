<?php 

include_once '../configuration/configuration.php';
include_once '../classes/security.php';
?>
<H3>Add an album for a client</H3>
<p>Please add an album for a given client then add photos to the album. You can later send them an email notification about their album.</p>
<input type="text" id="albName"/>

<?php 
    $security = new Security();

	$users = $security->getUsers();
	$userUn = json_decode($users,true);
	$allUsers = count($userUn['userId']);
	
	echo "<select id='users' class='oicovercheck'><option value='-1' ></option>";
	
	for($x=0; $x<$allUsers; $x++){
		$user_id = $userUn['userId'][$x];
		$user_name = $userUn['username'][$x];
		$dateRegistered = $userUn['dateRegistered'][$x];
		$role_id = $userUn['role_id'][$x];
		$email_address = $userUn['email_address'][$x];
		
		$email = ($email_address==''||$email_address==null) ? "":" (".$email_address.")";
		
		echo "<option value='".$user_id."'>".$user_name.$email."</option>";
	}
	
	echo "</select>";
	
?>

<button onclick="OI.createAlbum()">Create Album</button>
<span id='actions'></span>