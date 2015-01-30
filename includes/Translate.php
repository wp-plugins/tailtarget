<?php

namespace Library\TailTarget;

class Translate {

  function __construct(){
    add_action('plugins_loaded', array(&$this,'i18n'), 99);
  }

  function i18n() {
  	$settings = new \Library\TailTarget\Settings();
    $domain = $settings->slug;
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR )  . $domain . '-' . $locale . '.mo' );
    load_plugin_textdomain( $domain, FALSE, $settings->i18nPath . '/languages/' . $domain . '-' . $locale . '.mo');
  }
  
}

if(class_exists('\Library\TailTarget\Translate')){
	new \Library\TailTarget\Translate();
}

