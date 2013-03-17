<?php
/*
 * Plugin Name: Tail Target for Wordpress 
 * Plugin URI: http://www.tailtarget.com/dev/wordpress
 * Description: Utilizando o plugin da Tail Target, você terá um entendimento qualitativo dos usuários que navegam pelo seu site, para utilizar você precisa ter uma conta na <a href="http://tailtarget.com/" target="_blank">Tail Target</a>. <strong>Cadastre-se Gratuitamente <a href="http://www.tailtarget.com" target="_blank">Aqui</a></strong>
 * Version: 0.0.1
 * Author: Tail Target
 * Author URI: http://tailtarget.com/
 * License: GPLv2
 * Text Domain: tailtarget
 */

include('includes/Tracking.php');

if ( class_exists('trackingTailTarget') ) {
	$ttTracking = new trackingTailTarget();
}