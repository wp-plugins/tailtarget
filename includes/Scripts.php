<?php 

namespace Library\TailTarget;

class Scripts {
	
	function __construct() {
		add_action('admin_head', array(&$this , 'addScriptInHeaderAdmin'));
		add_action('wp_head', array(&$this , 'addScriptInHeaderSite'));
	}

	function addScriptInHeaderAdmin() {
		$settings   = new \Library\TailTarget\Settings();
        $urlAngular = '/public/js/angular.min.js?v=1.3.11';
        echo '<script> if(!window.angular){document.write(unescape(\'%3Cscript src="'. $settings->directory . $urlAngular .'" %3E%3C/script%3E\'));}</script>';
		echo '<script type="text/javascript" id="angular-app" src="' . $settings->directory . '/public/js/app.admin.js"></script>';
		echo '<link rel="stylesheet" id="plugin-tailtarget-style-admin"  href="' . $settings->directory . '/public/css/style.admin.css' . '"/>';
		echo '<script>var _tailtarget = {messageRequired : "'. __('Tracking ID is required', $settings->slug) .'"};</script>';
	}

	function addScriptInHeaderSite() {
		$settings       = new \Library\TailTarget\Settings();
		$tt_tracking_id = getTrackingId();
			
		if(!$tt_tracking_id){
			echo 
			'<!-- tailtarget.com plugin TailTarget DMP v'. $settings->version .' -->'."\n".
			'<meta property="tailtarget-tracking-verification" content="' . md5(get_option('siteurl')) . '" />'."\n".
			'<!-- end tailtarget.com -->'."\n";
		}else{
			echo
			'<!-- tailtarget.com plugin TailTarget DMP v'. $settings->version .' -->'."\n".
			'<script type="text/javascript">'."\n".
			'var _ttq = _ttq || [];'."\n".
			'_ttq.push(["_setAccount", "' . $tt_tracking_id . '"]);'."\n".
			'(function() {'."\n".
			'	var ts = document.createElement("script"); ts.type = "text/javascript"; ts.async = true;'."\n".
			'	ts.src =  ("https:" == document.location.protocol ? "https://" : "http://") + "'. $settings->baseUrl .'";'."\n".
			'	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);'."\n".
			'})();'."\n".
			'</script>'."\n".
			'<!-- end tailtarget.com -->'."\n";
		}
	}
}

if(class_exists('\Library\TailTarget\Scripts')){
	new \Library\TailTarget\Scripts();
}
