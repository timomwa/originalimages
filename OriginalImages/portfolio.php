<?php
include_once 'configuration/configuration.php';
include_once 'classes/security.php';
include_once 'classes/cms.php';
?><!--
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
*/ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Original images Services page</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/gallery.css" type="text/css" media="screen"/>

<link rel="icon" type="images/x-icon" href="favicon.ico" />

</head>

<body>
<div id="container">

<div id="control">
<div id="logo"><a href="index.php"><img src="images/logo.png" alt="Originnal logo"/></a></div>
<div id="navigation">
<ul>
<li><a href="index.php" class="active">Home</a></li>
<li><a href="#" >About us</a></li>
<li><a href="#" >Services</a></li>
<li><a href="#" >Clients</a></li>
<li><a href="#">Portfolio</a></li>
<li><a href="#">Contact</a></li>
<li><a href="#">blog</a></li>
</ul>
</div>
</div>

<div id="clr"><!--used to create space between elements--></div>

		<div id="loader" class="loader"></div>
		<div class="wrapper">
			<div id="ps_container" class="ps_container">
				<div class="ps_image_wrapper">
					<!-- First initial image -->
					<img src="images/1.jpg" alt="" />
				</div>
				<!-- Navigation items -->
				<div class="ps_next"></div>
				<div class="ps_prev"></div>
				<!-- Dot list with thumbnail preview -->
				<ul class="ps_nav">
					<li class="selected"><a href="images/1.jpg" rel="images/thumbs/1.jpg">Image 1</a></li>
					<li><a href="images/2.jpg" rel="images/thumbs/2.jpg">Image 2</a></li>
					<li><a href="images/3.jpg" rel="images/thumbs/3.jpg">Image 3</a></li>
					<li><a href="images/4.jpg" rel="images/thumbs/4.jpg">Image 4</a></li>
					<li><a href="images/5.jpg" rel="images/thumbs/5.jpg">Image 5</a></li>
					<li><a href="images/6.jpg" rel="images/thumbs/6.jpg">Image 6</a></li>
					<li><a href="images/7.jpg" rel="images/thumbs/7.jpg">Image 7</a></li>
					<li><a href="images/8.jpg" rel="images/thumbs/8.jpg">Image 8</a></li>
					<li><a href="images/9.jpg" rel="images/thumbs/9.jpg">Image 9</a></li>
					<li><a href="images/10.jpg" rel="images/thumbs/10.jpg">Image 10</a></li>
					<li class="ps_preview">
						<div class="ps_preview_wrapper">
							<!-- Thumbnail comes here -->
						</div>
						<!-- Little triangle -->
						<span></span>
					</li>
				</ul>
			</div>
		</div>
		


<div id="clr"><!--used to create space between elements--></div>
<div id="footer">
<p>&copy; Original Images 2011 all rights reserved.Built by <a href="#"> ALAMA</a></p>
</div>
</div>
<!-- The JavaScript -->
		<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
			/*
			the images preload plugin
			*/
			(function($) {
				$.fn.preload = function(options) {
					var opts 	= $.extend({}, $.fn.preload.defaults, options),
						o		= $.meta ? $.extend({}, opts, this.data()) : opts;
					return this.each(function() {
						var $e	= $(this),
							t	= $e.attr('rel'),
							i	= $e.attr('href'),
							l	= 0;
						$('<img/>').load(function(i){
							++l;
							if(l==2) o.onComplete();
						}).attr('src',i);	
						$('<img/>').load(function(i){
							++l;
							if(l==2) o.onComplete();
						}).attr('src',t);	
					});
				};
				$.fn.preload.defaults = {
					onComplete	: function(){return false;}
				};
			})(jQuery);
		</script>
        <script type="text/javascript">
			$(function() {
				//some elements..
				var $ps_container		= $('#ps_container'),
					$ps_image_wrapper 	= $ps_container.find('.ps_image_wrapper'),
					$ps_next			= $ps_container.find('.ps_next'),
					$ps_prev			= $ps_container.find('.ps_prev'),
					$ps_nav				= $ps_container.find('.ps_nav'),
					$tooltip			= $ps_container.find('.ps_preview'),
					$ps_preview_wrapper = $tooltip.find('.ps_preview_wrapper'),
					$links				= $ps_nav.children('li').not($tooltip),
					total_images		= $links.length,
					currentHovered		= -1,
					current				= 0,
					$loader				= $('#loader');
				
				/*check if you are using a browser*/	
				var ie 				= false;
				if ($.browser.msie) {
					ie = true;//you are not!Anyway let's give it a try
				}
				if(!ie)
					$tooltip.css({
						opacity	: 0
					}).show();
					
					
				/*first preload images (thumbs and large images)*/
				var loaded	= 0;
				$links.each(function(i){
					var $link 	= $(this);
					$link.find('a').preload({
						onComplete	: function(){
							++loaded;
							if(loaded == total_images){
								//all images preloaded,
								//show ps_container and initialize events
								$loader.hide();
								$ps_container.show();
								//when mouse enters the pages (the dots),
								//show the tooltip,
								//when mouse leaves hide the tooltip,
								//clicking on one will display the respective image	
								$links.bind('mouseenter',showTooltip)
									  .bind('mouseleave',hideTooltip)
									  .bind('click',showImage);
								//navigate through the images
								$ps_next.bind('click',nextImage);
								$ps_prev.bind('click',prevImage);
							}
						}
					});
				});
				
				function showTooltip(){
					var $link			= $(this),
						idx				= $link.index(),
						linkOuterWidth	= $link.outerWidth(),
						//this holds the left value for the next position
						//of the tooltip
						left			= parseFloat(idx * linkOuterWidth) - $tooltip.width()/2 + linkOuterWidth/2,
						//the thumb image source
						$thumb			= $link.find('a').attr('rel'),
						imageLeft;
					
					//if we are not hovering the current one
					if(currentHovered != idx){
						//check if we will animate left->right or right->left
						if(currentHovered != -1){
							if(currentHovered < idx){
								imageLeft	= 75;
							}
							else{
								imageLeft	= -75;
							}
						}
						currentHovered = idx;
						
						//the next thumb image to be shown in the tooltip
						var $newImage = $('<img/>').css('left','0px')
												   .attr('src',$thumb);
						
						//if theres more than 1 image 
						//(if we would move the mouse too fast it would probably happen)
						//then remove the oldest one (:last)
						if($ps_preview_wrapper.children().length > 1)
							$ps_preview_wrapper.children(':last').remove();
						
						//prepend the new image
						$ps_preview_wrapper.prepend($newImage);
						
						var $tooltip_imgs		= $ps_preview_wrapper.children(),
							tooltip_imgs_count	= $tooltip_imgs.length;
							
						//if theres 2 images on the tooltip
						//animate the current one out, and the new one in
						if(tooltip_imgs_count > 1){
							$tooltip_imgs.eq(tooltip_imgs_count-1)
										 .stop()
										 .animate({
											left:-imageLeft+'px'
										  },150,function(){
												//remove the old one
												$(this).remove();
										  });
							$tooltip_imgs.eq(0)
										 .css('left',imageLeft + 'px')
										 .stop()
										 .animate({
											left:'0px'
										  },150);
						}
					}
					//if we are not using a "browser", we just show the tooltip,
					//otherwise we fade it
					//
					if(ie)
						$tooltip.css('left',left + 'px').show();
					else
					$tooltip.stop()
							.animate({
								left		: left + 'px',
								opacity		: 1
							},150);
				}
				
				function hideTooltip(){
					//hide / fade out the tooltip
					if(ie)
						$tooltip.hide();
					else
					$tooltip.stop()
						    .animate({
								opacity		: 0
							},150);
				}
				
				function showImage(e){
					var $link				= $(this),
						idx					= $link.index(),
						$image				= $link.find('a').attr('href'),
						$currentImage 		= $ps_image_wrapper.find('img'),
						currentImageWidth	= $currentImage.width();
					
					//if we click the current one return
					if(current == idx) return false;
					
					//add class selected to the current page / dot
					$links.eq(current).removeClass('selected');
					$link.addClass('selected');
					
					//the new image element
					var $newImage = $('<img/>').css('left',currentImageWidth + 'px')
											   .attr('src',$image);
					
					//if the wrapper has more than one image, remove oldest
					if($ps_image_wrapper.children().length > 1)
						$ps_image_wrapper.children(':last').remove();
					
					//prepend the new image
					$ps_image_wrapper.prepend($newImage);
					
					//the new image width. 
					//This will be the new width of the ps_image_wrapper
					var newImageWidth	= $newImage.width();
				
					//check animation direction
					if(current > idx){
						$newImage.css('left',-newImageWidth + 'px');
						currentImageWidth = -newImageWidth;
					}	
					current = idx;
					//animate the new width of the ps_image_wrapper 
					//(same like new image width)
					$ps_image_wrapper.stop().animate({
					    width	: newImageWidth + 'px'
					},350);
					//animate the new image in
					$newImage.stop().animate({
					    left	: '0px'
					},350);
					//animate the old image out
					$currentImage.stop().animate({
					    left	: -currentImageWidth + 'px'
					},350);
				
					e.preventDefault();
				}				
				
				function nextImage(){
					if(current < total_images){
						$links.eq(current+1).trigger('click');
					}
				}
				function prevImage(){
					if(current > 0){
						$links.eq(current-1).trigger('click');
					}
				}
			});
        </script>
</body>
</html>
