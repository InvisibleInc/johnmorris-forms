<?php
/*
Plugin Name: Hohn Morris Example Forms Plugin
Plugin URI:
Description: An example forms plugin.
Author: John Morris
License: GPL2
License URI: http://www.somwhereoutthere.com
*/

// Include form builder class
require_once( __DIR__ . '/includes/class-PHPFormBuilder.php' );

// Main Plugin Class
// Create Class
if( ! class_exists( 'JMOForms ' ) ) {
	class JMOForms {
		public __construct() {
			
		}
		
		public function enqueue_scripts() {
			
		}
		
		public function form( $atts ) {
			
		}
		
		public function form_handler() {
			
		}
	}
}

$jmoforms = new JMOForms;