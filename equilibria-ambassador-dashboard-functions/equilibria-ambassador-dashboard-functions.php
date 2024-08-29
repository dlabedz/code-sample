<?php
/**
 * Plugin Name: Equilibria Ambassador Dashbord Functions
 * Plugin URI: https://myeq.com
 * Description: Custom functions for the Ambassador Dashboard
 * Author: Debbie Labedz
 * Version: 1.0
 */


defined( 'ABSPATH' ) or die;

define('EQ_AMBDASH_CALC_TRANSIENT_EXPIRY', 60);

/*Commission Earnings Year to Date -- will refactor this prior to 1/1/21 */

function equilibria_get_ambassador_commission_total_ytd() {
	global $wpdb;

     $affiliate = affwp_get_affiliate_id();

     // creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $affiliate;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $sum = get_transient( $transient_key ) ) ) {

	$sum = $wpdb->get_var($wpdb->prepare(
		"SELECT SUM(amount)
		FROM wp_affiliate_wp_referrals
		WHERE YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')
		AND NOT status='rejected'
		AND affiliate_id = %d",
		$affiliate
    ));

    // save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $sum, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
	}

		return round($sum, 2);
	
}


/**
 * Gets earnings for a given affiliate and range
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 * @param  string  $range         Optional. Can be ytd, mtd, wtd or today.  Defaults to ytd
 *
 * @return bool
 */
function equilibria_get_ambassador_commission_total( $affiliate_id = 0, $range = 'ytd' ) {

	global $wpdb;

	// gets affiliate ID of logged in user if none specified
	if ( $affiliate_id == 0 ) {
		$affiliate_id = affwp_get_affiliate_id();
	}

	$affiliate_id = absint( $affiliate_id );

	// check for valid date range
	$valid_ranges = [ 'ytd', 'mtd', 'wtd', 'today' ];
	if ( ! in_array( $range, $valid_ranges ) ) {
		trigger_error( 'Date range must be one of ' . implode( ',', $valid_ranges ), E_USER_WARNING );
		return false;
	}

	// set our date range sql
	if ( $range == 'mtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND MONTH(CONVERT_TZ(date,'UTC','America/Chicago')) = MONTH(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'wtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND WEEK(CONVERT_TZ(date,'UTC','America/Chicago')) = WEEK(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'today' ) {
		$rangesql = "AND DATE(CONVERT_TZ(date,'UTC','America/Chicago')) = DATE(CONVERT_TZ(NOW(),'UTC','America/Chicago'))";
	}
	// defaults to ytd
	else {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago')) 
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}

	// creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $affiliate_id . '_' . $range;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $sum = get_transient( $transient_key ) ) ) {

		$sum = $wpdb->get_var( $wpdb->prepare(
			"SELECT SUM(amount) as sum
             FROM wp_eq_ambassador_referrals             
             WHERE affiliate_id = %d
			 AND referral_type = 'reg_15-20-30-50'
			 AND NOT referral_status='rejected'
             $rangesql
             ", $affiliate_id
		) );

		// save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $sum, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
    }

	return round($sum, 2);
}

/**
 * Wrapper for YTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_commission_total_ytd_new( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_commission_total( $affiliate_id, 'ytd' );
}

/**
 * Wrapper for MTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_commission_total_mtd( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_commission_total( $affiliate_id, 'mtd' );
}

/**
 * Wrapper for WTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_commission_total_wtd( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_commission_total( $affiliate_id, 'wtd' );
}

/**
 * Wrapper for today
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_commission_total_today(  $affiliate_id = 0 ) {
	return equilibria_get_ambassador_commission_total( $affiliate_id, 'today' );
}


/*Order Totals Year to Date -- will refactor this prior to 1/1/21 */

function equilibria_get_ambassador_order_total_ytd() {
	global $wpdb;


    $affiliate = affwp_get_affiliate_id();

      // creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $affiliate;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $total = get_transient( $transient_key ) ) ) {

        $total = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(amount)
            FROM wp_affiliate_wp_referrals
            WHERE YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
            AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')
			AND NOT status='rejected'
            AND affiliate_id = %d",
            $affiliate
	    ));

		// save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $total, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
	}

	if ( $total == null ) {
		return '0';
	  } else {
		return ($total);
	  }
}


/**
 * Gets total # of orders for a given affiliate and range
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 * @param  string  $range         Optional. Can be ytd, mtd, wtd or today.  Defaults to ytd
 *
 * @return bool
 */
function equilibria_get_ambassador_order_total( $affiliate_id = 0, $range = 'ytd' ) {

	global $wpdb;

	// gets affiliate ID of logged in user if none specified
	if ( $affiliate_id == 0 ) {
		$affiliate_id = affwp_get_affiliate_id();
	}

	$affiliate_id = absint( $affiliate_id );

	// check for valid date range
	$valid_ranges = [ 'ytd', 'mtd', 'wtd', 'today' ];
	if ( ! in_array( $range, $valid_ranges ) ) {
		trigger_error( 'Date range must be one of ' . implode( ',', $valid_ranges ), E_USER_WARNING );
		return false;
	}

	// set our date range sql
	if ( $range == 'mtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND MONTH(CONVERT_TZ(date,'UTC','America/Chicago')) = MONTH(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'wtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND WEEK(CONVERT_TZ(date,'UTC','America/Chicago')) = WEEK(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'today' ) {
		$rangesql = "AND DATE(CONVERT_TZ(date,'UTC','America/Chicago')) = DATE(CONVERT_TZ(NOW(),'UTC','America/Chicago'))";
	}
	// defaults to ytd
	else {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago')) 
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}

	// creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $affiliate_id . '_' . $range;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $total = get_transient( $transient_key ) ) ) {

		$total = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(DISTINCT referral_id) as total
             FROM wp_eq_ambassador_referrals             
             WHERE affiliate_id = %d
			 AND referral_type = 'reg_15-20-30-50'
			 AND NOT referral_status='rejected'
             $rangesql
             ", $affiliate_id
		) );

		// save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $total, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
	}
	 return $total;
}

/**
 * Wrapper for YTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_order_total_ytd_new( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_order_total( $affiliate_id, 'ytd' );
}

/**
 * Wrapper for MTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_order_total_mtd( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_order_total( $affiliate_id, 'mtd' );
}

/**
 * Wrapper for WTD
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_order_total_wtd( $affiliate_id = 0 ) {
	return equilibria_get_ambassador_order_total( $affiliate_id, 'wtd' );
}

/**
 * Wrapper for today
 *
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_order_total_today(  $affiliate_id = 0 ) {
	return equilibria_get_ambassador_order_total( $affiliate_id, 'today' );
}


/**
 * Gets earnings for a order type and affiliate and range
 *
 * @param  string  $order_type    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 * @param  string  $range         Optional. Can be ytd, mtd, wtd or today.  Defaults to ytd
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_by_order_type( $order_type, $affiliate_id = 0, $range = 'ytd' ) {

	global $wpdb;

	if ( ! $order_type ) {
		trigger_error( 'order_type must be specified', E_USER_WARNING );
		return false;
	}

	// gets affiliate ID of logged in user if none specified
	if ( $affiliate_id == 0 ) {
		$affiliate_id = affwp_get_affiliate_id();
	}

	$affiliate_id = absint( $affiliate_id );

	// check for valid date range
	$valid_ranges = [ 'ytd', 'mtd', 'wtd', 'today' ];
	if ( ! in_array( $range, $valid_ranges ) ) {
		trigger_error( 'Date range must be one of ' . implode( ',', $valid_ranges ), E_USER_WARNING );
		return false;
	}

	// set our date range sql
	if ( $range == 'mtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND MONTH(CONVERT_TZ(date,'UTC','America/Chicago')) = MONTH(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'wtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND WEEK(CONVERT_TZ(date,'UTC','America/Chicago')) = WEEK(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'today' ) {
		$rangesql = "AND DATE(CONVERT_TZ(date,'UTC','America/Chicago')) = DATE(CONVERT_TZ(NOW(),'UTC','America/Chicago'))";
	}
	// defaults to ytd
	else {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago')) 
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}


	// if pulling report for OTP's, we need to grab all orders of any type but ONLY the otp's from those orders.
	if( $order_type == 'otp' ){
		$type = "product_type = 'otp'";
	}
	// otherwise grab every line item that is not a OTP order and IS a sub product.
	else {
		$type = "order_type = '".esc_sql($order_type)."' AND product_type = 'sub'";
	}

	// creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $order_type . '_' . $affiliate_id . '_' . $range;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $sum = get_transient( $transient_key ) ) ) {

		$sum = $wpdb->get_var( $wpdb->prepare(
			"SELECT SUM(amount) as sum
             FROM wp_eq_ambassador_referrals
             WHERE $type
             AND affiliate_id = %d
			 AND referral_type = 'reg_15-20-30-50'
			 AND NOT referral_status='rejected'
             $rangesql
             ", $affiliate_id
		) );

		// save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $sum, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
    }

        return round($sum, 2);
        
}

/**
 * Wrapper for YTD
 *
 * @param  string  $order_type    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_ytd_by_order_type( $order_type, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_order_type( $order_type, $affiliate_id, 'ytd' );
}

/**
 * Wrapper for MTD
 *
 * @param  string  $order_type    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_mtd_by_order_type( $order_type, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_order_type( $order_type, $affiliate_id, 'mtd' );
}

/**
 * Wrapper for WTD
 *
 * @param  string  $order_type    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_wtd_by_order_type( $order_type, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_order_type( $order_type, $affiliate_id, 'wtd' );
}

/**
 * Wrapper for today
 *
 * @param  string  $order_type    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_today_by_order_type( $order_type, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_order_type( $order_type, $affiliate_id, 'today' );
}


/**
 * Gets earnings for a given product and affiliate and range
 *
 * @param  int     $product_id    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 * @param  string  $range         Optional. Can be ytd, mtd, wtd or today.  Defaults to ytd
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_by_product( int $product_id, $affiliate_id = 0, $range = 'ytd' ) {

	global $wpdb;

	if ( ! $product_id ) {
		trigger_error( 'product_id must be specified', E_USER_WARNING );
		return false;
	}

	// gets affiliate ID of logged in user if none specified
	if ( $affiliate_id == 0 ) {
		$affiliate_id = affwp_get_affiliate_id();
	}

	$product_id   = absint( $product_id );
	$affiliate_id = absint( $affiliate_id );

	// check for valid date range
	$valid_ranges = [ 'ytd', 'mtd', 'wtd', 'today' ];
	if ( ! in_array( $range, $valid_ranges ) ) {
		trigger_error( 'Date range must be one of ' . implode( ',', $valid_ranges ), E_USER_WARNING );
		return false;
	}

	// set our date range sql
	if ( $range == 'mtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND MONTH(CONVERT_TZ(date,'UTC','America/Chicago')) = MONTH(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'wtd' ) {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND WEEK(CONVERT_TZ(date,'UTC','America/Chicago')) = WEEK(CONVERT_TZ(NOW(),'UTC','America/Chicago'))
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}
	elseif ( $range == 'today' ) {
		$rangesql = "AND DATE(CONVERT_TZ(date,'UTC','America/Chicago')) = DATE(CONVERT_TZ(NOW(),'UTC','America/Chicago'))";
	}
	// defaults to ytd
	else {
		$rangesql = "AND YEAR(CONVERT_TZ(date,'UTC','America/Chicago')) = YEAR(CONVERT_TZ(NOW(),'UTC','America/Chicago')) 
		AND CONVERT_TZ(date,'UTC','America/Chicago') <= CONVERT_TZ(NOW(),'UTC','America/Chicago')";
	}

	// creates a unique transient key based off function name and arguments.
	$transient_key = __FUNCTION__ . '_' . $product_id . '_' . $affiliate_id . '_' . $range;

	// if our transient returns false, it has expired, so re-run the query
	if ( false === ( $sum = get_transient( $transient_key ) ) ) {

		$sum = $wpdb->get_var( $wpdb->prepare(
			"SELECT SUM(amount) as sum
             FROM wp_eq_ambassador_referrals
             WHERE product_id = %d               
             AND affiliate_id = %d
			 AND referral_type = 'reg_15-20-30-50'
			 AND NOT referral_status='rejected'
             $rangesql
             ", $product_id, $affiliate_id
		) );

		// save our $sum with the unique transient key with an expiration of 5 minutes.
		set_transient( $transient_key, $sum, EQ_AMBDASH_CALC_TRANSIENT_EXPIRY );
    }

        return round($sum, 2);
    
}

/**
 * Wrapper for YTD
 *
 * @param  int     $product_id    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_ytd_by_product( $product_id, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_product( $product_id, $affiliate_id, 'ytd' );
}

/**
 * Wrapper for MTD
 *
 * @param  int     $product_id    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_mtd_by_product( $product_id, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_product( $product_id, $affiliate_id, 'mtd' );
}

/**
 * Wrapper for WTD
 *
 * @param  int     $product_id    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_wtd_by_product( $product_id, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_product( $product_id, $affiliate_id, 'wtd' );
}

/**
 * Wrapper for today
 *
 * @param  int     $product_id    Required
 * @param  int     $affiliate_id  Optional. Defaults to current logged in user if no affiliate_id specified.
 *
 * @return bool
 */
function equilibria_get_ambassador_earnings_today_by_product( $product_id, $affiliate_id = 0 ) {
	return equilibria_get_ambassador_earnings_by_product( $product_id, $affiliate_id, 'today' );
}


