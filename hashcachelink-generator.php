<?php
/**
 * @package hclg.wordpress.to.korbi.dev
 */
/*
Plugin Name: Hashlink Cachelink Generator
Plugin URI: http://dev.korbi.to/wordpress/plugins/hashlink-generator/
Description: Generates from an URL an indexable page for searchengines which finally redirects to this URL or you are able to cache it to avoid broken links.
Version: 1.0.0
Author: Korbi
Author URI: http://dev.korbi.to/
License: GPLv2 or later
*/

/*
Copyright (C) 2011 Korbi ( www.korbi.to )

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( is_admin() ){
	
	if( get_option('hclg_directory')==FALSE ){
		add_option('hclg_directory', 'r');
	}
	if( get_option('hclg_delay')==FALSE ){
		add_option('hclg_delay', '0');
	}
	if( get_option('hclg_fileextension')==FALSE ){
		add_option('hclg_fileextension', '.html');
	}
	add_action('admin_head', 'hclgJS');
	function hclgJS() {
	?>
		<script type="text/javascript">
var hclgurlInputFields = 1;
function hclgaddURL(){
	hclgurlInputFields++;
	jQuery('#urls').append('<div class="urlcontainer" id="u'+hclgurlInputFields+'"><label for="url'+hclgurlInputFields+'">URL '+hclgurlInputFields+':</label><input type="text" id="url'+hclgurlInputFields+'" size="70"/> I wanna: <select id="method'+hclgurlInputFields+'" onchange="hclgShowAdditional('+hclgurlInputFields+');"><option value="h">Hash it</option><option value="c">Cache it</option></select><div id="url'+hclgurlInputFields+'result"><div id="additional'+hclgurlInputFields+'"><a style="cursor:pointer;" onclick="hclgflipflop(this, \'- Additional data\', \'+ Additional data\');jQuery(\'#seo'+hclgurlInputFields+'\').slideToggle();">+ Additional data</a> (OPTIONAL)<div id="seo'+hclgurlInputFields+'" class="seo"><h4>SEO:</h4><label>Title:</label><input type="text" id="ut'+hclgurlInputFields+'"> (max. 80 chars)<br><label>Description:</label><input type="text" id="ud'+hclgurlInputFields+'"> (max. 160 chars)<br><label>Keywords:</label><input type="text" id="uk'+hclgurlInputFields+'"><br></div></div></div>');
}
var hclgfliped = 0;
function hclgflipflop(trigger, changeValue, originalValue){
	if( hclgfliped == 0 ){
		hclgfliped = 1;
		trigger.innerHTML = changeValue;
	}else{
		hclgfliped = 0;
		trigger.innerHTML = originalValue;
	}
}
function hclgdisplay(elementID){
	var element = document.getElementById( elementID );
	if( element.style.display != 'none'){
		element.style.display = 'none';
	}else{
		element.style.display = 'block';
	}
}
function hclgShowAdditional(id){
	var element = document.getElementById('additional'+id);
	if( element.style.display=="none" || element.style.display==undefined ){
		element.style.display = "";
	}else{
		element.style.display = "none";
	}
}

//tooltip
window.size = function() {
	var w = 0;
	var h = 0;
	//IE
	if(!window.innerWidth) {
		//strict mode
		if(!(document.documentElement.clientWidth == 0)) {
			w = document.documentElement.clientWidth;
			h = document.documentElement.clientHeight;
		}	else {
			//quirks mode
			w = document.body.clientWidth;
			h = document.body.clientHeight;
		}
	} else {
		//w3c
		w = window.innerWidth;
		h = window.innerHeight;
	}
	return {width:w, height:h};
}
window.borders = function() {
	var _left = 0;
	var _right = 0;
	var _top = 0;
	var _bottom = 0;
	var offsetX = 0;
	var offsetY = 0;
	//IE
	if(!window.pageYOffset) {
		//strict mode
		if(!(document.documentElement.scrollTop == 0)) {
			offsetY = document.documentElement.scrollTop;
			offsetX = document.documentElement.scrollLeft;
		} else {
			//quirks mode
			offsetY = document.body.scrollTop;
			offsetX = document.body.scrollLeft;
		}
	} else {
		//w3c
		offsetX = window.pageXOffset;
		offsetY = window.pageYOffset;
	}
	_left = offsetX;
	_right = this.size().width + offsetX;
	_top = offsetY;
	_bottom = this.size().height + offsetY;
	return {left:_left, right:_right, top:_top, bottom:_bottom};
}
hclggetPosition = function(obj) {
	var pos = { x:0, y:0 };

	while(obj) {
		pos.x += parseInt(obj.offsetLeft);
		pos.y += parseInt(obj.offsetTop);
		obj = obj.offsetParent;
	}

	return pos;
}
var hclgtooltip_width = 0;
var hclgtooltip_height = 0;
function hclgshowTooltipDiv(contentID, alignObj) {
	if(alignObj != null) {
		var div = document.getElementById(contentID);

		div.style.position = "relative";
		div.style.display = "block";
		hclgtooltip_width = div.offsetWidth;
		hclgtooltip_height = div.offsetHeight;
		div.style.position = "absolute";
		var pos = hclggetPosition(alignObj);
		var windowLeft = window.borders().left;
		var windowRight = window.borders().right;
		var windowTop = window.borders().top;
		var windowBottom = window.borders().bottom;
		var topPosition = alignObj.offsetHeight;
		var leftPosition = -25;
		var topValue = (pos.y + topPosition + 10);
		topValue = topValue - topPosition - hclgtooltip_height - 30;
		var leftValue = (pos.x + leftPosition);
		if(leftValue + hclgtooltip_width + 15 > windowRight) {
			leftValue = (pos.x + 45 - hclgtooltip_width);
		} else {
			
		}
		if(leftValue < windowLeft + 10) {
			leftValue = windowLeft + 10;
		} else if(leftValue + hclgtooltip_width > windowRight) {
			leftValue = windowRight - hclgtooltip_width - 10;
		}
		div.style.top = topValue + "px";
		div.style.left = leftValue + "px";
		div.style.display = "block";
	}
}
function hclghideTooltipDiv(elementID) {
	var div = document.getElementById(elementID);
	if(div != null) {
		div.style.display = "none";
	}
}
//Ajax functions

//file generation
function hclggenerateFiles(){
	jQuery('#btn_generate').attr("disabled", "disabled");
	for(i=1; i<=hclgurlInputFields; i++){
		url = jQuery("#url"+i).val();
		if( url!="" ){
			data = {
				action: 'hclggenerateFile',
				url: encodeURIComponent( url ),
				method: jQuery('#method'+i).val(),
				seotitle: jQuery('#ut'+i).val(),
				seodescription: jQuery('#ud'+i).val(),
				seokeywords: jQuery('#uk'+i).val(),
				id: i
			};
			switch( jQuery('#method'+i).val() ){
				case 'h': doing="Generate hashlink..."; break;
				case 'c': doing="Generate cachefile..."; break;
			}
			jQuery("#url"+i+"result").html('<img src="<?php echo admin_url(); ?>/images/loading.gif"/>'+doing);
			jQuery('#url'+i).removeAttr( "style" )
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: data,
				dataType: 'json',
				success: function(json){
					if( json.status == "1" ){
						jQuery("#url"+json.id).css("background", "#CCFECC");
						jQuery("#url"+json.id).css("border", "1px solid #55EE55");
						switch( json.method ){
							case 'h': outputDescription='Hashlink: '; break;
							case 'c': outputDescription='Cached file: '; break;
						}
						jQuery("#url"+json.id+"result").html( '<label>'+outputDescription+'</label><input onmouseover="this.select;" type="text" value="'+json.msg+'" size="100"/>' );
					}else{
						jQuery("#url"+json.id).css("background", "#FECCCC");
						jQuery("#url"+json.id).css("border", "1px solid #EE5555");
						jQuery("#url"+json.id+"result").html( 'An error occured. '+json.msg );
					}
				},
				error: function(error){
					
				}
			});
		}
		//alert("I: "+i+" | inputFields: "+hclgurlInputFields);
	}
	//alert("REady! I: "+i+' | inputFields: '+hclgurlInputFields);
	if( (hclgurlInputFields+1)==i ){
		jQuery('#btn_generate').removeAttr( "disabled" );
	}
};
//Settings
function hclgSaveGlobalSettings(){
	data = {
		action: 'hclgSaveSettings',
		delay: jQuery('#delay').val(),
		directory: jQuery('#directory').val(),
		fileextension: jQuery('#fileextension').val(),
		hashpagehtmlcode: encodeURIComponent( jQuery('#hashpagehtmlcode').val() )
	};
	jQuery("#savestatus").html('<img src="<?php echo admin_url(); ?>/images/loading.gif"/> Save settings...');
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#savestatus").html(response);
	});
};
//Sendmail
function hclgSendMail(){
	data = {
		action: 'hclgSendMail',
		email: encodeURIComponent( jQuery('#email').val() ),
		subject: encodeURIComponent( jQuery('#subject').val() ),
		message: encodeURIComponent( jQuery('#message').val() )
	};
	jQuery("#mailstatus").html('<img src="<?php echo admin_url(); ?>/images/loading.gif"/> Sending...');
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#mailstatus").html(response);
	});
};
		</script>
	<?php
	}
	//File generation
	add_action('wp_ajax_hclggenerateFile', 'hclgMakeFile_callback');
	function hclgMakeFile_callback() {
		error_reporting(0);
		$id = $_POST['id'];
		$method = $_POST['method'];
		//double decode!!!
		$url = urldecode(urldecode($_POST['url']));
		if( substr($url,0,7)!="http://" ){
			$url = "http://".$url;
		}
		//check if directory exists
		$directoryName = get_option('hclg_directory');
		if( !is_dir(ABSPATH.$directoryName) ){
			//make directory
			if( !mkdir( ABSPATH.$directoryName, 0755 ) ){
				die('{"status":"0","id":"'.$id.'","method":"'.$method.'","msg":"Directory '.$directoryName.' could not be created! Try again for this URL. Thank you!"}');
			}
		}
		//generate file
		switch( $method ){
			default:
			case 'h':
				$structureFile = WP_PLUGIN_DIR.'/hashcachelink-generator/res/customized-htmlcode-hashpage.txt';	
				if ( is_readable($structureFile) ){
					if ( !$h = fopen($structureFile, "r") ) {
						die('{"status":"0","id":"'.$id.'","method":"'.$method.'","msg":"Error: Couldn\'t open file '.$structureFile.'!"}');
					}
					$htmlCode = fread($h, filesize($structureFile) );
					if ( !$htmlCode ) {
						die('{"status":"0","id":"'.$id.'","method":"'.$method.'","msg":"Error: Couldn\'t read file '.$structureFile.'!"}');
					}
					fclose($h);
				} else {
					die('{"status":"0","id":"'.$id.'","method":"'.$method.'","msg":"Error: File '.$structureFile.' is not readable! Set chmod to 755."}');
				}
				if( !empty($htmlCode) ){
					$htmlCode = str_replace('###TITLE###', '<title>'.$_POST['seotitle'].'</title>', $htmlCode);
					if( $_POST['seodescription'] ){
						$htmlCode = str_replace('###META_DESCRIPTION###', '<meta name="description" content="'.$_POST['seodescription'].'" />', $htmlCode);
					}else{
						$htmlCode = str_replace('###META_DESCRIPTION###', '', $htmlCode);
					}
					if( $_POST['seokeywords'] ){
						$htmlCode = str_replace('###META_KEYWORDS###', '<meta name="description" content="'.$_POST['seokeywords'].'" />', $htmlCode);
					}else{
						$htmlCode = str_replace('###META_KEYWORDS###', '', $htmlCode);
					}
					$htmlCode = str_replace('###DELAY###', get_option('hclg_delay'), $htmlCode);
					$htmlCode = str_replace('###URL###', $url, $htmlCode);
					$replacement = Array("\n", "\r", "\t", "\c");
					$htmlCode = str_replace($replacement, '', $htmlCode);
					$filename = "/".md5( $url );
					$extension = get_option('hclg_fileextension');
					$h = fopen(ABSPATH.$directoryName.$filename.$extension, "w+");
					fwrite($h, $htmlCode);
					fclose($h);
					echo '{"status":"1","id":"'.$id.'","method":"'.$method.'","msg":"'.home_url()."/".$directoryName.$filename.$extension.'"}';
				}else{
					die('{"status":"0","id":"'.$id.'","method":"'.$method.'","msg":"HTML code skeleton could not be loaded."}');
				}
				break;
			case 'c':
				$parsedUrl = parse_url($url);
				$filename = "/".md5( $url );
				if( !empty($parsedUrl['path']) ){
					$splitPath = explode('.', $parsedUrl['path']);
					if( count($splitPath)>=2 ){
						$extension = ".".array_pop($splitPath);
					}else{
						$extension = ".html";
					}
				}else{
					$extension = ".html";
				}
				if( function_exists('file_get_contents') ){
					$pageContent = file_get_contents($url);
				}else{
					$u = fopen($url, "r");
					if( file_exists('stream_get_contents') ){
						$pageContent = stream_get_contents($u);
					}else{
						$pageContent = fread($u, 99999);
					}
					fclose($u);
				}
				$h = fopen(ABSPATH.$directoryName.$filename.$extension, "w+");
				fwrite($h, $pageContent);
				fclose($h);
				echo '{"status":"1","id":"'.$id.'","method":"'.$method.'","msg":"'.home_url()."/".$directoryName.$filename.$extension.'"}';
				break;
		}
		die();
	}
	//Save global settings
	add_action('wp_ajax_hclgSaveSettings', 'hlcgSaveSettings_callback');
	function hlcgSaveSettings_callback() {
		if( get_option('hclg_directory')==$_POST['directory'] ){
			$dir = TRUE;
		}else{
			$dir = update_option('hclg_directory', $_POST['directory']);
		}
		if( get_option('hclg_delay')==$_POST['delay'] ){
			$delay = TRUE;
		}else{
			$delay = update_option('hclg_delay', $_POST['delay']);
		}
		if( get_option('hclg_fileextension')==$_POST['fileextension'] ){
			$fileext = TRUE;
		}else{
			$fileext = update_option('hclg_fileextension', $_POST['fileextension']);
		}
		$errors = Array();
		if( $dir ){
			
		}else{
			$errors['dir'] = "Directory couldn't be saved! Please, try again.";
		}
		if( $delay ){
			
		}else{
			$errors['delay'] = "Delay couldn't be saved! Please, try again.";
		}
		if( $fileext ){
			
		}else{
			$errors['fileext'] = "File type couldn't be saved! Please, try again.";
		}
		$hashPageHTMLCode = urldecode( $_POST['hashpagehtmlcode'] );
		$filename = WP_PLUGIN_DIR.'/hashcachelink-generator/res/customized-htmlcode-hashpage.txt';
		
		if ( is_writable($filename) ){
			if ( !$h = fopen($filename, "w") ) {
				$errors['hashpagehtmlcode'] = 'Couldn\'t open file '.$filename.'! Hashpage HTML code not saved. Make changes manually or try again.';
			}
			if ( !fwrite($h, $hashPageHTMLCode) ) {
				$errors['hashpagehtmlcode'] = 'Couldn\'t write file '.$filename.'! Hashpage HTML code not saved. Make changes manually or try again.';
			}
			fclose($h);
		} else {
			$errors['hashpagehtmlcode'] = 'File '.$filename.' is not writeable! Set chmod to 755 or edit manually.';
		}
		
		if( empty($errors) ){
			echo '<span style="display: block; margin: 3px;padding:0 3px;background:#CCFECC;border:1px solid #55EE55;">Settings saved!<span>';
		}else{
			echo '<span style="display: block; margin: 3px;padding:0 3px;background:#FECCCC;border:1px solid #EE5555;">';
			foreach($errors AS $error){
				echo $error."<br />";
			}
			echo '</span>';
		}
		die();
	}
	//Mail
	add_action('wp_ajax_hclgSendMail', 'sendMail_callback');
	function sendMail_callback() {
		$email = urldecode( $_POST['email'] );
		$subject = urldecode( $_POST['subject'] );
		$message = urldecode( $_POST['message'] );
		$message .= "\n\n"." FROM: ".$email." | ".home_url();
		$header = 'Content-type: text/plain; charset=utf-8' . "\r\n";
		$header .= 'From: '.$email . "\r\n";
		if( mail( 'infinite_korbi@ymail.com', $subject, $message, $header ) ){
			echo "Mail sent.";
		}else{
			echo "Error. Mail could not be sent.";
		}
		die();
	}
	//
	add_action('admin_menu', 'hclgMenu');
	function hclgMenu() {
		add_options_page('Hash|Cache LinkGenerator', 'Hash|Cache LinkGenerator', 'administrator', 'manage_hclg', 'hclgAdminPage');
		//call register settings function
		//add_action( 'admin_init', 'hclgRegisterSettings' );
	}
	//function hclgRegisterSettings() {
	//}
	function hclgAdminPage(){
		if (!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

$fileExtensionOptions = '<option>.html</option><option>.htm</option><option>.php</option>';
$fileExtensionOptions = str_replace('<option>'.get_option('hclg_fileextension'), '<option selected="selected">'.get_option('hclg_fileextension'), $fileExtensionOptions);

$hashpageHTMLCodeFile = WP_PLUGIN_DIR.'/hashcachelink-generator/res/customized-htmlcode-hashpage.txt';	
if ( is_readable($hashpageHTMLCodeFile) ){
	if ( !$h = fopen($hashpageHTMLCodeFile, "r") ) {
		$hashpageHTMLCodeError = 'Error: Couldn\'t open file '.$hashpageHTMLCodeFile.'!';
	}
	$hashpageHTMLCode = fread($h, filesize($hashpageHTMLCodeFile) );
	if ( !hashpageHTMLCode ) {
		$hashpageHTMLCodeError = 'Error: Couldn\'t read file '.$hashpageHTMLCodeFile.'!';
	}
	fclose($h);
} else {
	$hashpageHTMLCodeError = 'Error: File '.$hashpageHTMLCodeFile.' is not readable! Set chmod to 755.';
}

    echo '
<style type="text/css">
	#urls label { width:80px; float:left; margin: 2px 0; }
	.seo { display:none; }
	.seo label { width:100px !important; float:left; }
	#globalsettings { border: 1px solid #ccc; background: #f1f1f1; padding:5px 10px; display:none; }
	#globalsettings label { width: 130px; float:left; }
	#donation { float:right; text-align:center; position:fixed; right:0; top: 30%; }
	.urlcontainer { background:#fafafa; border: 1px solid #ccc; padding:5px; margin: 3px 0 0 0; }
	.hclghide { display:none; }
</style>
<div class="wrap">
<div class="icon32" id="icon-options-general"><br></div>
<h2>Hashlink Cachelink Generator</h2>

<!-- Donation start -->
<button onclick="hclgflipflop(this,\'Donation &Delta;\', \'Donation &nabla;\');jQuery(\'#donation\').slideToggle(500);" style="width:250px;right:0px;position:fixed;z-index:999;">Donation &nabla;</button>
<div id="donation">
<h3>Honor this work!</h3>
<img src="'.plugins_url().'/hashcachelink-generator/img/bitcoin-accepted.png" title="Donate via BitCoin"/>
<br />Bitcoin address: <br /><strong>152sxe6NPBwQuiWXxhMMuCvnKnCykSpWjp</strong>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MHKVKMQUWCFQQ">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
<!-- Donation end -->

<!-- Global settings start -->
<button onclick="hclgflipflop(this, \'Global settings &Delta;\', \'Global settings &nabla;\');jQuery(\'#globalsettings\').slideToggle();">Global settings &nabla;</button>
<div id="globalsettings">
<label for="delay">Redirect delay:</label><input type="text" id="delay" value="'.get_option('hclg_delay').'"/><img src="'.admin_url().'/images/comment-grey-bubble.png"/ class="tooltip-link" onmouseout="hclghideTooltipDiv();" onmouseover="hclgshowTooltipDiv(\'help_delay\', this);"><br />
<label for="directory">Directory name:</label><input type="text" id="directory" value="'.get_option('hclg_directory').'"/><img src="'.admin_url().'/images/comment-grey-bubble.png"/><br />
File type: <select id="fileextension">'.$fileExtensionOptions.'</select><img src="'.admin_url().'/images/comment-grey-bubble.png"/><br />
HTML Code of the hashed pages: (Customize by changing)<img src="'.admin_url().'/images/comment-grey-bubble.png"/><br />
<textarea id="hashpagehtmlcode" cols="100" rows="10">'.$hashpageHTMLCode.$hashpageHTMLCodeError.'</textarea>
<br />
<button class="button-primary" onclick="hclgSaveGlobalSettings();">Save settings</button>
<div id="savestatus"></div>
</div>
<!-- Global settings end -->

<br />
<button onclick="hclgaddURL();">+ add URL</button>
<br />
<div id="urls">
	<div class="urlcontainer" id="u1"><label for="url1">URL 1:</label><input type="text" id="url1" size="70" value=""/> I wanna: <select id="method1" onchange="hclgShowAdditional(1);"><option value="h">Hash it</option><option value="c">Cache it</option></select><div id="url1result"></div>
		<div id="additional1">
		<a style="cursor:pointer;" onclick="hclgflipflop(this, \'- Additional data\', \'+ Additional data\');jQuery(\'#seo1\').slideToggle();">+ Additional data</a> (OPTIONAL)
		<div class="seo" id="seo1">
			<h4>SEO:</h4>
			<label>Title:</label><input type="text" id="ut1"/> (max. 80 chars)<br />
			<label>Description:</label><input type="text" id="ud1"/> (max. 160 chars)<br />
			<label>Keywords:</label><input type="text" id="uk1"/><br />
		</div>
		</div>
	</div>
</div>
<br />

<input type="submit" id="btn_generate" name="Submit" class="button-primary" value="'.__('Generate').'" onclick="hclggenerateFiles();" />

</div>
<div style="margin:20px;padding:10px 20px; border:1px solid #ccc; background: #f5f5f5;">
<h3>In the next version:</h3>
<ul style="list-style:square inside;">
<li>Better integration in the Wordpress URL taxonomy</li>
<li>Adding metaboxes to <i>Posts</i> and <i>Pages</i> for quick generation</li>
<li>Choose where to save, filesystem or database</li>
<li>Shortcode support</li>
<li>Some more improvements</li>
</ul>
<br />
Please, give me some feedback!<br />
Your mail address: <br /><input type="text" id="email"/><br />
Subject: <br /><select id="subject"><!--<option></option><option value="[HCLG Wordpress Plugin] Wish">Wish</option>--><option value="[HCLG Wordpress Plugin] Feedback">Feedback</option></select><br />
Message: <br /><textarea id="message"></textarea><br />
<input type="submit" name="Submit" class="button-primary" value="'.__('Send').'" onclick="hclgSendMail();" />
<div id="mailstatus"></div>
</div>

<!-- Tooltips -->
<div id="help_delay" class="hclghide">

Default value: <strong>0</strong>
</div>
<div id="help_dir" class="hclghide">

Default value: <strong>r</strong>
</div>
<div id="help_extension" class="hclghide">

Default value: <strong>.html</strong>
</div>
<div id="help_htmlpattern" class="hclghide">


</div>
';
	}
} else {
	
}
?>