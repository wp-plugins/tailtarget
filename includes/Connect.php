<?php 

namespace Library\TailTarget;

class Connect{
	
	function __construct(){
		add_action( 'wp_ajax_save_trackingid_data', array(&$this , 'save_trackingid_data_callback') );
		add_action( 'wp_ajax_nopriv_save_trackingid_data', array(&$this , 'save_trackingid_data_callback'));

		add_action( 'wp_ajax_get_trackingid_data', array(&$this , 'get_trackingid_data_callback') );
		add_action( 'wp_ajax_nopriv_get_trackingid_data', array(&$this , 'get_trackingid_data_callback'));
	}

	public function save_trackingid_data_callback() {

		if(isset($_REQUEST['action'])){
			if($_REQUEST['action'] !== 'save_trackingid_data'){
				return false;
			}
			$trackingId = $_REQUEST['trackingId'];
			$settings   = new \Library\TailTarget\Settings();

			if($this->validateTrackingId($trackingId) === true){

				if(get_option('tailtarget_tracking') === FALSE) {
					add_option('tailtarget_tracking', $trackingId);
					echo(json_encode(array('data' => $trackingId , 'statusMessage' => __('Successfully saved' , $settings->slug) , 'statusCode' => 201)));
					die;
			    }else{
					update_option('tailtarget_tracking', $trackingId);
					echo(json_encode(array('data' => $trackingId , 'statusMessage' => __('Successfully updated' , $settings->slug) , 'statusCode' => 201)));
					die;
		    	}
	    	}else{
				echo(json_encode(array('data' => $trackingId , 'statusMessage' => __('The TrackingID entered is not valid' , $settings->slug) , 'statusCode' => 500)));
				die;
	    	}
		}
	}

	public function get_trackingid_data_callback() {

		if(isset($_REQUEST['action'])){
			if($_REQUEST['action'] !== 'get_trackingid_data'){
				return false;
			}
            
            $settings   = new \Library\TailTarget\Settings();
			$trackingId = getTrackingId();

			if($trackingId){
				echo(json_encode(array('data' => $trackingId , 'statusMessage' => __('Success' , $settings->slug) , 'statusCode' => 201)));
				die;
	    	}else{
				echo(json_encode(array('data' => $trackingId , 'statusMessage' => __('Not Found' , $settings->slug) , 'statusCode' => 500)));
				die;
	    	}
		}
	}

	public function validateTrackingId($string = null) {

		if( $string != null ){
			$regex = "/^[A-Z]{2}-[0-9]*-[0-9]{1}$/";
			if(preg_match($regex, $string) == 1){
				return true;
			};	
		}
		return false;
			
	}

}


if ( class_exists('\Library\TailTarget\Connect') ) {
	new \Library\TailTarget\Connect();
}


