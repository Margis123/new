<?php
class CPMSBeaver extends FLBuilderModule {
    public function __construct()
    {
		$modules_dir = dirname(__FILE__).'/';
		$modules_url = plugins_url( '/', __FILE__ ).'/';

        parent::__construct(array(
            'name'            => __( 'Music Store',  MS_TEXT_DOMAIN ),
            'description'     => __( 'Insert the store shortcode', MS_TEXT_DOMAIN ),
            'group'           => __( 'Music Store',  MS_TEXT_DOMAIN ),
            'category'        => __( 'Music Store',  MS_TEXT_DOMAIN ),
            'dir'             => $modules_dir,
            'url'             => $modules_url,
            'partial_refresh' => true,
        ));
    }
}