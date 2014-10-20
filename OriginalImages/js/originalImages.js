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

var OI = {
	
	editable : '',
	
	adminLogon : 'controllers/admin.php',
	
	album : 'albums.php',
	
	secure : 'controllers/secure.php',	

	objName : 'OI.',

	thumbWidth : '80px',
	
	thumbHeight : '70px',
	
	userId : -1,
	
	album_names_div : 'album_names',
	
	photo_width :  '750px',
	
	photo_height : '500px',

	imgPanel_div : 'expanded_photo',

	thumb_class : 'thumb',

	// Album Controller url
	albumUrl : 'controllers/controller.php',

	thumbnails_div : 'thumbnails_div',

	// Where the album div is at
	albumDiv : 'album_div',

	
	
	editAlb: function(albumid){
		
		window.location = 'albumAdmin.php?album_id='+albumid;
		
	},
	
	showForm: function(name){
		
		if(name){
			$('#oiformDiv').html('<br/><br/><center>Loading, please wait...<br/><img src="images/loader_light_blue.gif" alt="Loading, please wait"/></center>');
			$('#oiformDiv').load('forms/'+name);	
		}else{
			alert('problem loading form '+name);
		}
		
	},
	
	loadPage: function(div_id,page){
		$('#'+div_id).load(page);
	},
	
	commitPhotoEdit : function(obj,album_id){
		
		var actions = {albun_id:album_id,todelete:[],toaddcaption:[],tonewAlbum:[]};
		
		var todel = 0;
		var captionz  = 0;
		var albSwitch = 0;
		
		$(".oiimageDiv").each(function(i,divo){
			
			var myObj = $(divo);
			var imgid = -1;
			var toDelete = false;
			var moveToNewAlb = -1;
			var caption = '';
			
			imgid = myObj.attr('id').split('_')[1];
			toDelete = myObj.find('input').attr('checked') ? true : false;
			
			if(toDelete){
				var deleteOb = {'img_id':imgid};
				actions.todelete[todel] = deleteOb;
				todel++;
			}
			
			caption = myObj.find('textarea').val();
			
			//if(caption!=''){
				
				var newCaption = {'img_id': imgid,'newCaption': caption};
				actions.toaddcaption[captionz] = newCaption;
				captionz++;
			//}
			
			var newAlbumId = myObj.find('select').find(':selected').val();
			
			if(newAlbumId!=-1){
				//alert('imgid: '+imgid+' moving to: '+newAlbumId);
				var movetonewAlbum = {'img_id': imgid,'newAlbumId':newAlbumId};
				actions.tonewAlbum[albSwitch] = movetonewAlbum;
				albSwitch++;
			}
			
		});
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'updateAlbums',
					'params' : actions
				}
			},
			success : OI.genericSuccess,
			dataType : 'json'
		});
	
	},
	
	
	login : function(){
		
		var username = $('#username').val();
		var password = $('#password').val();
		
		if(username=='' || password==''){
			notif('Please fill in all the fields', true,'error');
			return;
		}
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'login',
					'params' : {
						'username' : username,'password':password
					}
				}
			},
			success : OI.loginToAlbum,
			dataType : 'json'
		});
		
		
	},
	
	showMe: function(){
		alert('shown!');
	},
	logoutc: function(){
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'logOut',
					'params' : {
						'reason' : '1'
					}
				}
			},
			success : function(data){
				
				dimBox.settings.content = data.message+'<img class="oipointers" onclick="dimBox.closeDimmer();OI.reloadCurPage()" src="images/ok.png" alt="Ok" />';
				
				dimBox.loadDimBox('20');
				
				dimBox.showDimmer();
				
				$('#editorSpan').remove();
				
				setTimeout('OI.goToClients()',3000);
			
			},
			
			dataType : 'json'
		});
		
	},
	
	logout: function(){
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'logOut',
					'params' : {
						'reason' : '1'
					}
				}
			},
			success : function(data){
				
				dimBox.settings.content = data.message+'<img class="oipointers" onclick="dimBox.closeDimmer();OI.reloadCurPage()" src="images/ok.png" alt="Ok" />';
				
				dimBox.loadDimBox('20');
				
				dimBox.showDimmer();
				
				$('#editorSpan').remove();
				
				setTimeout('OI.goToAdmin()',3000);
			
			},
			
			dataType : 'json'
		});
		
	},
	
	goToClients: function(){
		window.location = 'clients.php';
	},
	
	goToAdmin: function(){
		window.location = 'admin.php';
	},
	
	goHome: function(){
		window.location = 'home.php';
	},
	
	createAlbum: function(){
		
		var albumName = $('#albName').val();
		
		var user_id = $('select').find(':selected').val();
	
		if(user_id==-1 || albumName==''){
			
			notif('Please fill in all the fields',false,'actions');
			
			return;
		
		}
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'createAlbum',
					'params' : {
						'albumName' : albumName, 'user_id': user_id
					}
				}
			},
			success : function(data){
				
				notif(data.message,!data.success,'actions','don\'t fade');
			
			},
			
			dataType : 'json'
		});
		
		
		
	},
	
	addUser: function(){
		
		var clientName = $('#clientName').val();
		var password = $('#password').val();
		var email_address = $('#emailAddress').val();
		
		if(clientName=='' || password=='' || email_address==''){
			
			notif('Please fill in all the fields',false,'actions');
		
			return;
			
		}
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'createUser',
					'params' : {
						'clientName' : clientName, 'password': password, 'email_address' : email_address
					}
				}
			},
			success : function(data){
				
				notif(data.message,!data.success,'actions');
			
			},
			
			dataType : 'json'
		});
		
		
	},
	
	
	loginToAlbum: function(data){
		
		if(data.authentic){
			notif(data.message, false, 'error');
			//$D();
			//$('#container').load(OI.album);
			window.location = OI.album;
		}else{
			notif(data.message, !data.authentic,'error');
		}
		
	},
	
	
	getUserAlbums: function(user_id){
		
		
		//var select = $('#user_albums');
		
		var user_id = $('#users :selected').val();
		
		//alert('user_id: '+user_id);
		
		$.ajax({
			type : 'POST',
			url : this.albumUrl,
			data : {
				'requestdata' : {
					'command' : 'getuserAlbumNames',
					'params' : {
						'user_id':user_id
					}
				}
			},
			success : function(data){
				
				//alert('data');
				var select = $('#user_albums');
				
				select.html('');
				
				var c = 0;
				
				select.find('option').each(function(i,el){
					$(el).remove();
				});
				
				select.append('<option value="-1"> -- </option>');
				var le = data.albums.id.length;

				var id, name, dateCreated;
				
				var firstAlb = '';
				
				for ( var i = 0; i < le; i++) {
	
					id = data.albums.id[i];
					
					name = data.albums.name[i];


					if(i==0)
						firstAlb = name;
					
					dateCreated = data.albums.dateCreated[i];
					
					select.append('<option onclick="OI.alterText(\''+name+'\')" value="'+id+'">'+name+'</option>');
				}
				
				OI.alterText(firstAlb);
				
				
				
			},
			dataType : 'json'
		});
		
	},
	
	sendEmail: function(){
		var user_id = $('#users :selected').val();
		var album_id = $('#user_albums :selected').val();
		var subject = $('#subjectin').val();
		
		content = CKEDITOR.instances['emailEditor'].getData()
		//alert(content);
		//content = escape(content);
		
		if(user_id=='-1' || album_id =='-1' || subject=='' || content==''){
			notif('Please fill and select the necessary fields <br/>',true,'error');
			return;
		}
		
		
		//'content':content,
		$.ajax({
			type : 'POST',
			url : OI.albumUrl,
			data : {
				'requestdata' : {
					'command' : 'sendEmail',
					'params' : {
						'content': content, 'user_id' : user_id, 'album_id' : album_id, 'subject': subject
					}
				}
			},
			success : function(data){
				notif(data.message,!data.success,'error');
			},
			dataType : 'json'
		});
		
		
		
		
	},
	
	alterText: function(firstAlb){
		
		var subjectline = $('#subjectin');
		subjectline.val('Please view your album('+firstAlb+')');
		
	},
	
	
	/**
	 * @user_id
	 * @albumId
	 */
	initAlbum : function(albumId,user_id) {

		OI.userId = user_id;
	
		$.ajax({
			type : 'POST',
			url : this.albumUrl,
			data : {
				'requestdata' : {
					'command' : 'getAlbumNames',
					'params' : {
						'albumId':albumId
					}
				}
			},
			success : OI.printAlbumNames,
			dataType : 'json'
		});
		
		
		
		$.ajax({
			type : 'POST',
			url : this.albumUrl,
			data : {
				'requestdata' : {
					'command' : 'initAlbum',
					'params' : {
						'album_Id':albumId
					}
				}
			},
			success : OI.displayAlbum,
			dataType : 'json'
		});

	},

	
	printAlbumNames: function(data) {
		
		var le = data.albums.id.length;

		var id, name, dateCreated;

		var albumNamesDiv = $('#' + OI.album_names_div);
		
		albumNamesDiv.html('');

		
		for ( var i = 0; i < le; i++) {

			id = data.albums.id[i];

			
			name = data.albums.name[i];

			dateCreated = data.albums.dateCreated[i];

			var albumLink = $("<span/>");
			
			albumLink.attr('id',id);
			albumLink.attr('userID',OI.userId);
			
			albumLink.attr('onclick','OI.initAlbum('+id+','+OI.userId+')');
			
			albumLink.html(name+"<br/>");
			
			albumNamesDiv.append(albumLink);
				
		}
		
		
			
		var homeLink = $("<br/><span/>");
			
		homeLink.html('<a href="index.html">Home</a><br/>');
			
		albumNamesDiv.append(homeLink);
			
			
		
	},
	
	adminLogin: function(){
		
		var _username = $('#username').val();
		
		var _password = $('#password').val();
		
		var fieldsFilled = true;
		
		
		if(_username=='' || _password=='')
			fieldsFilled = false
		$D();
		
		if(!fieldsFilled)
			notif('Please fill in all required fields',true,'error');
		else
			$.ajax({
				type : 'POST',
				url : OI.secure,
				data : {
					'requestdata' : {
						'command' : 'loginAdmin',
						'params' : {
							'uname' : _username,'pazz':_password
						}
					}
				},
				success : OI.reDirect,
				dataType : 'json'
			});
		
		
	}, 
	
	toIndexPage: function(){
		
		window.location = 'index.php';
		
	},
	
	showCDown: function(){
		
		var counter = $('#counter');
		
		var d = counter.html();
		
		counter.html(--d);
		
		counter.css('color','red');	
		counter.css('font-weight','bold');	
		
		if(d<1)
			//setTimeout("OI.reloadCurPage()", 0);
			//OI.reloadCurPage();
			window.location = 'admin.php';
		
		
	},
	
	getContentFromDb: function(div_id,editor_id,ourTextArea){
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'getContent',
					'params' : {
						'div_id' : div_id, 'page':OI.curPage
					}
				}
			},
			success : function(data){
				ourTextArea.val(data);
				OI.loadEditor(editor_id);
			},
					
			dataType : 'text'
		});
		
	}, 
	
	
	showNewAlbPop: function(){
		
		dimBox.settings.content = "<div><H4>New Portfolio Album</H4><input id='newPortAlb' type='text'/><button onclick='OI.newAlbum()'>Add</button><br/><span id='error' class='error' style='display:none;'></span></div>";
			
		dimBox.loadDimBox('60');
		
		dimBox.showDimmer();
		
	},
	
	
	newAlbum: function(){
		
		var newPortAlb = $('#newPortAlb').val();
		
		if(newPortAlb==''){
			
			notif('Please specify Album name',true,'error');
			return;
		}
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'createAlbum',
					'params' : {
						'albumName' : newPortAlb, 'user_id':3
					}
				}
			},
			success : function(data){
				notif(data.message,!data.success,'error');
			},
					
			dataType : 'json'
		});
		
		
		
	},
	
	showEditor : function(el,cur_page){
		
		OI.curPage = cur_page;
		
		var eld = $(el);
		
		var editable = '';
		
		el = eld.parent().parent();
		
		var editor_id = 'edit-'+el.attr('id');
		
		var editButton = "<button onclick=\"OI.saveContent('"+editor_id+"','"+cur_page+"')\">Save</button>";
		
		var errDiv = "<div id='error'></div>";
		
		dimBox.settings.content = "<textarea style='z-index: 102;' class='ckeditor' rows='10' cols='100' name='"+editor_id+"' id='"+editor_id+"'>Loading Page content. Please wait..</textarea>"+editButton+errDiv;
		
		dimBox.loadDimBox('60');
		
		dimBox.showDimmer();
		
		
		var content_div_id = el.attr('id');
		
		OI.getContentFromDb(content_div_id,editor_id,$('#'+editor_id));
		
	},
	
	
	
	loadEditor: function(id){
		
	    var instance = CKEDITOR.instances[id];
	    
	    if(instance) {
	        
	    	CKEDITOR.remove(instance);
	    
	    }
	    
	    CKEDITOR.replace(id);
	
	},
	
	
	/**
	 * Stores the content in the given area to db
	 */
	saveContent: function(textAreaId){
		
		var content = '';
		
		for(var i in CKEDITOR.instances) {
		   
			var nameE = CKEDITOR.instances[i].name;
			if(nameE==textAreaId)
				content = CKEDITOR.instances[i].getData(); 
		}
		
		var div_id = textAreaId.split('-')[1];
		
		content = content.replace(/\+/g,'&#43;');
		
		content = escape(content);
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'editContent',
					'params' : {
						'div_id' : div_id,'content':content,'page':OI.curPage
					}
				}
			},
			success : OI.genericSuccess,
			dataType : 'json'
		});
	},
	
	undeleteAlbum: function(album_id){
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'undeleteAlbum',
					'params' : {
						'album_id' : album_id
					}
				}
			},
			success : function(data){
				notif(data.message,!data.success,'error1');
				if(data.success)
					setTimeout('OI.reloadCurPage()',3000);
			},
			dataType : 'json'
		});
		
	},
	
	deleteAlbum: function(album_id){
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'deleteAlbum',
					'params' : {
						'album_id' : album_id
					}
				}
			},
			success : function(data){
				notif(data.message,!data.success,'error0');
				if(data.success)
					setTimeout('OI.reloadCurPage()',3000);
			},
			dataType : 'json'
		});
		
	},
	
	renameAlbum: function(album_id){
		
		var h3Heading = $('#alb_h_id_'+album_id);
		var boldSpan = $('#alb_span_id_'+album_id);
		var albInputField = $('#inpt'+album_id);
		
		if(boldSpan.html()==albInputField.val() || albInputField.val()=='')
			return;
		
		$.ajax({
			type : 'POST',
			url : OI.secure,
			data : {
				'requestdata' : {
					'command' : 'editAlbum',
					'params' : {
						'album_id' : album_id, 'name':albInputField.val()
					}
				}
			},
			success : function(data){
				notif(data.message,!data.success);
				h3Heading.html(albInputField.val());
				boldSpan.html(albInputField.val());
			},
			dataType : 'json'
		});
		
	},
	
	reloadCurPage: function(){
		
		history.go(0);
			
	},
	
	genericSuccess: function(data){
	
		notif(data.message,!data.success,'error');
		if(data.reload)
			history.go(0);//$('body').load(data.page);
	
	},
	
	reDirect: function(data){
		
		notif(data.message,!data.success,'error');
		
		if(data.success)
			setInterval('OI.showCDown()',1000);
			
		
	},
	
	
	displayAlbum : function(data) {
		
		var le = data.photos.photo_id.length;

		var id, album_id, user_id, imageUrl, deleted, dateCreated;

		var thumbnails = $('#' + OI.thumbnails_div);
		
		thumbnails.html('');

		var expanded_photo = $('#' + OI.imgPanel_div);
		
		expanded_photo.html('');

		var thumbnail;
		var liEl;
		var captionSpan;
		var hrefB;

		for ( var i = 0; i < le; i++) {

			id = data.photos.photo_id[i];

			album_id = data.photos.album_id[i];

			user_id = data.photos.user_id[i];

			imageUrl = data.photos.imageUrl[i];

			deleted = data.photos.deleted[i];

			dateCreated = data.photos.dateCreated[i];
			
			var caption = 'Caption goes here';
			
			thumbnail = $('<img/>');
			
			thumbnail.attr('src', imageUrl);
			
			thumbnail.attr('id', 'img_'+id);
			
			thumbnail.attr('src', imageUrl);
			
			thumbnail.css('display','none');
			
			thumbnail.attr('id', 'img_'+id);

			var s = thumbnail.clone();

			thumbnail.attr('onclick', 'OI.expandImg("'+imageUrl+'")');

			if (i == 0) {
				
				s.attr('width', OI.photo_width);
				s.attr('height', OI.photo_height);
				s.css('display','none');
				expanded_photo.append(s);
				s.fadeIn(1000);
			
			}

			thumbnail.attr('width', OI.thumbWidth);
			thumbnail.attr('height', OI.thumbHeight);
			
			thumbnail.attr('class', OI.thumb_class);
			thumbnail.css('display','none');
			thumbnails.append(thumbnail);
			thumbnail.fadeIn(1000);
			
			
			

		}
	},

	expandImg : function(imgUrl) {

		var expanded_photo = $('#' + OI.imgPanel_div);
		
		expanded_photo.html('');
		
		var thumbnail = $('<img/>');

		thumbnail.attr('src', imgUrl);
		
		thumbnail.attr('width', OI.photo_width);
		
		expanded_photo.append(thumbnail);
	}

}