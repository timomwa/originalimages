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
var progressBar;

function positinToCenter(theLight){
	var windowWidth = 0;
	var windowHeight = 0;
		
	if (typeof(window.innerWidth) == 'number') {
            //Non-IE
            windowWidth = window.innerWidth;
            windowHeight = window.innerHeight;
        }
        else 
            if (document.documentElement &&
            (document.documentElement.clientWidth ||
            document.documentElement.clientHeight)) {
                //IE 6+ in 'standards compliant mode'
                windowWidth = document.documentElement.clientWidth;
                windowHeight = document.documentElement.clientHeight;
            }
            else 
                if (document.body && (document.body.clientWidth || 
					document.body.clientHeight)) {
                    //IE 4 compatible
                    windowWidth = document.body.clientWidth;
                    windowHeight = document.body.clientHeight;
                }
		var topPos = ((windowHeight/2) - (theLight.offsetHeight*2));
		var botPos = ((windowWidth/2) - (theLight.offsetWidth/2));	
		var percTop = (topPos/windowHeight) * 100;
		var percLeft = (botPos/windowWidth) * 100;
		theLight.style.position = 'absolute';
		theLight.style.top = (percTop) + '%';	
		theLight.style.left = (percLeft) + '%';
		var BROWSERDIMENSIONS =  {"browser":{"left":percLeft, "top":percTop}};	
}

function $SP(dDiv){
	$HP();
	var idOfWin = dDiv;
	progressBar = document.createElement('div');
	var light = document.getElementById(idOfWin);
	if(light!=null)
		light.appendChild(progressBar);
	else
		document.getElementById('light2').appendChild(progressBar);
	progressBar.innerHTML = '<center><div style="background: #FFF6E6;"><img src="images/loginLoader.gif"></div></center>';
	progressBar.id = 'progressBar';
	progressBar.zIndex = 99999999;
}

function $HP(){
	$D('progressBar');
}

function $G(id){
	return document.getElementById(id);
}

function $GV(id){
	return $G(id).value;
}


function $RED(id){
	$G(id).style.color = 'red';
}

function $D(id){
	var unwanted = $G(id);
	if(unwanted)
		unwanted.parentNode.removeChild(unwanted);
}


/**
 * Appends content of a given url
 * to the parent node of the source.
 * @param url the url
 * @param source the source Div
 * 
 */
function appendToPage(url, source){
	var holder = source.parentNode;
	$(holder).load(url);
}


/**
 * Appends content of a given url
 * to the given div
 * @param url the url
 * @param theDv the div you want
 * to append to.
 * 
 */
function appendToDiv(url, theDv){
	$(theDv).load(url);
}

/**
 * 
 * @param a first value
 * @param b second value
 * @return true if they are identical
 */
function doTheyMatch(a,b){
	return (a==b);
}


/**
 * Toggles visibility
 * @param thatDiv
 * @return
 */
function toggleVisibility(thatDiv){
	var display = thatDiv.style.display;
	if(display=='block'){
		thatDiv.style.display = 'none';
	}else{
		thatDiv.style.display = 'block';
	}
}


function toggleVisibilityId(id){
	
	var thatDiv = $G(id);
	var display = thatDiv.style.visibility;
	alert(display);
	if(display=='block'){
		thatDiv.style.display = 'none';
	}else{
		thatDiv.style.display = 'none';
	}
}


/**
 * Shows the error message on a
 * pop up window
 * @param message the message to be shown
 * @param error the error
 * @param stay boolean whether to remove the note
 * after some time
 * @return false
 */
function notify(message, error, stay){
	$D('error');
	var light = $('#light');//.append("<center><div id='error' class='popupwindowContent'>"+message+"</div><center>");
	if(light.html()==null)
		$('#light2').append("<center><div id='error' class='popupwindowContent'>"+message+"</div><center>");
	else
		$('#light').append("<center><div id='error' class='popupwindowContent'>"+message+"</div><center>");
	if(error)
		$RED('error');
	
	if(stay){
		//N/A
	}
	else{
		setTimeout("$D('error')", 7000);
	}
}


function notif(message,isError){
	  
	  var err = $('#error');

	  if(err.css('display')=='none')
	  err.css('display','none');
	  
	  if(isError)
		err.css('color','red');
	  else
		err.css('color','green');
	  
	  err.html(message); 

	  err.fadeIn(1000);
	  
	  err.fadeOut(5000, function(){
		  var err1 = $('#error');
		  err1.html('');
		  err1.css('display','block');
	  });
	  
}



function notif(message,isError){
  
  var err = $('#error');

  err.css('display','block');
  if(isError)
	err.css('color','red');
  else
	err.css('color','green');
  
  err.html(message);  
  
  err.fadeOut(5000, function(){var err1 = $('#error');err1.html('');err1.css('display','block');});
  
}

function notif(message,isError,error_span_id,dont_fade){
	  
	  var err = $('#'+error_span_id);

	  err.css('display','block');
	  if(isError)
		err.css('color','red');
	  else
		err.css('color','green');
	  
	  err.html(message);  
	  
	  if(dont_fade){
		  
	  }else{
		  err.fadeOut(5000, function(){var err1 = $('#'+error_span_id);err1.html('');err1.css('display','block');});
	  }
}

/**
 * pass ID's only
 * @param element id of element to be moved
 * @param dest id of destination element 
 * @return
 */
function $M(element, dest){
	var el = $G(element);
	var d = $G(dest);
	var or = el;
	if(el.onclick.toString()==function onclick(event) {CUEA.setCourse(this);}){
		el.onclick=function onclick(event) {CUEA.deselectCourse(this);}
	}else{
		el.onclick=function onclick(event) {CUEA.setCourse(this);}
	}
	//$D(element);
	$A(d, or);
	
}

function $A(a, b){
	try{
		a.appendChild(b);
	}catch(e){
		alert(e);
	}	
}

function $GN(name){
	return document.getElementsByName(name);
}

function $GSV(name){
	var els = $GN(name);
	var val;
	for(var x = 0; x<els.length; x++){
		val = getCheckedValue(els[x]);
		if(val != "")
			return val;
	}
}


/**
 * get selected value of radio
 * @param radioObj
 * @return
 */
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

/**
 * 
 * @param id id of the <SELECT> element
 * @return the value if the selected option
 */
function $GSO(id){
	var si = $G(id);
	var val;
	if(si==undefined){
		return null;
	}else{	
		var x = si.selectedIndex;
		val = si[x].value;
		return val;
	}
	
}


function removeSpaces(nsText){


	var nospaces = 1;//document.getElementById("nospaces").checked;
	//var notabs = 1;//document.getElementById("notabs").checked;
	
	nsText = nsText.replace(/(\n\r|\n|\r)/gm,"<1br />");

	if(nospaces == 1 || nospaces ==  true){
	nsText = nsText.replace(/\t/g,"");
	}else{
	nsText = nsText.replace(/\t/g," ");
	}

	re1 = /\s+/g;
	nsText = nsText.replace(re1," ");

	re2 = /\<1br \/>/gi;
	nsText = nsText.replace(re2, "\n");


	return nsText;

}
