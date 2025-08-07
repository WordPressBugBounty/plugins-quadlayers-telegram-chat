<?php

if ( class_exists( 'QuadLayers\\WP_Plugin_Table_Links\\Load' ) ) {
	add_action('init', function() {
		new \QuadLayers\WP_Plugin_Table_Links\Load(
			QLTGM_PLUGIN_FILE,
			array(
				array(
					'text' => esc_html__( 'Settings', 'quadlayers-telegram-chat' ),
					'url'  => admin_url( 'admin.php?page=qltgm' ),
					'target'=> '_self',
				),
				array(
					'text' => esc_html__( 'Premium', 'quadlayers-telegram-chat' ),
					'url'  => 'https://quadlayers.com/products/telegram-chat/?utm_source=qltgm_plugin&utm_medium=plugin_table&utm_campaign=premium_upgrade&utm_content=premium_link',
					'color' => 'green',
					'target' => '_blank',
				),
				array(
					'place' => 'row_meta',
					'text'  => esc_html__( 'Support', 'quadlayers-telegram-chat' ),
					'url'   => 'https://quadlayers.com/account/support/?utm_source=qltgm_plugin&utm_medium=plugin_table&utm_campaign=support&utm_content=support_link',
				),
				array(
					'place' => 'row_meta',
					'text'  => esc_html__( 'Documentation', 'quadlayers-telegram-chat' ),
					'url'   => 'https://quadlayers.com/documentation/telegram-chat/?utm_source=qltgm_plugin&utm_medium=plugin_table&utm_campaign=documentation&utm_content=documentation_link',
				),
			)
		);
	});

}
