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
include_once 'configuration/configuration.php';
include_once 'classes/security.php';
include_once 'classes/cms.php';

?>
<?php include 'includes/header.php';?>
<div id="container">
	<div id="services">
		<div id="left">
			<img src="images/sessions2.jpg" alt="sessions image" />
		</div>

		<div id="right"><h3>Sessions</h3>
			<div id="scrollbar1">
				<div class="scrollbar">
					<div class="track">
						<div class="thumb">
							<div class="end"></div>
						</div>
					</div>
				</div>
				<div class="viewport">
					<div class="overview">

						<div id="modright">
							
							
						<?php
						Security::showEditor();
						CMS::getContent("modright",false,null);
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<?php include 'includes/navigator.php';?>

<?php include 'includes/footer.php';?>