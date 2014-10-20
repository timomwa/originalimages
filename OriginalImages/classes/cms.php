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
class CMS{
	
	public function saveContent($page,$div_id,$content){
		$isAdmin = Security::isAdmin();
		
		if($isAdmin){
			$query = "INSERT INTO `".DB_NAME."`.`page_content`(div_id,content,url) VALUES('".$div_id."','".$content."','".$page."')".
				 " ON DUPLICATE KEY UPDATE content='".$content."', dateCreated=now()";
		
			$result = mysql_query($query) or die(mysql_error());
		}else{
			$result = false;
		}
		$return['message']= $result ? 'Section content Updated.' : ($isAdmin ? 'Problem while saving content. Please try again later' : 'You are not authorized to edit. Please <a href="admin.php">Log in</a>');
			
		$return['success']=$result;
		
		$return['page']=$page;
		
		$return['reload']=$result;
		
		return json_encode($return);
		
	}
	
	public static final function getContent($div_id,$return,$page){
		
		if($page==null){
			
			$current_uri = $_SERVER['REQUEST_URI'];
			
			$cs = explode("/", $current_uri);
			
			$page = $cs[2];
		
		}
		
		$query_ = "SELECT content from `".DB_NAME."`.`page_content` where url='".$page."' and div_id='".$div_id."'";
		
		$result = mysql_query($query_) or die(mysql_error());

		
		//die ("test");
		
		
		while($myrow = mysql_fetch_row($result)){
			
			if($return)
				return urldecode($myrow[0]);
			else
				echo urldecode($myrow[0]);
		
		}
		
	
		
	
	}

}
?>