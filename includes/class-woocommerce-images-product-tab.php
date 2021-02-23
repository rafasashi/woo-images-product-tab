<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WooCommerce_Images_Product_Tab {

	/**
	 * The single instance of WooCommerce_Images_Product_Tab.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;
	
	public $_dev = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */

	public $notices = null;
	public $settings = null;
	public $woo_settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;
	public $views;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */

	public static $plugin_prefix;
	public static $plugin_url;
	public static $plugin_path;
	public static $plugin_basefile;

	private $tab_data = false;
	
	public $title 		= 'Images';
	public $lightbox 	= 'no';
	public $size 		= 'thumbnail';
	public $priority 	= 10;
	 
	public function __construct ( $file = '', $version = '1.0.0' ) {

		$this->_version = $version;
		$this->_token = 'woocommerce-images-product-tab';
		$this->_base = 'wipt_';
		
		$this->premium_url = 'https://code.recuweb.com/download/woocommerce-images-product-tab/';

		// Load plugin environment variables
		$this->file 		= $file;
		$this->dir 			= dirname( $this->file );
		$this->views   		= trailingslashit( $this->dir ) . 'views';
		$this->assets_dir 	= trailingslashit( $this->dir ) . 'assets';
		$this->assets_url 	= home_url( trailingslashit( str_replace( ABSPATH, '', $this->dir ))  . 'assets/' );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		WooCommerce_Images_Product_Tab::$plugin_prefix = $this->_base;
		WooCommerce_Images_Product_Tab::$plugin_basefile = $this->file;
		WooCommerce_Images_Product_Tab::$plugin_url = plugin_dir_url($this->file); 
		WooCommerce_Images_Product_Tab::$plugin_path = trailingslashit($this->dir);

		// register plugin activation hook
		
		//register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin JS & CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

		// Load API for generic admin functions
		
		if ( is_admin() ) {
			
			$this->admin = new WooCommerce_Images_Product_Tab_Admin_API($this);
		}
		
		$this->title = 'Images';
		
		$this->lightbox = 'yes';
		
		$this->size = 'thumbnail';
		
		$this->priority = 10;	

		/* Localisation */
		
		$locale = apply_filters('plugin_locale', get_locale(), 'woocommerce-images-product-tab');
		load_textdomain('wc_images_product_tab', WP_PLUGIN_DIR . "/".plugin_basename(dirname(__FILE__)).'/lang/wc_images_product_tab-'.$locale.'.mo');
		load_plugin_textdomain('wc_images_product_tab', false, dirname(plugin_basename(__FILE__)).'/lang/');
		
		add_action('woocommerce_init', array($this, 'init'));
		
		add_filter('woocommerce_get_sections_products',function($sections){
			
			$sections['rew-tabs'] = __( 'Tabs', 'woocommerce' );
			
			return $sections;
			
		},10,1);
			
		add_filter('woocommerce_product_settings', function( $settings ){
			
			global $current_section;

			if( $current_section == 'rew-tabs' ){
				
				return array();
			}
			
			return $settings;
			
		},9999999999);
		
		$this->woo_settings = array(
			
			array(
			
				'name' 	=> __( 'Product Images Tab', 'wc_images_product_tab' ),
				'type' 	=> 'title',
				'desc' 	=> '',
				'id' 	=> 'images_product_tab'
			),
			array(  
				'name' => __('Tab Name', 'wc_images_product_tab'),
				'desc' 		=> __('The name of the tab in the product page', 'wc_images_product_tab'),
				'id' 		=> 'woocommerce_product_images_tab_title',
				'type' 		=> 'text',
				'default'	=> __('Images', 'wc_images_product_tab'),
			),
			array(  
				'name' => __('Tab Position', 'wc_images_product_tab'),
				'desc' 		=> __('The position of the tab in the list', 'wc_images_product_tab'),
				'id' 		=> 'woocommerce_product_images_tab_priority',
				'type' 		=> 'number',
				'default'	=> 10,
			),
			array(  
				
				'name' => __('Size of Images', 'wc_images_product_tab'),
				'desc' 		=> __('What size would you like to display ?', 'wc_images_product_tab'),
				'id' 		=> 'woocommerce_product_images_tab_size',
				'type' 		=> 'select',
				'options'	=> array(
						'thumbnail' => __('Thumbnail', 'wc_images_product_tab'),
						'medium'	=> __('Medium', 'wc_images_product_tab'),
						'large'	=> __('Large', 'wc_images_product_tab'),
						'full'	=> __('Full / Original', 'wc_images_product_tab'),
					),
				'default'	=> 'thumbnail',
			),
			array(  
				'name' => __('Enable Lightbox', 'wc_images_product_tab'),
				'desc' 		=> __('Enable Lightbox for images in the tab', 'wc_images_product_tab'),
				'id' 		=> 'woocommerce_product_images_tab_lightbox',
				'type' 		=> 'checkbox',
				'default' 	=> 'yes',
			),
			array(
				'type' => 'sectionend',
				'id' => 'images_product_tab'
			),
		);		
		
	} // End __construct ()

	/**
	 * Init WooCommerce Images Product Tab extension once we know WooCommerce is active
	 */
	public function init(){
		
		// backend stuff
		add_filter('plugin_row_meta', array($this, 'add_support_link'), 10, 2);
		
		// frontend stuff
		
		if(version_compare(WOOCOMMERCE_VERSION, "2.0", '>=')){
			
			// WC >= 2.0
			
			add_filter('woocommerce_product_tabs', array($this, 'images_product_tabs_2_0'));
		}
		else{
			
			add_action('woocommerce_product_tabs', array($this, 'images_product_tabs'), 25.5);
			add_action('woocommerce_product_tab_panels', array($this, 'images_product_tabs_panel'), 25.5);
		}
	}

	/**
	 * Add links to plugin page.
	 */
	public function add_support_link($links, $file){
		
		if(!current_user_can('install_plugins')){
			
			return $links;
		}
		
		if($file == WooCommerce_Images_Product_Tab::$plugin_basefile){
			
			$links[] = '<a href="https://code.recuweb.com" target="_blank">'.__('Docs', 'wc_images_product_tab').'</a>';
		}
		
		return $links;
	}

	/**
	 * Write the images tab on the product view page for WC 2.0+.
	 * In WooCommerce these are handled by templates.
	 */
	public function images_product_tabs_2_0($tabs){
		
		global $post, $wpdb, $product;
		
		$attachment_ids = $product->get_gallery_image_ids();

		/**
		 * Checks if any images are attached to the product
		 * and the tab has not been disabled.
		 */
		$countImages = count($attachment_ids);
		
		$disabled = 'no';
		
		if($countImages > 0 && $disabled != 'yes'){

			$tabs['images'] = array(
			
				'title'    => __($this->title, 'wc_images_product_tab').' ('.$countImages.')',
				'priority' => $this->priority,
				'callback' => array($this, 'images_product_tabs_panel_content')
			);
		}
		return $tabs;
	}

	/**
	 * Write the images tab on the product view page for WC 1.6.6 and below.
	 * In WooCommerce these are handled by templates.
	 */
	public function images_product_tabs(){
		
		global $post, $wpdb, $product;
		
		$attachment_ids = $product->get_gallery_image_ids();

		/**
		 * Checks if any images are attached to the product
		 * and the tab has not been disabled.
		 */
		$countImages = count($attachment_ids);
		
		$disabled = 'no';
		
		if($countImages > 0 && $disabled != 'yes'){
			
			echo "<li class=\"gallery\"><a href=\"#tab-images\">".__($this->title, 'wc_images_product_tab')." (".$countImages.")</a></li>";
		}
	}

	/**
	 * Write the video tab panel on the product view page WC 2.0+.
	 * In WooCommerce these are handled by templates.
	 */
	public function images_product_tabs_panel_content(){
		
		global $post, $wpdb;

		$content = $this->images_product_tabs_panel();

		return $content;
	}

	/**
	 * Write the images tab panel on the product view page.
	 * In WooCommerce these are handled by templates.
	 */
	public function images_product_tabs_panel(){
		
		global $post, $wpdb, $product;
		
		$attachment_ids = $product->get_gallery_image_ids();	

		/**
		 * Checks if any images are attached to the product.
		 */
		$countImages = count($attachment_ids);
		
		$disabled = 'no';
		
		if($countImages > 0 && $disabled != 'yes'){
			
			if(version_compare(WOOCOMMERCE_VERSION, "2.0", '<')){ 
			
				echo '<div class="panel entry-content" id="tab-images">'; 
			}
			
			echo '<h2>' . __($this->title, 'wc_images_product_tab') . '</h2>';
			
			echo '<ul id="wipt_images">';
				
				foreach( $attachment_ids as $attachment_id ){

					$images_attr = array(
					
						'class'	=> "product-images images-attachment-".$attachment_id."",
						'alt'   => trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
					);
					
					echo '<li>';
					
						echo '<a href="'.wp_get_attachment_url($attachment_id).'" rel="thumbnails" class="zoom">';
						
							echo wp_get_attachment_image($attachment_id, $this->size, false, $images_attr);
						
						echo '</a>';
						
					echo '</li>';
				}
				
			echo '</ul>';

			if(version_compare(WOOCOMMERCE_VERSION, "2.0", '<')){ 
			
				echo '</div>'; 
			}
		}
	}

	// Adds the option to disable the images tab on the product page.
	
	function images_tab_panel_product_options(){
		
		echo '<div class="options_group">';
			
			woocommerce_wp_checkbox( array( 'id' => 'woocommerce_disable_product_images', 'label' => __('Disable images tab?', 'wc_images_product_tab') ) );
		
		echo '</div>';
	}

	function images_tab_panel_product_options_save($post_id){
		
		$woocommerce_disable_product_images = isset($_POST['woocommerce_disable_product_images']) ? 'yes' : 'no';
		
		update_post_meta($post_id, 'woocommerce_disable_product_images', $woocommerce_disable_product_images);
	}

	/**
	 * Wrapper function to register a new post type
	 * @param  string $post_type   Post type name
	 * @param  string $plural      Post type item plural name
	 * @param  string $single      Post type item single name
	 * @param  string $description Description of post type
	 * @return object              Post type class object
	 */
	public function register_post_type ( $post_type = '', $plural = '', $single = '', $description = '', $options = array() ) {

		if ( ! $post_type || ! $plural || ! $single ) return;

		$post_type = new WooCommerce_Images_Product_Tab_Post_Type( $post_type, $plural, $single, $description, $options );

		return $post_type;
	}

	/**
	 * Wrapper function to register a new taxonomy
	 * @param  string $taxonomy   Taxonomy name
	 * @param  string $plural     Taxonomy single name
	 * @param  string $single     Taxonomy plural name
	 * @param  array  $post_types Post types to which this taxonomy applies
	 * @return object             Taxonomy class object
	 */
	public function register_taxonomy ( $taxonomy = '', $plural = '', $single = '', $post_types = array(), $taxonomy_args = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) return;

		$taxonomy = new WooCommerce_Images_Product_Tab_Taxonomy( $taxonomy, $plural, $single, $post_types, $taxonomy_args );

		return $taxonomy;
	}
	
	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		
		if( is_product() ){
			
			wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
			wp_enqueue_style( $this->_token . '-frontend' );		
		}
		
	} // End enqueue_styles ()

	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {

		
		
	} // End enqueue_scripts ()

	/**
	 * Load admin CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_styles ( $hook = '' ) {
		
		//wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
		//wp_enqueue_style( $this->_token . '-admin' );
		
		if( isset($_GET['page']) && $_GET['page'] == 'woocommerce-images-product-tab' ){
		
			wp_register_style( $this->_token . '-simpleLightbox', esc_url( $this->assets_url ) . 'css/simpleLightbox.min.css', array(), $this->_version );
			wp_enqueue_style( $this->_token . '-simpleLightbox' );
		}		
		
	} // End admin_enqueue_styles ()

	/**
	 * Load admin Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_scripts ( $hook = '' ) {
		
		if( isset($_GET['page']) && $_GET['page'] == 'woocommerce-images-product-tab' ){
		
			wp_register_script( $this->_token . '-simpleLightbox', esc_url( $this->assets_url ) . 'js/simpleLightbox.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-simpleLightbox' );
		
			wp_register_script( $this->_token . '-lightbox-admin', esc_url( $this->assets_url ) . 'js/lightbox-admin.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-lightbox-admin' );			
		}		

	} // End admin_enqueue_scripts ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'woocommerce-images-product-tab', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
		
	    $domain = 'woocommerce-images-product-tab';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()
	
	/**
	 * Main WooCommerce_Images_Product_Tab Instance
	 *
	 * Ensures only one instance of WooCommerce_Images_Product_Tab is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WooCommerce_Images_Product_Tab()
	 * @return Main WooCommerce_Images_Product_Tab instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		
		if ( is_null( self::$_instance ) ) {
			
			self::$_instance = new self( $file, $version );
		}
		
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()
}
