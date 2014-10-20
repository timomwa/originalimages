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
class Security{

	public static $PASSWORD_DIGEST = "38917eec9d7890c26ff5d0f2fc4d5088";
	public static $USERNAME_DIGEST = "63a9f0ea7bb98050796b649e85481845";
	public static $ADMIN_SESSION_ID = "aOeDmS12";

	public static $ADMIN_ROLE_ID = 1;
	public static $CUSTMER_ROLE_ID = 2;

	public function __construct(){

	}



	public static function generatePassword($length, $strength) {

		//if(true)
		//return substr(md5(rand().rand()), 0, $length);

		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		//if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
		//}
		//if ($strength & 2) {
		$vowels .= "AEUY";
		//}
		//if ($strength & 4) {
		$consonants .= '23456789';
		//}
		//if ($strength & 8) {
		$consonants .= '@#$%';
		//}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}


	public static final function logOut(){

		session_start();

		$session_exists = false;

		if(isset($_SESSION['adminAuthorized']) || isset($_SESSION['userId'])){
			$session_exists = true;
		}


		if($session_exists){

			//unset($_SESSION['adminAuthorized']);
			session_destroy();   // destroy session data in storage
			session_unset();     // unset $_SESSION variable for the runtime

		}

		$op['message'] = $session_exists ? 'You have been logged off' : 'You are not logged in.';

		$op['success'] = $session_exists;

		$encoded = json_encode($op);

		return $encoded;

	}

	public static final function showEditor(){

		if(Security::isAdmin()){

			$current_uri = $_SERVER['REQUEST_URI'];

			$cs = explode("/", $current_uri);

			$curPage = $cs[2];
			//echo '<link rel="stylesheet" href="css/original.css" />';


			echo "<div id='editorSpan' >";
			echo 	"<img alt='Edit Content' class='oiditorbutton oipointers' src=\"images/edit.png\" onclick=\"OI.showEditor(this,'".$curPage."')\"/>";
			echo     "<div class='puthere' > Welcome ".(isset($_SESSION['userName'])? $_SESSION['userName'] : "Admin")." | <a class='oismallLinks'  href='admin.php' > Back </a> | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div>";
			echo "</div>";
			/* echo "<div id='editorSpan' ><img alt='Edit Content' class='oiditorbutton oipointers' src=\"images/edit.png\" onclick=\"OI.showEditor(this,'".$curPage."')\"/>";
			 echo " <span style='font-size: 10px; float: right; color: #2B3856'> Welcome Admin | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div></span>";
			*/

		}

	}


	public static final function isLoggedIn(){
		
		if(isset($_SESSION['userId']) && $_SESSION['userId']!=3)
			return true;
		else
			return false;

	}
	
	public static final function showUserDash(){


		/*echo ">>".$_SESSION['userId'];
		 */
		if(isset($_SESSION['userId']) && $_SESSION['userId']!=3){

			$current_uri = $_SERVER['REQUEST_URI'];

			$cs = explode("/", $current_uri);

			$curPage = $cs[2];

			echo "<div id='editorSpan2' >";
			echo     "<div class='puthere' > Welcome ".(isset($_SESSION['userName'])? $_SESSION['userName'] : "Admin")." | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logoutc()'>Logout</a> </div>";
			echo "<div class='clearers'></div>";
			echo "</div>";
			/* echo "<div id='editorSpan' ><img alt='Edit Content' class='oiditorbutton oipointers' src=\"images/edit.png\" onclick=\"OI.showEditor(this,'".$curPage."')\"/>";
			 echo " <span style='font-size: 10px; float: right; color: #2B3856'> Welcome Admin | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div></span>";
			*/

		}

	}

	public static final function showAdminDash(){

		if(Security::isAdmin()){

			$current_uri = $_SERVER['REQUEST_URI'];

			$cs = explode("/", $current_uri);

			$curPage = $cs[2];

			echo "<div id='editorSpan2' >";
			echo     "<div class='puthere' > Welcome ".(isset($_SESSION['userName'])? $_SESSION['userName'] : "Admin")." | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div>";
			echo "<div class='clearers'></div>";
			echo "</div>";
			/* echo "<div id='editorSpan' ><img alt='Edit Content' class='oiditorbutton oipointers' src=\"images/edit.png\" onclick=\"OI.showEditor(this,'".$curPage."')\"/>";
				echo " <span style='font-size: 10px; float: right; color: #2B3856'> Welcome Admin | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div></span>";
			*/

		}

	}

	/**
	 *
	 * Enter description here ...
	 */
	public function getUsers(){

		if(Security::isAdmin()){
				
			$query = "SELECT * FROM `".DB_NAME."`.`user`";
				
			$result = mysql_query($query) or die(mysql_error());
				
			$areThere = 0;
				
			$userId = array();
			$username = array();
			$password = array();
			$dateRegistered = array();
			$role_id = array();
			$email_address = array();
				
			while($myrow = mysql_fetch_row($result)){
				$areThere++;
				$userId[] = $myrow[0];
				$username[] = $myrow[1];
				$password[] = $myrow[2];
				$dateRegistered[] = $myrow[3];
				$role_id[] = $myrow[4];
				$email_address[] = $myrow[5];
			}
				
			$users['userId'] = $userId;
			$users['username'] = $username;
			$users['password'] = $password;
			$users['dateRegistered'] = $dateRegistered;
			$users['role_id'] = $role_id;
			$users['email_address'] = $email_address;
				
			return json_encode($users);
				
		}

	}

	public static final function showmainAdminDash(){

		if(isset($_SESSION['userId']) && $_SESSION['userId']=3)
		if(Security::isAdmin()){

			$current_uri = $_SERVER['REQUEST_URI'];

			$cs = explode("/", $current_uri);

			$curPage = $cs[2];

			echo "<div id='editorSpan2' >";
			//echo '<div id="ad"> <a href="index.php"><img src="images/2logo.png" alt="Original logo"/></a> </div>';
			echo     "<div class='puthere' > Welcome ".(isset($_SESSION['userName'])? $_SESSION['userName'] : "Admin")." |  <a class='oismallLinks' onclick='OI.showForm(\"cms_tutorial.php\")'> CMS </a> | <a class='oismallLinks' onclick='OI.showForm(\"albums_form.php?portfolio=true\")'> Portfolio Albums </a>  | <a class='oismallLinks' onclick='OI.showForm(\"email_form.php\")'> Send Email</a> | <a class='oismallLinks' onclick='OI.showForm(\"add_album.php\")'> Create User Album </a> | <a class='oismallLinks' onclick='OI.showForm(\"albums_form.php\")'> Client Albums </a>  |  <a class='oismallLinks' onclick='OI.showForm(\"new_user.php\")'>Add User</a> | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div>";
			echo "<div class='clearers'></div>";
			echo "</div>";
			/* echo "<div id='editorSpan' ><img alt='Edit Content' class='oiditorbutton oipointers' src=\"images/edit.png\" onclick=\"OI.showEditor(this,'".$curPage."')\"/>";
			 echo " <span style='font-size: 10px; float: right; color: #2B3856'> Welcome Admin | <a class='oismallLinks'  href='javascript:void(0)' onclick='OI.logout()'>Logout</a> </div></span>";
			*/

		}

	}

	public static final function isAdmin(){

		if(!session_id()){

			session_start();

		}

		if (isset($_SESSION['adminAuthorized'])) {

			return $_SESSION['adminAuthorized'];

		}else{

			return false;

		}


	}


	/**
	 *
	 * @param String $name the name supplied
	 * @param String $password the password supplied
	 * @return $security security details
	 */
	function checkIfAuthorized($name, $password){
		$authentic = false;
		$query = "SELECT id,username FROM `".DB_NAME."`.`user` WHERE email_address='$name' and password='$password'";
		$result = mysql_query($query) or die(mysql_error());
		$areThere = 0;


		while($myrow = mysql_fetch_row($result)){
			$areThere++;
			session_start();
			$_SESSION['userId'] = $myrow[0];
			$_SESSION['userName'] = $myrow[1];
			//session_write_close();
		}

		$authentic = (($areThere<1) ? false : true);
		$security = array();
		$security['authentic'] = $authentic;
		$security['message'] = $authentic ? "Logging In.." : "Access Denied. Username and password do not match.";


		$encoded = json_encode($security);

		return $encoded;
	}


	/**
	 *
	 * Add a user. the email address is used as an index..
	 * @param String $customerName
	 * @param String $password
	 * @param String $emailAddres
	 * @param String $role
	 * @return string|multitype:string boolean resource
	 */
	function addUser($customerName,$password,$emailAddres,$role){

		$success = false;

		$message = array();

		if(Security::isAdmin()){
				
			$query = "SELECT * FROM `".DB_NAME."`.`user` WHERE email_address='".$emailAddres."'";

			$result = mysql_query($query) or die(mysql_error());

			$areThere = 0;

			while($myrow = mysql_fetch_row($result)){
				$areThere++;
			}

			if($areThere>0){

				$message['message'] = 'User Already Exists';
				$message['success'] = false;

				return json_encode($message);
					
			}

			$query = "INSERT INTO `".DB_NAME."`.`user`(username,password,role_id,email_address) VALUES('".$customerName."','".$password."',".$role.",'".$emailAddres."')";

			$result = mysql_query($query) or die(mysql_error());

			$success  = $result;
				
			$message['message'] = $success ? 'Added User Successfully' : 'Failed to add user, try agian later';
			$message['success'] = $success;
				
		}else{
			$message['message'] = 'You are not logged in. Please log in first.';
			$message['success'] = false;
		}

		return json_encode($message);;
	}

}
?>