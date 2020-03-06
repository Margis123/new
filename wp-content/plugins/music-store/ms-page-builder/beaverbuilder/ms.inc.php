<?php
require_once dirname(__FILE__).'/ms/ms.pb.php';

FLBuilder::register_module(
	'CPMSBeaver',
	array(
		'cpms-tab' => array(
			'title'	=> __('Music Store', MS_TEXT_DOMAIN),
			'sections' => array(
				'cpms-section' => array(
					'title' 	=> __('Store\'s Attributes', MS_TEXT_DOMAIN),
					'fields'	=> array(
						'columns' => array(
							'type' 	=> 'text',
							'label' => __('Number of Columns', MS_TEXT_DOMAIN),
							'description'	=> __('Number of columns to distribute the products in the store\'s pages', MS_TEXT_DOMAIN)
						),
						'attributes' => array(
							'type' 	=> 'text',
							'label' => __('Additional attributes', MS_TEXT_DOMAIN),
							'description' => '<a href="https://musicstore.dwbooster.com/documentation#music-store-shortcode" target="_blank">'.__('Click here to know the complete list of attributes', MS_TEXT_DOMAIN).'</a>'
						),
					)
				)
			)
		)
	)
);