<?php
/*
 * Plugin Name: WooCommerce Images Product Tab
 * Plugin URI: https://code.recuweb.com/download/woocommerce-images-product-tab/
 * Description: Extends WooCommerce to allow you to display all images attached to a product in a new tab on the single product page.
 * Version: 3.0.5
 * Author: Rafasashi
 * Author URI: https://code.recuweb.com/about-us/
 * Requires at least: 4.6
 * Tested up to: 5.6
 *
 * Text Domain: wc-images-product-tab
 * Domain Path: /lang/
 * 
 * Copyright: © 2018 Recuweb.
 * License: GNU General Public License v3.0
 * License URI: https://code.recuweb.com/product-licenses/
 */

	if(!defined('ABSPATH')) exit; // Exit if accessed directly
 
	/**
	* Minimum version required
	*
	*/
	if ( get_bloginfo('version') < 3.3 ) return;
	
	// Checks if the WooCommerce plugins is installed and active.
	
	$plugins = apply_filters('active_plugins', get_option('active_plugins'));
	
	if(in_array('woocommerce/woocommerce.php', $plugins)){
		
		if(!in_array('woo-images-product-tab-premium/woocommerce-images-product-tab-premium.php', $plugins)){
			
			// Load plugin class files
			require_once( 'includes/class-woocommerce-images-product-tab.php' );
			require_once( 'includes/class-woocommerce-images-product-tab-settings.php' );
			
			// Load plugin libraries
			require_once( 'includes/lib/class-woocommerce-images-product-tab-admin-api.php' );
			require_once( 'includes/lib/class-woocommerce-images-product-tab-admin-notices.php' );
			require_once( 'includes/lib/class-woocommerce-images-product-tab-post-type.php' );
			require_once( 'includes/lib/class-woocommerce-images-product-tab-taxonomy.php' );		
			
			/**
			 * Returns the main instance of WooCommerce_Images_Product_Tab to prevent the need to use globals.
			 *
			 * @since  1.0.0
			 * @return object WooCommerce_Images_Product_Tab
			 */
			function WooCommerce_Images_Product_Tab() {
						
				$instance = WooCommerce_Images_Product_Tab::instance( __FILE__, '1.0.0' );	
				
				if ( is_null( $instance->notices ) ) {
					
					$instance->notices = WooCommerce_Images_Product_Tab_Admin_Notices::instance( $instance );
				}
				
				if ( is_null( $instance->settings ) ) {
					
					$instance->settings = WooCommerce_Images_Product_Tab_Settings::instance( $instance );
				}

				return $instance;
			}	

			WooCommerce_Images_Product_Tab();
		}
	}
	else{
		
		add_action('admin_notices', function(){
			
			global $current_screen;
			
			if( $current_screen->parent_base == 'plugins' ){
				
				echo '<div class="error"><p>WooCommerce Images Product Tab '.__('requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="'.admin_url('plugin-install.php?tab=search&type=term&s=WooCommerce').'" target="_blank">WooCommerce</a> first.', 'wc-images-product-tab').'</p></div>';
			}
		});
	}
