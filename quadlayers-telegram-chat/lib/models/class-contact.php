<?php

namespace QuadLayers\QLTGM\Models;

class Contact extends Base {

	protected $table = 'contacts';

	function get_args() {

		$display_component_model = new Display_Component();
		$args                    = array(
			'id'               => null,
			'order'            => 1,
			'active'           => 1,
			// Defaults
			// -----------------------------------------------------------------
						'chat' => true,
			'auto_open'        => false,
			'avatar'           => 'https://www.gravatar.com/avatar/00000000000000000000000000000000',
			// 'phone' => '542215677768',
			'username'         => 'username',
			'firstname'        => 'John',
			'lastname'         => 'Doe',
			'label'            => esc_html__( 'Support', 'quadlayers-telegram-chat' ),
			/*     'message' => esc_html__('Hello!', 'quadlayers-telegram-chat'), */
				'timefrom'     => '00:00',
			'timeto'           => '00:00',
			'timezone'         => qltgm_get_current_timezone(),
			'timeout'          => 'readonly',
			'timedays'         => array(),
			'display'          => $display_component_model->get_args(),
		);

		return $args;
	}

	function get_next_id() {
		$contactos = $this->get_contacts();
		if ( count( $contactos ) ) {
			return max( array_keys( $contactos ) ) + 1;
		}
		return 0;
	}

	function add_contact( $contact_data ) {
		$contact_id         = $this->get_next_id();
		$contact_data['id'] = $contact_id;
		return $this->save( $contact_data );
	}

	function update_contact( $contact_data ) {
		return $this->save( $contact_data );
	}

	function update_contacts( $contacts, $order = 0 ) {
		return $this->save_with_reorder( $contacts );
	}

	function save( $contact_data = null ) {
		$contacts                        = $this->get_contacts();
		$contacts[ $contact_data['id'] ] = wp_parse_args( $contact_data, $this->get_args() );

		return $this->save_with_reorder( $contacts, 1 );
	}

	function save_with_reorder( $contacts, $with = 0 ) {
		if ( $with ) {
			$loop = 1;
			foreach ( $contacts as $key => $value ) {
				$contacts[ $key ]['order'] = $loop;
				++$loop;
			}
		}
		return $this->save_data( $this->table, $this->sanitize_value_data( $contacts ) );
	}

	function delete( $id = null ) {
		$contacts = parent::get_all( $this->table );
		if ( $contacts ) {
			if ( count( $contacts ) > 0 ) {
				unset( $contacts[ $id ] );
				return $this->save_with_reorder( $contacts, 1 );
			}
		}
		return false;
	}

	function settings_sanitize( $settings ) {

		if ( isset( $settings['contacts'] ) ) {
			if ( count( $settings['contacts'] ) ) {
				foreach ( $settings['contacts'] as $id => $c ) {
					$settings['contacts'][ $id ]['id']        = $id;
					$settings['contacts'][ $id ]['auto_open'] = $settings['contacts'][ $id ]['auto_open'];
					$settings['contacts'][ $id ]['chat']      = (bool) $settings['contacts'][ $id ]['chat'];
					$settings['contacts'][ $id ]['avatar']    = sanitize_text_field( $settings['contacts'][ $id ]['avatar'] );
					// $settings['contacts'][$id]['phone'] = sanitize_text_field($settings['contacts'][$id]['phone']);
					$settings['contacts'][ $id ]['firstname'] = sanitize_text_field( $settings['contacts'][ $id ]['firstname'] );
					$settings['contacts'][ $id ]['lastname']  = sanitize_text_field( $settings['contacts'][ $id ]['lastname'] );
					$settings['contacts'][ $id ]['label']     = sanitize_text_field( $settings['contacts'][ $id ]['label'] );
					// $settings['contacts'][$id]['message'] = wp_kses_post($settings['contacts'][$id]['message']);
					$settings['contacts'][ $id ]['timeto'] = wp_kses_post( $settings['contacts'][ $id ]['timeto'] );
					// $settings['contacts'][$id]['phone'] = qltgm_format_phone($settings['contacts'][$id]['phone']);
					$settings['contacts'][ $id ]['username'] = sanitize_text_field( $settings['contacts'][ $id ]['username'] );
					$settings['contacts'][ $id ]['timefrom'] = qltgm_format_phone( $settings['contacts'][ $id ]['timefrom'] );
					$settings['contacts'][ $id ]['timedays'] = $settings['contacts'][ $id ]['timedays'];
				}
			}
		}
		return $settings;
	}

	function sanitize_value_data( $contacts, $args = null ) {
		foreach ( $contacts as $key => $contact ) {
			$contacts[ $key ] = parent::sanitize_value_data( $contact, $this->get_args() );
		}
		return $contacts;
	}

	function get_contact( $id ) {
		$contacts  = $this->get_contacts();
		$parent_id = @max( array_keys( array_column( $contacts, 'id' ), $id ) );
		return array_replace_recursive( $this->get_args(), $contacts[ $id ] );
	}
	function get_contacts() {
		$result = parent::get_all( $this->table );
		if ( $result === null || count( $result ) === 0 ) {
			$default          = array();
			$default[0]       = $this->get_args();
			$default[0]['id'] = 0;
			$result           = $default;
		} else {
			foreach ( $result as $id => $c ) {
				$result[ $id ] = wp_parse_args( $c, $this->get_args() );
			}
		}
		return $result;
	}

	function order_contact( $a, $b ) {

		if ( ! isset( $a['order'] ) || ! isset( $b['order'] ) ) {
			return 0;
		}

		if ( $a['order'] == $b['order'] ) {
			return 0;
		}

		return ( $a['order'] < $b['order'] ) ? -1 : 1;
	}

	function get_contacts_reorder() {
		$contacts = $this->get_contacts();
		uasort( $contacts, array( $this, 'order_contact' ) );
		return $contacts;
	}
}
