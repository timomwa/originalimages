<?php
include 'includes/header.php';
include 'classes/security.php';
?>
<!--  /**
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
*/-->
<div id="container">






<?php


if(CURPAGE=='' || CURPAGE==null){

	$current_uri = $_SERVER['REQUEST_URI'];

	$cs = explode("/", $current_uri);

	$curPage = $cs[2];

	define('CURPAGE', $curPage);
}

$message = '';

if(isset($_GET['message']))
$message = '<span style="color: red">'.$_GET['message'].'</span>';



if(Security::isAdmin()){

	//include 'admin/adminScripts.php';

	?>
	<div>




	<?php
	Security::showmainAdminDash();
	?>
		<div id='oiformDiv' class='oiformDiv'>
			<script type="text/javascript">
		$('body').ready(function(){
			$('#oiformDiv').load('forms/cms_tutorial.php');
			});
	</script>
		</div>
	</div>
	
	
	<?php 
}else{
	include 'forms/adminLogin.php';
	echo "";
}
?>
</div>



<?php
include 'includes/footer.php';
?>
