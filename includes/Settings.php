<?php 

namespace Library\TailTarget;

class Settings {

	public $version;
	public $slug;
	public $owner;
	public $ownerSite;
	public $baseUrl;
	public $directory;
	public $path;
	public $i18nPath;
	public $siteSingUp;
	public $siteInfo;

	function __construct(){	
		$this->version 		= 1.3;
		$this->slug 		= 'tailtarget';
		$this->owner 		= 'TailTarget DMP';
		$this->ownerSite 	= 'http://www.tailtarget.com';
		$this->baseUrl 		= 'd.tailtarget.com/base.js';
		$this->directory 	= plugins_url() . '/tailtarget';
		$this->path 		= WP_PLUGIN_DIR . '/tailtarget';
		$this->i18nPath 	= WP_PLUGIN_DIR . '/tailtarget/languages/';
		$this->siteSingUp 	= 'https://dashboard.tailtarget.com/signUpForm';
		$this->siteInfo 	= 'http://www.tailtarget.com/publisher/';
	}

	function getSettings(){
		return $this;
	}
}