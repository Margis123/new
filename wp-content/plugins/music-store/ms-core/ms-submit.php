<?php
	if( !defined( 'MS_H_URL' ) ) { echo 'Direct access not allowed.';  exit; }

	global $music_store_settings;

	function ms_make_seed()
	{
		list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 100000);
	}


	if(isset($_POST['ms_product_id']) && isset($_POST['ms_product_type']))
	{
		$obj = new MSSong(@intval($_POST['ms_product_id']));
		if(isset($obj->ID)) // Check object existence
		{
			$amount = apply_filters('musicstore_final_price', $obj->price);
			if($amount > 0) // Check for a valid amount
			{
				mt_srand(ms_make_seed());
				$randval = mt_rand(1,999999);
				$purchase_id = md5($randval.uniqid('', true));

				$baseurl = MS_H_URL.'?ms-action=ipn';
				$returnurl = $GLOBALS['music_store']->_ms_create_pages( 'ms-download-page', 'Download Page' );
				$returnurl .= ( ( strpos( $returnurl, '?' ) === false ) ? '?' : '&' ).'ms-action=download';
				if(
					preg_match( '/^(http(s)?:\/\/[^\/\n]*)/i', MS_H_URL, $matches ) &&
					strpos(@$_SERVER['HTTP_REFERER'], $matches[0])
				)
				{
					$cancelurl = esc_url_raw($_SERVER['HTTP_REFERER']);
				}
				if(empty($cancelurl)) $cancelurl = MS_H_URL;
				$purchase_settings = array(
					'item_name'		=> $obj->post_title,
					'item_number'	=> $obj->ID,
					'id'			=> $purchase_id,
					'products'		=> array($obj),
					'baseurl'		=> $baseurl,
					'returnurl'		=> $returnurl,
					'cancelurl'		=> $cancelurl
				);
				do_action(
					'musicstore_calling_payment_gateway',
					$amount,
					$purchase_settings
				);
				exit;
			}
			else  // End amount == 0
			{
				$_SESSION[ 'download_for_free' ] = array();

				// Check if it is a registered user
				$current_user = wp_get_current_user();
				$current_user_email = '';
				if( $current_user->ID !== 0 )
				{
					$current_user_email = $current_user->user_email;
				}
				else
				{
					$current_user_email = ms_getIP();
					$current_user_email = str_replace( '_', '.', $current_user_email );
				}

				$_SESSION[ 'download_for_free' ][] = $purchase_id;
				music_store_register_purchase( $obj->ID, $purchase_id, $current_user_email, 0, '');
				header('location: '.esc_url_raw($returnurl.'&purchase_id='.$purchase_id));
				exit;
			}
		} // End if saler and object
	} // End if parameters

	header('location: '.$cancelurl);
?>