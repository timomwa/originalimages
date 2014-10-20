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
include('../configuration/configuration.php');
include('../classes/album.php');

header('Content-type: text/json; charset=UTF-8');

$requestData = $_POST['requestdata'];
$command = $requestData['command'];
$params = $requestData['params'];

if($command=='initAlbum'){

	$album = new Album();
	
	$album_id = $params['album_Id'];
	
	$photos = $album->getAllPhotos($album_id);
	
	echo $photos;
	
}


if($command=='getAlbumNames'){

	$album = new Album();
	
	$albumNames = $album->getAlbumNames();

	echo $albumNames;

}

if($command=='sendEmail'){

	$album = new Album();
	
	$user_id = $params['user_id'];
	$content = $params['content'];
	$album_id = $params['album_id'];
	$subject = $params['subject'];
	
	$success = $album->notifyUserViaEmail($user_id,$content,$album_id,$subject);

	$msg['message'] = $success ? 'Email Sent' : 'Email sending failed. Please try again';
	$msg['success'] = $success;
	
	echo json_encode($msg);

}


if($command=='getuserAlbumNames'){

	$album = new Album();
	
	$user_id = $params['user_id'];
	
	$albumNames = $album->getAlbumNamesWithUserId($user_id);

	echo $albumNames;

}


?>