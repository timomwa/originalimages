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
$DATABASE_NAME = "original_images";

$DATABASE_PASSWORD = "root";

$DATABASE_USERNAME = "root";

$DATABASE_HOST = "localhost";

$SESSION_EXPIRE_TIME = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $SESSION_EXPIRE_TIME)) {
	// last request was more than 30 minates ago
	session_destroy();   // destroy session data in storage
	session_unset();     // unset $_SESSION variable for the runtime
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

define('DB_NAME', $DATABASE_NAME);

define('DB_PWD', $DATABASE_PASSWORD);

define('DB_UNAME', $DATABASE_USERNAME);

define('DB_HOST', $DATABASE_HOST);


$con = mysql_connect($DATABASE_HOST, $DATABASE_USERNAME,$DATABASE_PASSWORD);

if (!$con){
	
	die('Could not connect: ' . mysql_error());

}else{
	
	//define('DB_CON_', $con);
}

?>