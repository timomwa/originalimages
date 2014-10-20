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
error_reporting(E_WARNING);

include_once('../configuration/configuration.php');

include_once('../classes/security.php');

$authorized = false;

$pazz = '';

$uname = '';

if(isset($_POST["requestdata"])){
	
	$requestData = $_POST['requestdata'];
	
	$command = $requestData['command'];
	
	$params = $requestData['params'];

	$pazz = $params["pazz"];

	$uname = $params["uname"];
	
}


if((md5($pazz)==Security::$PASSWORD_DIGEST) && (md5($uname)==Security::$USERNAME_DIGEST))
	$authorized = true;

if(!$authorized){
	
	include '../admin/logonpage.php';

}else{
	
	session_start();
	session_name("adminSession");
	
	
	$_SESSION['adminAuthorized']=true;
	session_write_close();
	
	
	echo json_encode("{'message':'Authorized!','success':true}");

}
?>
