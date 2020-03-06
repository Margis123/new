<?php
/**
 * Main class to interace with the different Content Editors: MS_PAGE_BUILDERS class
 *
 */
if(!class_exists('MS_PAGE_BUILDERS'))
{
	class MS_PAGE_BUILDERS
	{
		private static $_instance;

		private function __construct(){}
		private static function instance()
		{
			if(!isset(self::$_instance)) self::$_instance = new self();
			return self::$_instance;
		} // End instance

		public static function run()
		{
			$instance = self::instance();
			add_action('init', array($instance, 'init'));
			add_action('after_setup_theme', array($instance, 'after_setup_theme'));
		}

		public static function init()
		{
			$instance = self::instance();

			// Gutenberg
			add_action( 'enqueue_block_editor_assets', array($instance,'gutenberg_editor' ) );

			// Elementor
			add_action( 'elementor/widgets/widgets_registered', array($instance, 'elementor_editor') );
			add_action( 'elementor/elements/categories_registered', array($instance, 'elementor_editor_category') );

			// Beaver builder
			if(class_exists('FLBuilder'))
			{
				include_once dirname(__FILE__).'/beaverbuilder/ms.inc.php';
			}
		}

		public function after_setup_theme()
		{
			$instance = self::instance();

			// SiteOrigin
			add_filter('siteorigin_widgets_widget_folders', array($instance, 'siteorigin_widgets_collection'));
			add_filter('siteorigin_panels_widget_dialog_tabs', array($instance, 'siteorigin_panels_widget_dialog_tabs'));
		} // End after_setup_theme

		/**************************** GUTENBERG ****************************/

		/**
		 * Loads the javascript resources to integrate the plugin with the Gutenberg editor
		 */
		public function gutenberg_editor()
		{
			global $wpdb;

			$plugin_url = plugin_dir_url(__FILE__);
			wp_enqueue_style('ms-admin-gutenberg-editor-css', $plugin_url.'gutenberg/gutenberg.css');

			$url = MS_H_URL;
			$url .= ((strpos($url, '?') === false) ? '?' : '&').'ms-preview=';
			$config = array(
				'url' => $url,
				'products_type' => array(
					'all' 			=> __('All', MS_TEXT_DOMAIN),
					'collections' 	=> __('Collections', MS_TEXT_DOMAIN),
					'singles' 		=> __('Singles', MS_TEXT_DOMAIN)
				),
				'list_types'	=> array(
					'new_products' 	=> __('New products', MS_TEXT_DOMAIN),
					'top_rated'		=> __('Top rated products', MS_TEXT_DOMAIN),
					'top_selling'	=> __('Most sold products', MS_TEXT_DOMAIN)
				),
				'layout' => array(
					'store' => strip_tags(__('Like in the store\'s page', MS_TEXT_DOMAIN)),
					'single' => strip_tags(__('Like in the product\'s page', MS_TEXT_DOMAIN)),
				),
				'numbers_styles' => array(
					'alt_digits' => $plugin_url.'../ms-core/images/counter/alt_digits/',
					'digits' 	 => $plugin_url.'../ms-core/images/counter/digits/'
				),
				'labels' => array(
					'products_type'=> __('Product type', MS_TEXT_DOMAIN),
					'product' => __('Enter the product\'s id', MS_TEXT_DOMAIN),
					'number_of_products' => __('Enter the number of products', MS_TEXT_DOMAIN),
					'product_required' => __('The product\'s id is required.'),
					'layout'  => __('Select the product\'s layout', MS_TEXT_DOMAIN),
					'columns' => __('Number of columns', MS_TEXT_DOMAIN),
					'genres'  => __('Genres', MS_TEXT_DOMAIN),
					'artists' => __('Artists', MS_TEXT_DOMAIN),
					'albums'  => __('Albums', MS_TEXT_DOMAIN),
					'numbers_styles' => __('Numbers styles', MS_TEXT_DOMAIN),
					'number_of_digits' => __('Digits', MS_TEXT_DOMAIN),
					'list_types' => __('List the products', MS_TEXT_DOMAIN),
					'exclude' => __('Enter the id of products to exclude', MS_TEXT_DOMAIN)
				),
				'help' => array(
					'products_type' => __('Select the products type include in the store.', MS_TEXT_DOMAIN),
					'product' => __('Enter the id of a published product.', MS_TEXT_DOMAIN),
					'number_of_products' => __('Number of products to load. Three products by default.', MS_TEXT_DOMAIN),
					'layout'  => __('Appearance applied to the product.', MS_TEXT_DOMAIN),
					'columns' => __('Enter the number of columns, one column by default.', MS_TEXT_DOMAIN),
					'genres'  => __('Enter the genres\' ids or slugs separated by comma to restrict the store\'s products to these genres. All genres by default.', MS_TEXT_DOMAIN),
					'artists'  => __('Enter the artists\' ids or slugs separated by comma to restrict the store\'s products to these artists. All artists by default.', MS_TEXT_DOMAIN),
					'albums'  => __('Enter the albums\' ids or slugs separated by comma to restrict the store\'s products to these albums. All albums by default.', MS_TEXT_DOMAIN),
					'numbers_styles' => __('Select the number styles', MS_TEXT_DOMAIN),
					'number_of_digits' => __('Number of digits in the counter, default 3.', MS_TEXT_DOMAIN),
					'list_types' => __('Products to include in the list.', MS_TEXT_DOMAIN),
					'exclude' => __('Enter the id of products to exclude from the store, separated by comma.', MS_TEXT_DOMAIN)
				)
			);

			wp_enqueue_script('ms-admin-gutenberg-editor', $plugin_url.'gutenberg/gutenberg.js', array( 'jquery' ));
			wp_localize_script('ms-admin-gutenberg-editor', 'ms_ge_config', $config);
		} // End gutenberg_editor

		/**************************** ELEMENTOR ****************************/

		public function elementor_editor_category()
		{
			require_once dirname(__FILE__).'/elementor/elementor-category.pb.php';
		} // End elementor_editor

		public function elementor_editor()
		{
			wp_enqueue_style('ms-admin-elementor-editor-css', plugin_dir_url(__FILE__).'elementor/elementor.css');
			require_once dirname(__FILE__).'/elementor/elementor.pb.php';
		} // End elementor_editor

		/**************************** SITEORIGIN ****************************/

		public function siteorigin_widgets_collection($folders)
		{
			$folders[] = dirname(__FILE__).'/siteorigin/';
			return $folders;
		} // End siteorigin_widgets_collection

		public function siteorigin_panels_widget_dialog_tabs($tabs)
		{
			$tabs[] = array(
				'title' => __('Music Store', MS_TEXT_DOMAIN),
				'filter' => array(
					'groups' => array('music-store')
				)
			);

			return $tabs;
		} // End siteorigin_panels_widget_dialog_tabs
	} // End MS_PAGE_BUILDERS
}