<?php
/**
 * Class trackingTailTarget insert tracking code into header all pages of blog/site
 * @author Weslley Alves <weslley@wezo.com.br>
 * @version 1.0
 */

class trackingTailTarget{

	public $urlRegister = 'http://www.tailtarget.com/';
	public $urlBaseJs 	= 'd.tailtarget.com/base.js';
	public $version		= '1.0';
	public $message		= null;
	public $typeMessage = null;

	public function __construct(){

		//if(is_admin()){
		//	add_action('admin_menu', array($this, 'add_plugin_page'));
		//	add_action('admin_init', array($this, 'page_init'));
		//}
		//add_action('wp_head', array($this, 'add_tailtarget_tags'),99);
	}

	function getTrackingID() {
		
		$options = new stdClass();
			
		$dataOption = get_option('tailtarget_tracking');
		if( $dataOption != false ){
			if(json_decode($dataOption) != NULL){
				$options = json_decode($dataOption);
			}
		}

		$tt_tracking_id = NULL;
			
		if(property_exists($options,'tt_tracking_id')){
			$tt_tracking_id = $options->tt_tracking_id;
		}
			
		return $tt_tracking_id;
	}

	function add_tailtarget_tags() {
			
		$tt_tracking_id = $this->getTrackingID();
			
		if($tt_tracking_id === NULL){
			echo 
			'<!-- tailtarget.com.br plugin Tail Target for Wordpress v'.$this->version.' -->'."\n".
			'<meta property="tailtarget-tracking-verification" content="'.md5(get_option('siteurl')).'" />'."\n".
			'<!-- end tailtarget.com.br -->'."\n";
		}else{
			echo
			'<!-- tailtarget.com.br plugin Tail Target for Wordpress v'.$this->version.' -->'."\n".
			'<script type="text/javascript">'."\n".
			'var _ttq = _ttq || [];'."\n".
			'_ttq.push(["_setAccount", "'.$tt_tracking_id.'"]);'."\n".
			'(function() {'."\n".
			'	var ts = document.createElement("script"); ts.type = "text/javascript"; ts.async = true;'."\n".
			'	ts.src =  ("https:" == document.location.protocol ? "https://" : "http://") + "'.$this->urlBaseJs.'";'."\n".
			'	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);'."\n".
			'})();'."\n".
			'</script>'."\n".
			'<!-- end tailtarget.com.br -->'."\n";
		}
	}

	public function add_plugin_page() {
		
		add_options_page('Tail Target Configuration Plugin', 'Tail Target', 'manage_options', 'tt-setting-admin', array($this, 'create_admin_page'));
	
	}

	public function create_admin_page(){ ?>
		<div class="wrap">
		<h2> Opções </h2> <br>
		<div data-ng-include="template.url"></div>
		<form method="post" action="options.php">
				<?php
				settings_fields('tailtarget_tracking_option_group');
				do_settings_sections('tailtarget-tracking-setting-admin');
				submit_button(); ?>
			</form>
		</div>
		<?php 
	}

	public function page_init() {

		register_setting('tailtarget_tracking_option_group', 'tt_tracking', array($this, 'check_ID'));
		
		add_settings_section(
			'tailtarget_tracking_section',
			__('Settings'),
			null,
			'tailtarget-tracking-setting-admin'
		);
		
		add_settings_field(
			'tt_tracking_id',
			'<label for="tt_tracking_id">Tracking ID <br> <span style="color:#ccc">TT-00000-0</span></label>',
			array($this, 'create_an_id_field'),
			'tailtarget-tracking-setting-admin',
			'tailtarget_tracking_section'
		);

	}
	
	public function validateTrackingID($string = null) {

		if( $string != null ){
			$regex = "/^[A-Z]{2}-[0-9]*-[0-9]{1}$/";
			if(preg_match($regex, $string) == 1){
				return true;
			};	
		}
		return false;
		
	}

	public function check_ID() {

		if( $_POST['tt_tracking'] ){
			
			if( $_POST['tt_tracking']['tt_tracking_id'] ){

				if($this->validateTrackingID($_POST['tt_tracking']['tt_tracking_id']) == true){
	
					$mid = json_encode($_POST['tt_tracking']);
	
					if(get_option('tailtarget_tracking') === FALSE) {
						add_option('tailtarget_tracking', $mid);
						$this->message = "successfully saved";
						$this->typeMessage = 'updated';
				    }else{
						update_option('tailtarget_tracking', $mid);
						$this->message = "successfully updated";
						$this->typeMessage = 'updated';
			    	}
		    	}else{
					$this->message = "the TrackingID entered is not valid";
					$this->typeMessage = 'error';

		    	}
		    	
	    	}else{
				delete_option('tailtarget_tracking');
				$this->message = "successfully removed" ;
				$this->typeMessage = 'updated';
	    	}
		}else{
		    $mid = '';
		}

		add_settings_error(
			'unique_identifyer'.uniqid(),
		    esc_attr('settings_updated'),
		    __($this->message),
		    $this->typeMessage
		);
		
		return $mid;
		
	}

	public function create_an_id_field() { ?>
	
		<?php 
		$tt_tracking_id = $this->getTrackingID();
		?>
		<input
			type="text" id="tt_tracking_id" name="tt_tracking[tt_tracking_id]"
			value="<?php echo $tt_tracking_id ?>" />
		
		<?php  
	}

}


if ( class_exists('trackingTailTarget') ) {
	$ttTracking = new trackingTailTarget();
}