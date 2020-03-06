<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Music_Store_Widget extends Widget_Base
{
	public function get_name()
	{
		return 'music-store';
	} // End get_name

	public function get_title()
	{
		return 'Music Store';
	} // End get_title

	public function get_icon()
	{
		return 'fa fa-shopping-cart';
	} // End get_icon

	public function get_categories()
	{
		return array( 'music-store-cat' );
	} // End get_categories

	public function is_reload_preview_required()
	{
		return true;
	} // End is_reload_preview_required

	protected function _register_controls()
	{
		$this->start_controls_section(
			'ms_section',
			array(
				'label' => __( 'Music Store', MS_TEXT_DOMAIN )
			)
		);

		$this->add_control(
			'product_type',
			array(
				'label' =>  __('Product type', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'all' 			=> __('All', MS_TEXT_DOMAIN),
					'collections' 	=> __('Collections', MS_TEXT_DOMAIN),
					'singles' 		=> __('Singles', MS_TEXT_DOMAIN)
				),
				'default'	  => 'all',
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( 'Select the products type include in the store.', MS_TEXT_DOMAIN ).'</i>'
			)
		);

		$this->add_control(
			'exclude',
			array(
				'label' =>  __('Enter the id of products to exclude', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,
				'default'	  => '',
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( 'Enter the id of products to exclude from the store, separated by comma.', MS_TEXT_DOMAIN ).'</i>'
			)
		);

		$this->add_control(
			'columns',
			array(
				'label' =>  __('Number of columns', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::NUMBER,
				'default'	  => 2,
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( 'Enter the number of columns, one column by default.', MS_TEXT_DOMAIN ).'</i>'
			)
		);

		$this->add_control(
			'genres',
			array(
				'label' =>  __('Genres', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( "Enter the genres' ids or slugs separated by comma to restrict the store's products to these genres. All genres by default.", MS_TEXT_DOMAIN ).'</i>'
			)
		);

		$this->add_control(
			'artists',
			array(
				'label' =>  __('Artists', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( "Enter the artists' ids or slugs separated by comma to restrict the store's products to these artists. All artists by default.", MS_TEXT_DOMAIN ).'</i>'
			)
		);

		$this->add_control(
			'albums',
			array(
				'label' =>  __('Albums', MS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,
				'classes'	  => 'ms-widefat',
				'description' => '<i>'.__( "Enter the albums' ids or slugs separated by comma to restrict the store's products to these albums. All albums by default.", MS_TEXT_DOMAIN ).'</i>'
			)
		);


		$this->end_controls_section();
	} // End _register_controls

	private function _get_shortcode()
	{
		$attr 		= '';
		$settings 	= $this->get_settings_for_display();

		$product_type 	= sanitize_text_field($settings['product_type']);
		if(!empty($product_type)) $attr .= ' load="'.esc_attr($product_type).'"';

		$exclude 	= trim($settings['exclude']);
		$exclude	= preg_replace('/[^\d\,]/', '', $exclude);
		$exclude	= trim($exclude, ',');
		if(!empty($exclude)) $attr .= ' exclude="'.esc_attr($exclude).'"';

		$columns 	= trim($settings['columns']);
		$columns	= max(1,@intval($columns));
		if(!empty($columns)) $attr .= ' columns="'.esc_attr($columns).'"';

		$genres = sanitize_text_field($settings['genres']);
		if(!empty($genres)) $attr .= ' genre="'.esc_attr($genres).'"';

		$artists = sanitize_text_field($settings['artists']);
		if(!empty($artists)) $attr .= ' artist="'.esc_attr($artists).'"';

		$albums = sanitize_text_field($settings['albums']);
		if(!empty($albums)) $attr .= ' album="'.esc_attr($albums).'"';

		return '[music_store'.$attr.']';
	} // End _get_shortcode

	protected function render()
	{
		$shortcode = $this->_get_shortcode();
		if(
			isset($_REQUEST['action']) &&
			(
				$_REQUEST['action'] == 'elementor' ||
				$_REQUEST['action'] == 'elementor_ajax'
			)
		)
		{
			$url = MS_H_URL;
			$url .= ((strpos($url, '?') === false) ? '?' : '&').'ms-preview='.urlencode($shortcode);
			?>
			<div class="ms-iframe-container" style="position:relative;">
				<div class="ms-iframe-overlay" style="position:absolute;top:0;right:0;bottom:0;left:0;"></div>
				<iframe height="0" width="100%" src="<?php print $url; ?>" scrolling="no">
			</div>
			<?php
		}
		else
		{
			print do_shortcode(shortcode_unautop($shortcode));
		}

	} // End render

	public function render_plain_content()
	{
		echo $this->_get_shortcode();
	} // End render_plain_content

	protected function _content_template() {} // End _content_template
} // End Elementor_Music_Store_Widget


// Register the widgets
Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Music_Store_Widget );