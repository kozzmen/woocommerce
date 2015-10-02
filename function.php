<?php

// allow BGN for WooCommerce and PayPal
add_filter( 'woocommerce_currencies', 'add_bgn_currency' );

function add_bgn_currency( $currencies ) {
 $currencies['BGN'] = __( 'Bulgarian Lev (лв.)', 'woocommerce' );
 return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_bgn_currency_symbol', 10, 2);

function add_bgn_currency_symbol( $currency_symbol, $currency ) {
 switch( $currency ) {
 case 'BGN': $currency_symbol = 'лв.'; break;
 }
 return $currency_symbol;
}

add_filter( 'woocommerce_paypal_supported_currencies', 'add_bgn_paypal_valid_currency' );     
    function add_bgn_paypal_valid_currency( $currencies ) {  
     array_push ( $currencies , 'BGN' );
     return $currencies;  
    } 

// Convert BGN to EUR for PayPal payments
add_filter('woocommerce_paypal_args', 'convert_bgn_to_eur');
function convert_bgn_to_eur($paypal_args){
	if ( $paypal_args['currency_code'] == 'BGN'){
		$convert_rate = 1.955; //set the converting rate
		$paypal_args['currency_code'] = 'EUR'; //change BGN to EUR
		$i = 1;

		while (isset($paypal_args['amount_' . $i])) {
			$paypal_args['amount_' . $i] = round( $paypal_args['amount_' . $i] / $convert_rate, 2);
			++$i;
		}

	}
return $paypal_args;
}
