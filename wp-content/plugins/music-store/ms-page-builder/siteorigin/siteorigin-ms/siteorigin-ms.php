<?php
/*
Widget Name: Music Store
Description: Inserts the Music Store shortcode.
Documentation: https://musicstore.dwbooster.com/documentation#music-store-shortcode
*/

class SiteOrigin_MusicStore extends SiteOrigin_Widget
{
	function __construct()
	{
		parent::__construct(
			'siteorigin-music-store',
			__('Music Store', MS_TEXT_DOMAIN),
			array(
				'description' 	=> __('Inserts the Music Store shortcode', MS_TEXT_DOMAIN),
				'panels_groups' => array('music-store'),
				'help'        	=> 'https://musicstore.dwbooster.com/documentation#music-store-shortcode'
			),
			array(),
			array(
				'product_type' => array(
					'type' 		=> 'select',
					'label' 	=> __( 'Product Type', MS_TEXT_DOMAIN ),
					'options' => array(
						'all' 			=> __('All', MS_TEXT_DOMAIN),
						'collections' 	=> __('Collections', MS_TEXT_DOMAIN),
						'singles' 		=> __('Singles', MS_TEXT_DOMAIN)
					),
					'default'	=> 'all',
				),
				'exclude' => array(
					'type' 		=> 'text',
					'label'		=> __('Enter the id of products to exclude', MS_TEXT_DOMAIN)
				),
				'columns' => array(
					'type' 		=> 'number',
					'label'		=> __('Number of columns', MS_TEXT_DOMAIN),
					'default'	=> 2
				),
				'genres' => array(
					'type' 		=> 'text',
					'label' 	=> __( "Enter the genres' ids or slugs separated by comma to restrict the store's products to these genres. All genres by default.", MS_TEXT_DOMAIN ),
				),
				'artists' => array(
					'type' 		=> 'text',
					'label' 	=> __( "Enter the artists' ids or slugs separated by comma to restrict the store's products to these artists. All artists by default.", MS_TEXT_DOMAIN )
				),
				'albums' => array(
					'type' 		=> 'text',
					'label' 	=> __( "Enter the albums' ids or slugs separated by comma to restrict the store's products to these albums. All albums by default.", MS_TEXT_DOMAIN )
				)
			),
			plugin_dir_path(__FILE__)
		);
	} // End __construct

	function get_template_name($instance)
	{
		return 'siteorigin-ms-shortcode';
    } // End get_template_name

    function get_style_name($instance)
	{
        return '';
    } // End get_style_name

} // End Class SiteOrigin_MusicStore

// Registering the widget
siteorigin_widget_register('siteorigin-music-store', __FILE__, 'SiteOrigin_MusicStore');