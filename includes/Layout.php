<?php 

namespace Library\TailTarget;

class Layout {

	public function __construct() {
		add_action('admin_menu', array(&$this, 'createPagesAdmin'));
	}

	public function createPagesAdmin() {
		
		$settings = new \Library\TailTarget\Settings();

	  	add_menu_page( 
	  		$settings->owner .': '. __('General Settings' , $settings->slug) , 
	  		$settings->owner , 
	  		'administrator', 
	  		$settings->slug, 
	  		array(&$this, 'pageMain'), 
	  		$settings->directory . '/public/image/icon-menu.png', '100');
	}

	public function pageMain(){
		echo($this->htmlMain());
	}

	public function htmlMain(){

		$settings = new \Library\TailTarget\Settings();

		return '<div class="wrap tailtarget-layout" data-ng-app="SettingsApp">
        <!--  -->    
		<div class="postbox-container" data-ng-controller="SettingsCtrl as settings" >
		<div id="normal-sortables" class="meta-box-sortables ui-sortable">
		<div id="dashboard_right_now" class="postbox ">
		<div class="inside">
		<div class="header-plugin">
			<img src="'. $settings->directory . '/public/image/tailtarget-header.jpg" alt="'. $settings->owner .'">
			<a href="'. $settings->siteInfo .'?utm_source=Wordpress%2BAdmin&utm_medium=Plugin&utm_campaign=Learn%2BMore" target="_blank">
			'. __('Learn More' , $settings->slug) .'
			</a>
		</div>

		<div class="content-form">
		<div id="titlewrap">
		<form method="post" action="options.php">
		<label class="label" for="tailtarget_trackingId">' . __('Tracking ID' , $settings->slug) . '
		<input type="text" required data-ng-model="settings.trackingId" class="field" name="tailtarget_trackingId" size="30" value="" placeholder="TT-0000-0" id="tailtarget_trackingId" autocomplete="off">
		</label>
		<input type="button" data-ng-click="settings.save()" name="tt_tracking_id" id="tt_tracking_id" class="button button-primary button-large" value="'. __('Save' , $settings->slug) .'">

		<div class="message" data-ng-class="{\'error\' : settings.message.type === \'ERROR\' }" data-ng-show="settings.message.type === \'ERROR\'">
			{{settings.message.info}}
		</div>

		<div class="message" data-ng-class="{\'success\' : settings.message.type === \'SUCCESS\' }" data-ng-show="settings.message.type === \'SUCCESS\'">
			{{settings.message.info}}
		</div>
		

		<hr />
		<div class="description">
			<h2>'. __('Would you like to understand your Audience Behavior?' , $settings->slug) .'</h2>
			<span>
			'. __('Tail Target is the right platform for publishers: we help portals, sites and blogs to find out Audience Segments over your media inventory in real time, making it possible to deliver the most relevant advertising and content.' , $settings->slug) .'
			</span>

			<h2>'. __('Building Audience Segments' , $settings->slug) .'</h2>
			<span>
			'. __('By implementing Tail’s Tag Manager into the web pages source code, you will instantly unleash a bunch of behavioral information about your Unique Visitors, classifying them throughout 78 different Audience Segments, such as gender, age, geo location, several interests and 18 different lifestyles.' , $settings->slug) .'
			</span>
		</div>
		
		<div data-ng-show="settings.showRegister === true">
			<hr />
			<a class="singup" href="'. $settings->siteSingUp .'?utm_source=Wordpress%2BAdmin&utm_medium=Plugin&utm_campaign=Sign%2BUp
		" target="_blank">
			'. __('Sign Up Now' , $settings->slug) .'
			</a>
		</div>

		</form>
		</div>
		</div>	
		</div>
		</div>
		</div>
		</div>
		</div>
		';
	}


}

if ( class_exists('\Library\TailTarget\Layout') ) {
	new \Library\TailTarget\Layout();
}
