
<?php
/*
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


/**
 *
* @author Timothy Mwangi Gikonyo
* This models the various functions of an album belonging to a user.
* @todo store this object in a user session..
*
*/
class Album{

	public static $ALBUM_DIR = 'albums';

	public function __construct(){
		if(!session_id())
		session_start();
	}

	private $name;

	private $album_id = -2;
	
	private $owner_id;

	private $deleted = false;


	public function setOwnerID($owner_id_){
		$this->owner_id = $owner_id_;
	}
	
	public function getOwnerID(){
		return $this->owner_id;
	}
	
	public function isDeleted(){
		return $this->deleted;
	}

	public function getAlbumId(){
		return $this->album_id;
	}

	public function setAlbumId($album_id_){
		$this->album_id = $album_id_;
		$this->name = $this->getAlbumName($album_id_);
		$this->deleted = $this->checkIfDeleted($album_id_);
		$this->owner_id = $this->getTheOwnerId($album_id_);
	}


	public function getOwner($album_id_){

		$sql = "SELECT u.username as 'name' FROM `".DB_NAME."`.`album` alb LEFT JOIN `".DB_NAME."`.`user` u on alb.user_id = u.id where alb.id=".$album_id_;

		$result = mysql_query($sql) or die(mysql_error());

		$albName = null;

		$counter = 0;
		while ($db_field = mysql_fetch_assoc($result)) {
			$albName = $db_field['name'];
			$counter++;
		}

		if($counter==0)
		return null;
		else
		return $albName;
	}
	
	
	private function getTheOwnerId($album_id_){
	
		$sql = "SELECT user_id from `".DB_NAME."`.`album` where id=".$album_id_;
	
		$result = mysql_query($sql) or die(mysql_error());
	
		$albName = null;
	
		$counter = 0;
		while ($db_field = mysql_fetch_assoc($result)) {
			$albName = $db_field['user_id'];
			$counter++;
		}
	
		if($counter==0)
		return null;
		else
		return $albName;
	}

	private function getAlbumName($album_id_){

		$sql = "SELECT name from `".DB_NAME."`.`album` where id=".$album_id_;

		$result = mysql_query($sql) or die(mysql_error());

		$albName = null;

		$counter = 0;
		while ($db_field = mysql_fetch_assoc($result)) {
			$albName = $db_field['name'];
			$counter++;
		}

		if($counter==0)
		return null;
		else
		return $albName;
	}



	public function getEmailAddAndPwd($user_id){
		$sql = "SELECT email_address,password from `".DB_NAME."`.`user` where id=".$user_id;
		$result = mysql_query($sql) or die(mysql_error());

		while ($db_field = mysql_fetch_assoc($result)) {
			$details['email_address'] = $db_field['email_address'];
			$details['password'] = $db_field['password'];
			return $details;
		}

	}


	/**
	 *
	 * Enter description here ...
	 * @param int $user_id
	 * @param String $content
	 * @param int $album_id
	 * @param String $subject
	 */
	public function notifyUserViaEmail($user_id,$content,$album_id,$subject){

		$sql = "INSERT INTO `".DB_NAME."`.`email_notification`(user_id,album_id,subject,message)
		VALUES(".$user_id.",".$album_id.",'".$subject."','".$content."')";

		$result = mysql_query($sql) or die(mysql_error());

		$emailSent = false;

		$headers = "";
		$headers .= 'From: Original Images <timothy@pixelandtag.com>' . "\r\n" .'Reply-To: timothy@pixelandtag.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";



		$detail = $this->getEmailAddAndPwd($user_id);

		$email = $detail['email_address'];
		$password = $detail['password'];

		$current_uri = $_SERVER['REQUEST_URI'];
			
		$cs = explode("/", $current_uri);
			
		$page = $cs[1];

		$link = "http://".$_SERVER['HTTP_HOST']."/".$page."/clients.php";

		$clientLink = "<p>Please Click <a href='".$link."'>Here</a> to see your album. If you can't see a log in page, please copy and paste this url to your browser;
		<br/>".htmlentities($link)."</p>
		<br/> <br/>
		You will be required to log in in order to view your private album<br/>
		Here are your login credentials;<br/><br/>
		<p>Username: <b>".$email."</b><br/>
		Password: <b> ".$password."</b></p><br/><br/>
		<p>Regards</p><p>Original Images</p>";

		$message = "<html><body>";
		$message .= "<div>";
		$message .= $content.$clientLink;
		$message .= "</div>";
		$message .= "</table>";
		$message .= "</body></html>";


		if(@mail($email, $subject, $message,$headers));
		$emailSent = true;


		if($result && $emailSent){

			$sql = "UPDATE `".DB_NAME."`.`email_notification` set successful=1,dateSent=now() where user_id=".$user_id." AND album_id=".$album_id;
			//echo $sql;
			$result = mysql_query($sql) or die(mysql_error());

			return true;
		}

		return false;



	}


	public function checkIfDeleted($suspect_album_id){

		$sql = "SELECT deleted FROM `".DB_NAME."`.`album` where id=".$suspect_album_id;

		$result = mysql_query($sql) or die(mysql_error());

		$deleted = null;

		$counter = 0;

		while ($db_field = mysql_fetch_assoc($result)) {
			$deleted = $db_field['deleted'];
			$counter++;
		}

		if($counter==0)
		return true;
		else
		return $deleted;

	}

	private $user_id;

	public function getName(){
		return $this->name;
	}

	public function setName($name_){
		$this->name = $name_;
	}


	public function getAlbums($user_id){
		return "album";
	}

	public function undeleteAlbum($album_id){

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$sql = "UPDATE `".DB_NAME."`.`album` SET deleted=0 WHERE id=".$album_id;

			$result1 = mysql_query($sql) or die(mysql_error());

			$result= $result1;

		}

		if($result)
		$this->deleted = false;

		return $result;
	}

	public function deleteAlbum($album_id){

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$sql = "UPDATE `".DB_NAME."`.`album` SET deleted=1 WHERE id=".$album_id;

			$result1 = mysql_query($sql) or die(mysql_error());

			$result= $result1;

		}

		if($result)
		$this->deleted = true;

		return $result;
	}

	public function renameAlbum($album_id, $album_name){


		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$sql = "UPDATE `".DB_NAME."`.`album` SET name='".$album_name."' WHERE id=".$album_id;

			$result1 = mysql_query($sql) or die(mysql_error());

			$result= $result1;

		}

		return $result;
	}


	public static function listAlbumsWithLinks($curAlb){

		$user_id = -1;

		if(isset($_SESSION['userId'])){
			$user_id= $_SESSION['userId'];
		}else{
			$user_id=3;
		}
			

		$albums = Album::getAlbumNamesUsingId($user_id);

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div class='' align='left'>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];


			$alb_name = $albums['albums']['name'][$i];

			$style = $curAlb==$alb_id ? "class='oioverdiv2'" : "";

			echo "<div ".$style."><a style='text-decoration: none !important;' class='oicovercheck2 nodec' href='albums.php?album_id=".$alb_id."'>".$alb_name."</a></div>";
		}

		echo "</div>";

	}


	
	public static function listALLAlbumsWithLinksAndThumbnailsPortfolio(){
	
		$albums = Album::getAlbumNamesUsingId(3);
	
		$sizeOfAlb = count($albums['albums']['id']);
	
		echo "<div class='albDiv'>";
	
		for ($i = 0; $i < $sizeOfAlb; ++$i){
	
			$alb_id = $albums['albums']['id'][$i];
	
			$alb_name = $albums['albums']['name'][$i];
	
			$thumbNailUrl = Album::getThumbNail($alb_id);
	
			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='128px' height='80px' src='".$thumbNailUrl."' alt='thumbnail'/>";
	
			echo "<div class='mainpdiv lefters'>
							<div class='lefters oithumbns'>
								<a class='oicovercheck2' onclick='OI.loadPage(\"oiformDiv\",\"albumAdmin.php?noPanel=true&album_id=".$alb_id."\")' href='javascript:void(0)'>".$thumbNailUrl."</a>
							</div>
							<div class='albName lefters'>".$alb_name."(".Album::getOwner($alb_id).")
							</div>
					 <div class='clearers'></div></div>";
		}
	
		echo "<div class='clearers'></div>";
	
	}


	public static function listALLAlbumsWithLinksAndThumbnails2(){

		$albums = Album::getAllAlbums();

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div class='albDiv'>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='128px' height='80px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div class='mainpdiv lefters'>
						<div class='lefters oithumbns'>
							<a class='oicovercheck2' onclick='OI.loadPage(\"oiformDiv\",\"albumAdmin.php?noPanel=true&album_id=".$alb_id."\")' href='javascript:void(0)'>".$thumbNailUrl."</a>
						</div>
						<div class='albName lefters'>".$alb_name."(".Album::getOwner($alb_id).")
						</div>
				 <div class='clearers'></div></div>";
		}

		echo "<div class='clearers'></div>";

	}


	public static function listALLAlbumsWithLinksAndThumbnails(){

		$albums = Album::getAllAlbums();

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div >";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='100px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div >".$thumbNailUrl."<a class='oicovercheck2' onclick='OI.loadPage(\"oiformDiv\",\"albumAdmin.php?noPanel=true&album_id=".$alb_id."\")' href='javascript:void()'>".$alb_name."</a></div>";
		}

		echo "</div>";

	}




	public static function listAlbumsWithLinksAndThumbnailsAdm(){

		$albums = Album::getAlbumNamesUsingId(3);

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='100px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div>".$thumbNailUrl."<a class='oicovercheck2' href='albumAdmin.php?album_id=".$alb_id."'>".$alb_name."</a></div>";
		}

		echo "</div>";

	}


	public static function listAlbumsWithLinksAndThumbnails(){

		session_start();

		$user_id = -1;

		Security::showUserDash();


		if(isset($_SESSION['userId']))
		$user_id = $_SESSION['userId'];
		else
		$user_id = 3;


		$albums = Album::getAlbumNamesUsingId($user_id);

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='no image'/>" : "<img width='100px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div ><a class='oicovercheck2' href='albums.php?album_id=".$alb_id."'>".$thumbNailUrl."".$alb_name."</a></div>";
		}

		echo "</div>";

		echo '<div class="oicovercheck2"><a href="home.php" class="oicovercheck2 noDecor" style="text-decoration: none !important;"><img alt="back" src="images/back_home.png">&nbsp;<span class="raisedabit">Home</span></a></div>';

	}




	public static function listALLAlbumsWithLinksAndThumbnails4($user_id){

		$albums = Album::getAllAlbums2($user_id);

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div class='albDiv'>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='128px' height='80px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div class='mainpdiv lefters'>
								<div class='lefters oithumbns'>
									<a class='oicovercheck2'  href='albums.php?album_id=".$alb_id."'>".$thumbNailUrl."</a>
								</div>
								<div class='albName lefters'>".$alb_name."(".Album::getOwner($alb_id).")
								</div>
						 <div class='clearers'></div></div>";
		}

		echo "<div class='clearers'></div>";

	}


	public static function listALLAlbumsWithLinksAndThumbnails3(){

		$albums = Album::getAllAlbums();

		$sizeOfAlb = count($albums['albums']['id']);

		echo "<div class='albDiv'>";

		for ($i = 0; $i < $sizeOfAlb; ++$i){

			$alb_id = $albums['albums']['id'][$i];

			$alb_name = $albums['albums']['name'][$i];

			$thumbNailUrl = Album::getThumbNail($alb_id);

			$thumbNailUrl = $thumbNailUrl==null ? "<img width='100px' src='images/no_images.png' alt='thumbnail'/>" : "<img width='128px' height='80px' src='".$thumbNailUrl."' alt='thumbnail'/>";

			echo "<div class='mainpdiv lefters'>
							<div class='lefters oithumbns'>
								<a class='oicovercheck2'  href='albums.php?album_id=".$alb_id."'>".$thumbNailUrl."</a>
							</div>
							<div class='albName lefters'>".$alb_name."(".Album::getOwner($alb_id).")
							</div>
					 <div class='clearers'></div></div>";
		}

		echo "<div class='clearers'></div>";

	}

	/**
	 *
	 * Creates Album for user. if id = 3, then the album
	 * is automatically a public one, anyone will see that
	 * album
	 *
	 * @param int $user_id
	 * @param String $album_name
	 */
	public function createAlbum($user_id, $album_name){

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$query = "SELECT * from `".DB_NAME."`.`album` WHERE user_id=".$user_id." AND name='".$album_name."'";

			$result = mysql_query($query) or die(mysql_error());

			$areThere = 0;

			$album_id;
			while($db_field = mysql_fetch_assoc($result)){
				$areThere++;
				$album_id=$db_field['id'];
			}

			if($areThere>0){
				
				//if(!($user_id==3))
					$addButt =  '<span style="cursor: pointer; color: #33333 !important;" href="" onclick="OI.loadPage(\'oiformDiv\',\'albumAdmin.php?noPanel=true&album_id='.$album_id.'\')">Edit Album</span>';
				//else
					//$addButt = "";
				
				$message['message'] = 'The album called '.$album_name.' already exists. '.$addButt;
				$message['success'] = false;
					
				return json_encode($message);
					
			}

			$public = ($user_id==3) ? 1 : 0;
			$sql = "INSERT  INTO `".DB_NAME."`.`album`(user_id,name,isPublic) VALUES(".$user_id.",'".$album_name."',".$public.")";

			$result1 = mysql_query($sql) or die(mysql_error());


			$query = "SELECT * from `".DB_NAME."`.`album` WHERE user_id=".$user_id." AND name='".$album_name."'";

			$result = mysql_query($query) or die(mysql_error());

			while($db_field = mysql_fetch_assoc($result)){
				$album_id=$db_field['id'];
			}

			$addButt = $result1 ? '<span style="cursor: pointer; color: #33333 !important;" href="" onclick="OI.loadPage(\'oiformDiv\',\'albumAdmin.php?noPanel=true&album_id='.$album_id.'\')">Edit Album</span>' : '';


			$message['message'] = $result1 ? 'Album was successfully added. For user. '.$addButt : 'Album was not created';
			$message['success'] = $result1;

		}else{

			$message['message'] = 'You are not logged in. Please log in first.';
			$message['success'] = $isAdmin;

		}

		return json_encode($message);
	}






	public function getAllAlbums2($user_Id){

		$sql = "SELECT * FROM `".DB_NAME."`.`album` where deleted=0 and user_id=".$user_Id;

		$result = mysql_query($sql) or die(mysql_error());

		$test  = "";

		$id = array();

		$name = array();

		$dateCreated = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$id[] = $db_field['id'];

			$name[] = $db_field['name'];

			$dateCreated[] = $db_field['dateCreated'];

		}

		$photos['albums']['id'] = $id;

		$photos['albums']['name'] = $name;

		$photos['albums']['dateCreated'] = $dateCreated;

		//$encoded = json_encode($photos);

		return $photos;

	}



	public function getAllAlbums(){

		$user_Id = 3;

		if(!session_id())
		session_start();

		if(!isset($_SESSION['userId'])){

			$_SESSION['userId']=$user_Id;

			session_write_close();

		}else{

			$user_Id = $_SESSION['userId'];

		}
		 
		$sql = "SELECT * FROM `".DB_NAME."`.`album` where deleted=0 and user_id != 3";//.$user_Id;

		$result = mysql_query($sql) or die(mysql_error());

		$test  = "";

		$id = array();

		$name = array();

		$dateCreated = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$id[] = $db_field['id'];

			$name[] = $db_field['name'];

			$dateCreated[] = $db_field['dateCreated'];

		}

		$photos['albums']['id'] = $id;

		$photos['albums']['name'] = $name;

		$photos['albums']['dateCreated'] = $dateCreated;

		//$encoded = json_encode($photos);

		return $photos;

	}



	public function getAlbumNamesUsingId($user_Id){

		if(!isset($_SESSION['userId'])){

			$_SESSION['userId']=$user_Id;

			session_write_close();

		}else{
			if($user_Id!=3)
			$user_Id = $_SESSION['userId'];

		}

		$sql = "SELECT * FROM `".DB_NAME."`.`album` where deleted = 0 and user_id =".$user_Id;

		$result = mysql_query($sql) or die(mysql_error());

		$test  = "";

		$id = array();

		$name = array();

		$dateCreated = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$id[] = $db_field['id'];

			$name[] = $db_field['name'];

			$dateCreated[] = $db_field['dateCreated'];

		}

		$photos['albums']['id'] = $id;

		$photos['albums']['name'] = $name;

		$photos['albums']['dateCreated'] = $dateCreated;

		//$encoded = json_encode($photos);

		return $photos;

	}

	public function getAlbumNamesWithUserId($user_id){

		//if(!Security::isAdmin())
		//	die("Please log in firsst");

		$sql = "SELECT * FROM `".DB_NAME."`.`album` where deleted = 0 and user_id =".$user_id;

		$result = mysql_query($sql) or die(mysql_error());


		$test  = "";

		$id = array();

		$name = array();

		$dateCreated = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$id[] = $db_field['id'];
			$name[] = $db_field['name'];
			$dateCreated[] = $db_field['dateCreated'];

		}

		$photos['albums']['id'] = $id;
		$photos['albums']['name'] = $name;
		$photos['albums']['dateCreated'] = $dateCreated;

		$encoded = json_encode($photos);

		return $encoded;

	}


	public function getAlbumNames(){

		$user_Id = -1;

		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no use id in session');
		}
		$sql = "SELECT * FROM `".DB_NAME."`.`album` where deleted = 0 and user_id =".$user_Id;

		$result = mysql_query($sql) or die(mysql_error());


		$test  = "";

		$id = array();

		$name = array();

		$dateCreated = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$id[] = $db_field['id'];
			$name[] = $db_field['name'];
			$dateCreated[] = $db_field['dateCreated'];

		}

		$photos['albums']['id'] = $id;
		$photos['albums']['name'] = $name;
		$photos['albums']['dateCreated'] = $dateCreated;

		$encoded = json_encode($photos);

		return $encoded;

	}

	private function getFirstAlbumId($userId){

		$sql = "SELECT id from `".DB_NAME."`.`album` where user_id=".$userId." and deleted=0 order by dateCreated desc limit 1";

		$result = mysql_query($sql);

		$firstAlbumId = -1;

		while($db_field = mysql_fetch_assoc($result)) {

			$firstAlbumId = $db_field['id'];
		}

		return $firstAlbumId;

	}

	public function getThumbNail($alb_Id){


		$user_Id = -1;

		if($alb_Id==null){
			//$alb_Id = $this->getAlbumId();
			$user_Id = 3;
		}else if($alb_Id==-2){
			//$this->setAlbumId($alb_Id);
		}

		if($user_Id==-1)

		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no user id in session');
		}


		if($alb_Id>-1){

		}else{

			$alb_Id = $this->getFirstAlbumId($user_Id);

		}
		
		$sql = "SELECT
		oi.id as 'id',
		oi.imageUrl as 'imageUrl',
								c.caption as 'caption',
								oi.dateCreated as 'dateUploaded',
								c.timeStamp as 'captionCreated' 
							FROM 
								`".DB_NAME."`.`images` oi 
							LEFT JOIN `".DB_NAME."`.`caption` c 
								ON c.image_id=oi.id and c.album_id=oi.album_id and c.user_id=oi.user_id
							WHERE 
								oi.deleted=0 and oi.album_id=".$alb_Id. 
								" order by  oi.dateCreated desc LIMIT 1";
		
		
		$result = mysql_query($sql) or die(mysql_error());

		$thumbUrl = null;

		while ($db_field = mysql_fetch_assoc($result)) {

			//$photoid[] = $db_field['id'];
			
			//$thumbUrl = (CURPAGE=='admin.php' ? "../" : "").$db_field['imageUrl'];
			$thumbUrl = $db_field['imageUrl'];
			
			//echo $thumbUrl;
			if(file_exists("../".$thumbUrl) || file_exists($thumbUrl)){
				return $thumbUrl;
			}else{
				//echo $sql;
				return null;
			}
			//die ("thumbUrl : ".$thumbUrl);
			//$caption[] = $db_field['caption'];
			//$dateUploaded[] = $db_field['dateUploaded'];
			//$captionCreated[] = $db_field['captionCreated'];

		}

		return $thumbUrl;


	}

	public function getAllPhotos($alb_Id){

		$user_Id = -1;

		if($alb_Id==null){
			$alb_Id = $this->getAlbumId();
			$user_Id = 3;
		}else if($this->album_id==-2){
			$this->setAlbumId($alb_Id);
		}

		if($user_Id==-1)
		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no user id in session');
		}


		if($alb_Id>-1){

		}else{

			$alb_Id = $this->getFirstAlbumId($user_Id);

		}

		$sql = "SELECT
						oi.id as 'id',
						oi.imageUrl as 'imageUrl',
						c.caption as 'caption',
						oi.dateCreated as 'dateUploaded',
						c.timeStamp as 'captionCreated' 
					FROM 
						`".DB_NAME."`.`images` oi 
					LEFT JOIN `".DB_NAME."`.`caption` c 
						ON c.image_id=oi.id and c.album_id=oi.album_id and c.user_id=oi.user_id
					WHERE 
						oi.user_id=".$user_Id." and oi.deleted=0 and oi.album_id=".$alb_Id. 
						" order by  oi.dateCreated desc;";
		//JOIN `".DB_NAME."`.`album` a on oi.album_id = a.id
		//a.deleted=0 and
		$result = mysql_query($sql) or die(mysql_error());

		$test  = "";

		$photos = array();

		$imageUrl = array();

		$photoid = array();

		$captionCreated = array();

		$dateUploaded = array();

		$caption = array();

		while ($db_field = mysql_fetch_assoc($result)) {

			$img_url = $db_field['imageUrl'];
			
			if(file_exists($img_url)){
				$photoid[] = $db_field['id'];
				$imageUrl[] = $img_url;
				$caption[] = $db_field['caption'];
				$dateUploaded[] = $db_field['dateUploaded'];
				$captionCreated[] = $db_field['captionCreated'];
			}
		}

		$photos['photos']['photo_id'] = $photoid;
		$photos['photos']['imageUrl'] = $imageUrl;
		$photos['photos']['caption'] = $caption;
		$photos['photos']['dateUploaded'] = $dateUploaded;
		$photos['photos']['captionCreated'] = $captionCreated;

		$encoded = json_encode($photos);

		return $encoded;
	}

	public function deletePhoto($photo_id){

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){
			$query = "UPDATE `".DB_NAME."`.`images` set deleted=1 where id=".$photo_id;

			$result = mysql_query($query) or die(mysql_error());
		}else{
			$result = false;
		}

		/* $return['message']= $result ? 'Image Was Deleted.' : ($isAdmin ? 'Problem while deleting image. Please try again later' : 'You are not authorized to perform this action. Please <a href="admin.php">Log in</a> first');

		$return['success']=$result;

		$return['reload']=$result; */

		return $result;//json_encode($return);


	}

	public function moveToAlbum($img_id,$album_id){


		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$query = "UPDATE `".DB_NAME."`.`images` set album_id=".$album_id." where id=".$img_id;

			$result1 = mysql_query($query) or die(mysql_error());

			$query = "UPDATE `".DB_NAME."`.`caption` set album_id=".$album_id." where image_id=".$img_id;

			$result2 = mysql_query($query) or die("movingto album failed".mysql_error());

			$result = $result1==true && $result2 == true;

		}else{

			$result = false;

		}

		return $result;


	}


	public static final function saveImage($album_id,$imageUrl){

		$user_Id = -1;

		//if(!session_id())
		//	session_start();

		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no user id in session');
		}

		$sql = "INSERT INTO `".DB_NAME."`.`images`(album_id,user_id,imageUrl)".
				" VALUES(".$album_id.",".$user_Id.",'".$imageUrl."');";

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){

			$result1 = mysql_query($sql) or die(mysql_error());
			$result = $result1;
		}

		return $result;

	}

	public function addCaption($img_id,$caption){

		$user_Id = -1;

		//if(!session_id())
		//	session_start();

		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no user id in session');
		}

		$isAdmin = Security::isAdmin();

		$result = false;

		if($isAdmin){
			$str = trim($caption);

			if(empty($str))
			$query = "DELETE FROM `".DB_NAME."`.`caption` WHERE user_id=".$user_Id." and album_id=".$this->album_id." and image_id=".$img_id."";
			else
			$query = "INSERT INTO `".DB_NAME."`.`caption`(image_id,album_id,user_id,caption)
						VALUES(".$img_id.",".$this->album_id.",".$user_Id.",'".$caption."')"
			." ON DUPLICATE KEY UPDATE album_id=".$this->album_id.",caption='".$caption."'";



			$result = mysql_query($query) or die(mysql_error());
		}else{
			$result = false;
		}

		return $result;

	}



	public final static function getLastImgId(){

		$sql = "SELECT max(id) as 'count' FROM `".DB_NAME."`.`images`";

		//die($sql);

		$result = mysql_query($sql) or die(mysql_error());

		while ($db_field = mysql_fetch_assoc($result)) {

			return $db_field['count'];

		}

	}



	public final static function getuserUploadedImages(){

		$user_Id = -1;

		//if(session_id())
		session_start();

		if(IsSet($_SESSION['userId'])){
			$user_Id = $_SESSION['userId'];
		}else{
			die('no user id in session');
		}



		$sql = "SELECT count(*) as 'count'  FROM `".DB_NAME."`.`images` where user_id=".$user_Id;

		$result = mysql_query($sql) or die(mysql_error());

		while ($db_field = mysql_fetch_assoc($result)) {

			return $db_field['count'];

		}

	}


	public function deletePhotos(){

	}

	public function hidePhotos(){

	}


}

?>