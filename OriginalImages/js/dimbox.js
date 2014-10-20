/**
 *Script : dimbox.js
 *
 *Purpose : Create a div with a lightbox effect
 *
 *Date Created : 27-05-2009
 *Author : Paul Kevin
 */
var dimBox = {
    settings: {
        //inner div content
        content: "",
		header : "<div style='width:100%;'><div style=' float:right; cursor:pointer;' onclick='dimBox.closeDimmer()'>CLOSE</div></div>"
    },
    
    //Function to load. Should be loaded as page loads
    loadDimBox: function(width){
   		var whiteDiv = document.createElement('div');
        whiteDiv.id="dark";
        whiteDiv.className="white_bg";
        document.body.appendChild(whiteDiv);
        var dimPageDiv = document.createElement('div');
        var myHeight = 0;
        dimPageDiv.id = "light";
        dimPageDiv.className = "white_content";
        dimPageDiv.style.marginLeft = (((100 - width)/2)-1)+"%";
        dimPageDiv.style.marginRight = (((100 - width)/2)-1)+"%";
        var browser=navigator.appName;
        
        dimPageDiv.style.width = width+"%";
        /*if (browser == "Microsoft Internet Explorer") {
        	dimPageDiv.style.width = "";
        }else{
			dimPageDiv.style.width = width+"%";
		}*/
		dimPageDiv.style.display = "none";
		dimPageDiv.style.position = "fixed";
		dimPageDiv.style.zIndex="999";
        document.body.appendChild(dimPageDiv);
        dimPageDiv.innerHTML = dimBox.settings.header + "<br/>" + dimBox.settings.content;
        if (typeof(window.innerWidth) == 'number') {
            //Non-IE
            myHeight = window.innerHeight;
            
        }
        else {
            if (document.documentElement &&
            (document.documentElement.clientWidth ||
            document.documentElement.clientHeight)) {
                //IE 6+ in 'standards compliant mode'
                myHeight = document.documentElement.clientHeight;
            }
            else 
                if (document.body && (document.body.clientWidth || 
					document.body.clientHeight)) {
                    //IE 4 compatible
                    myHeight = document.body.clientHeight;
                }
        }
        whiteDiv.style.height = myHeight;
        dimPageDiv.style.top = (myHeight/6)+"px";
    },
    
    showDimmer: function(){
        document.getElementById('dark').style.display = 'block';
        document.getElementById('light').style.display = 'block';
    },
    
    closeDimmer: function(){
		var dimPageDiv = document.getElementById('light');
        dimPageDiv.style.display = 'none';
		document.body.removeChild(dimPageDiv);
		
		var whiteDiv = document.getElementById('dark');
        whiteDiv.style.display = 'none';
		document.body.removeChild(whiteDiv);
    }
};