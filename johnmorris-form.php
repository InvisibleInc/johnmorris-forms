<?php
/*
Plugin Name: John Morris Example Forms Plugin
Plugin URI:
Description: An example forms plugin.
Version: 20180218
Author: John Morris
License: GPL2
License URI: http://www.somewhereoutthere.com
Text Domain: jmo-forms
*/

// Include form builder class to help build forms
require_once( __DIR__ . '/includes/class-PHPFormBuilder.php' );

// Main Plugin Class
// Create Class and check to make sure the class doesn't exist so it doesn't trigger a fatal error
if( ! class_exists( 'JMOForms ' ) ) {
	class JMOForms {
		// create main methods/functions
		public __construct() {
			// Most of the loading for the plugin, hooks etc.
			// Create action to enqueue scripts and or styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			// Create shortcode for adding forms
				add_shortcode( 'jmoform', array( $this-> 'form' ) );
		}

		public function enqueue_scripts() {
			// enqueue scripts and or styles
			wp_enqueue_style( 'jmoforms', plugins_url( '/public/css/style.css', __FILE__), array(), 0.1 );
		}

		public function form( $atts ) {
			// Set up the form - uses WP built in form handling
			global $post;

			// $atts = attributes
			$atts = shortcode_atts(
				array(
					'add_honeypot' => false, // set to false by default
				), $atts, 'jmoform' );

				// Instantiate the form class
				$form = new PHPFormBuilder();

				// Set form options - set_att from PHPFormBuilder
				$form->set_att( 'action', esc_url ( admin_url( 'admin-post.php' ) ) );
				// Set Honeypot - from PHPFormBuilder
				$form->set_att( 'add_honeypot', $att['add_honeypot'] );

				// ADD FORM INPUTS
				$form->add_input( 'action', array(
					'type' => 'hidden',
					'value' => 'jmo_contact_form',
				), 'action' );

				$form->add_input( 'wp_nonce', array(
					'type' => 'hidden', // *********************************************//
					'value' => wp_create_nonce( 'submit_contact_form' );
				), 'wp_nonce' );

				$form->add_input( 'redirect_id', array(
					'type' => 'hidden',
					'value' => $post->ID,
				), 'redirect_id' );

				// $form->add_input( 'Human Readable Label', array(Of Options), )
				$form->add_input( 'Field Name Goes Here,e.g. Name', array(
					'type' => 'text',
					'placeholder' => 'Enter your name',
					'required' => true,
				), 'name' );

				$form->add_input( 'Email', array(
					'type' => 'email',
					'placeholder' => 'Enter your email',
					'required' => true,
				), 'email' );

				$form->add_input( 'Website', array(
					'type' => 'url',
					'placeholder' => 'Enter your website URL',
					'required' => false,
				), 'website' );

				$form->add_input( 'Message', array(
					'type' => 'textarea',
					'placeholder' => 'Enter your message',
					'required' => true,
				), 'message' );

				// Shortcodes not output data directly, should return output instead
				ob_start(); // Start buffer

				// Status message
				$status = filter_input( INPUT_GET, 'status', FILTER_VALIDATE_INT );

				if( $status = 1 ) {
					printf( '<div class="message success">
						<p>
						%s
						</p>
					</div>', __( 'Your message was submitted successfully!', 'jmo-forms' ) ); // add jmo-forms to allow text to be translated

					// Build the form
					$form->build_form();

					// Return and clean buffer contents
					return ob_get_clean();
				}

		}

		public function form_handler() {
			// handle form data

		}
	}
}

// instantiate an instant of this Class
$jmoforms = new JMOForms;
