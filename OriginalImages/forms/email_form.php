<?php 

include_once '../configuration/configuration.php';
include_once '../classes/security.php';
?>
<H3>Send Email to Client </H3>
<p>Once you create an album and you need to notify them about an album, you can use this section to send them an email notification. 
Please note that the system appends login credentials to the email, you don't need to add those.</p>

<div id='emailFields'>

<label class='fiftypixwide lefters'> To: </label>

<?php 
    $security = new Security();

	$users = $security->getUsers();
	$userUn = json_decode($users,true);
	$allUsers = count($userUn['userId']);
	
	echo "<select onchange='OI.getUserAlbums(this)' id='users' class='oicovercheck lefters'><option value='-1' ></option>";
	
	for($x=0; $x<$allUsers; $x++){
		$user_id = $userUn['userId'][$x];
		$user_name = $userUn['username'][$x];
		$dateRegistered = $userUn['dateRegistered'][$x];
		$role_id = $userUn['role_id'][$x];
		$email_address = $userUn['email_address'][$x];
		
		$email = ($email_address==''||$email_address==null) ? "":" (".$email_address.")";
		
		echo "<option  onclickm=\"OI.getUserAlbums('".$user_id."')\" value='".$user_id."'>".$user_name.$email."</option>";
	}
	
	echo "</select>";
	
	
	echo "<br/><br/><label class='fiftypixwide lefters'>Albums: </label><select id='user_albums' class='oicovercheck lefters'>";
	echo "</select>";
	
?>
<br/>
<br/>
<label class='fiftypixwide lefters'>Subject: </label><input id='subjectin' class='oicovercheck lefters' value='Your Album at Original Images' style='width: 300px;'  type="text" id="Subject"/>
<div class='clearers'></div>
</div>
<textarea id='emailEditor' class='ckeditor' name='ckeditor'>
Hello 
</textarea>

<script type="text/javascript">
<!--


//-->
OI.loadEditor('emailEditor');
</script>
<span id='error'></span><br/>
<button onclick='OI.sendEmail()'>Send Email </button>

