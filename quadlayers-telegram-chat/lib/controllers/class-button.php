<?php

namespace QuadLayers\QLTGM\Controllers;

class Button extends Base {

	protected static $instance;

	private function __construct() {
		add_action( 'wp_ajax_qltgm_save_button', array( $this, 'ajax_qltgm_save_button' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	function add_menu() {
		add_submenu_page( QLTGM_DOMAIN, esc_html__( 'Button', 'quadlayers-telegram-chat' ), esc_html__( 'Button', 'quadlayers-telegram-chat' ), 'manage_options', QLTGM_DOMAIN . '_button', array( $this, 'add_panel' ) );
	}

	function add_panel() {

		global $submenu;

		$button_model = new \QuadLayers\QLTGM\Models\Button();
		$button       = $button_model->get();

		include QLTGM_PLUGIN_DIR . 'lib/view/backend/pages/parts/header.php';
		include QLTGM_PLUGIN_DIR . 'lib/view/backend/pages/button.php';
	}

	public function ajax_qltgm_save_button() {
		$button_model = new \QuadLayers\QLTGM\Models\Button();
		if ( current_user_can( 'manage_options' ) ) {
			if ( check_ajax_referer( 'qltgm_save_button', 'nonce', false ) && isset( $_REQUEST['form_data'] ) ) {
				$form_data = array();
				parse_str( $_REQUEST['form_data'], $form_data );
				if ( is_array( $form_data ) ) {
					$button_model->save( $form_data );
					return parent::success_save( $form_data );
				}
				return parent::error_reload_page();
			}
			return parent::error_access_denied();
		}
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
