<?php
/**
* Copyright (c) 2011 http://www.pixelandtag.com
* "Original Images Project"
* Date: 2011-06-10
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/
include_once '../configuration/configuration.php';
include_once '../classes/security.php';
include_once '../classes/cms.php';
include_once '../classes/album.php';

header('Content-type: text/json; charset=UTF-8');

$requestData = $_POST['requestdata'];
$command = $requestData['command'];
$params = $requestData['params'];


if($command=='createAlbum'){

	$album  = new Album();

	$album_name = $params['albumName'];
	$user_id = $params['user_id'];
	
	$msg = $album->createAlbum($user_id, $album_name);
	
	echo $msg;
	
}


if($command=='createUser'){

	$security = new Security();

	$customerName = $params['clientName'];
	$password = $params['password'];
	
	$email_address = $params['email_address'];
	//die($email_address);
	
		
	
	if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$email_address )){
		
		$msg = array();
		//die("invalid email address");
		$msg['message']='The email address is not valid';
		$msg['success']=false;
		die(json_encode($msg));
	}
	
	$resp = $security->addUser($customerName, $password, $email_address, Security::$CUSTMER_ROLE_ID);

	echo $resp;
}


if($command=='login'){

	Security::logOut();
	$security = new Security();

	$username = $params['username'];
	$password = $params['password'];

	$authorized = $security->checkIfAuthorized($username, $password);

	echo $authorized;

}


if($command=='editContent'){
	
	$content = $params['content'];
	$page = $params['page'];
	$div_id = $params['div_id'];
	
	$cms = new CMS();
	$content  = $cms->saveContent($page, $div_id, $content);
	
	echo $content;
}

if($command=='logOut'){
	
	echo Security::logOut();
	
}
if($command=='editAlbum'){

	$album_ID = $params['album_id'];
	$name = $params['name'];
	
	$albUM = new Album();
	$success = false;
	
	$success= $albUM->renameAlbum($album_ID, $name);
	
	$response['message'] = $success ? 'Album Renamed' : 'Failed to rename album, please try again';
	$response['success'] = $success;
	
	echo json_encode($response);
	
}

if($command=='deleteAlbum'){

	$album_ID = $params['album_id'];
	
	
	$albUM = new Album();
	$success = false;
	
	$success= $albUM->deleteAlbum($album_ID);
	
	$response['message'] = $success ? 'Album deleted' : 'Failed to delete album, please try again';
	$response['success'] = $success;
	
	echo json_encode($response);
	
}

if($command=='undeleteAlbum'){

	$album_ID = $params['album_id'];
	
	
	$albUM = new Album();
	$success = false;
	
	$success= $albUM->undeleteAlbum($album_ID);
	
	$response['message'] = $success ? 'Album undeleted successfully' : 'Failed to undelete album, please try again';
	$response['success'] = $success;
	
	echo json_encode($response);
	
}

if($command=='getContent'){

	$div_id = $params['div_id'];
	$page = $params['page'];
	
	$cms = new CMS();
	$content  = $cms->getContent($div_id,true,$page);
	header('Content-type: text/plain; charset=UTF-8');	

	echo $content;
}

if($command=='updateAlbums'){

	$todelete = !isset($params['todelete']) ? null : $params['todelete'];
	$toaddcaption = !isset($params['toaddcaption']) ? null : $params['toaddcaption'];
	$tonewAlbum = !isset($params['tonewAlbum']) ? null : $params['tonewAlbum'];
	$album_id = $params['albun_id'];
	
	
	
	$a = count($todelete);
	$b = count($toaddcaption);
	$c = count($tonewAlbum); 
	
	
	$album = new Album();
	
	$album->setAlbumId($album_id);
	
	$count = 0;
	$successful = 0;
	
	for($x = 0; $x<$a; $x++){
		
		$count++;
		
		$photo_id = $todelete[$x]['img_id'];
		
		if($album->deletePhoto($photo_id))
			$successful++;
	
	}
	
	for($x = 0; $x<$b; $x++){
		
		$count++;
		
		$photo_id = $toaddcaption[$x]['img_id'];
		
		$newCaption = $toaddcaption[$x]['newCaption'];
		
		if($album->addCaption($photo_id,$newCaption))
			$successful++;
	}
	
	for($x = 0; $x<$c; $x++){
		
		$count++;
		
		$photo_id = $tonewAlbum[$x]['img_id'];
		
		$newAlbumId = $tonewAlbum[$x]['newAlbumId'];
		
		if($album->moveToAlbum($photo_id,$newAlbumId))
			$successful++;
	}
	
	$ratio = ($successful/$count)*100;
	
	$successrate = round($ratio,1);
	
	$response['message'] = $successrate==100 ? 'Album Edited Successfully' : 'Problem Editing album. Try again later';
	$response['success'] =  $successrate==100;
	$response['reload'] = $successrate==100;
	
	echo json_encode($response);
	
}



if($command=='loginAdmin'){
	
	Security::logOut();
	
	$uname = $params['uname'];
	$pazz = $params['pazz'];
	
	$authorized = false;
	
	if((md5($pazz)==Security::$PASSWORD_DIGEST) && (md5($uname)==Security::$USERNAME_DIGEST))
		$authorized = true;
	
	if(!session_id())
		session_start();
	
	if($authorized){
		$_SESSION['adminAuthorized']=true;
		$_SESSION['userId'] = 3;
		session_write_close();
	}
	
	$authorize['message'] = $authorized ? 'You are now authorized to edit content. You will be rre-directed to the index page in <span id="counter" class="red">5</span> seconds' : 'Access Denied!';
	$authorize['success'] = $authorized;
	
	echo json_encode($authorize);
	
}
?>