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
require_once('configuration.php');

$initDb = new InitializeDb ();

if($initDb->databaseExists()){
	echo "The database is set and ready for use!";
}else{
	$initDb->createDatabase();
	$initDb->createAllTables();
}

class InitializeDb{
	
	public function __construct(){
		$connect = mysql_connect(DB_HOST, DB_UNAME,DB_PWD);
		define('DB_CON', $connect);
		
	}
	
	public function databaseExists(){
		
		$db_selected = mysql_select_db(DB_NAME, DB_CON);
		
		$itExists = true;
		
		if (!$db_selected) {
			$itExists = false;
			//echo ("Cannot use ".DB_NAME." : " . mysql_error());
		}
		
		return $itExists;
		
		
	}
	
	public function createDatabase(){
	
		$sql = "CREATE DATABASE IF NOT EXISTS `".DB_NAME."` /*!40100 DEFAULT CHARACTER SET latin1 */";

		$result = mysql_query($sql);
	
	
	}
	
	/**
	 * Read all the sql queries form original_images.sql,
	 * then create those tables in the database.
	 * Enter description here ...
	 */
	public function createAllTables(){
		
		$myFile = "original_images.sql";
		
		$fh = fopen($myFile, 'r');
		
		$fh = fopen($myFile, 'r');
		
		$theData = fread($fh, filesize($myFile));
		
		fclose($fh);
		
		$tables = (explode(";",$theData));
		
		$db_selected = mysql_select_db(DB_NAME, DB_CON);
		
		foreach( $tables as $key => $value){

			if($value!=''){
				$result = mysql_query($value);
				//echo "<br/>".$value."<br/>";
			}
		
		}
		
		//close the connection
		mysql_close(DB_CON);
		
		
		echo "Database initialization successfull!";
		
	}
	
}
?>