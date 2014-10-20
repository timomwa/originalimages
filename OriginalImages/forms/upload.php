<form action="ajaxupload.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
							<input type="hidden" name="maxSize" value="9999999999" />
							<input type="hidden" name="maxW" value="850" />
							<input type="hidden" name="fullPath" value="albums/" />
							<input type="hidden" name="relPath" value="albums/" />
							<input type="hidden" name="colorR" value="256" />
							<input type="hidden" name="colorG" value="256" />
							<input type="hidden" name="colorB" value="256" />
							<input type="hidden" name="maxH" value="550" />
							<input type="hidden" name="filename" value="filename" />
							<p><input class="niceForm"  type="file" name="filename" onchange="ajaxUpload(this.form,'ajaxupload.php?filename=name&amp;maxSize=9999999999&amp;maxW=850&amp;fullPath=albums/&amp;relPath=../albums/&amp;colorR=256&amp;colorG=256&amp;colorB=256&amp;maxH=550','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" /></p>
						</form>