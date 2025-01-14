<?php
/**
 * Payment form post type
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Extensions\GravityForms
 */

namespace Pronamic\WordPress\Pay\Extensions\GravityForms;

/**
 * Title: WordPress payment form post type
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.1.2
 * @since   1.1.0
 */
class PaymentFormPostType {
	/**
	 * Construct and initialize payment form post type
	 */
	public function __construct() {
		/**
		 * Priority of the initial post types function should be set to < 10.
		 *
		 * @link https://core.trac.wordpress.org/ticket/28488
		 * @link https://core.trac.wordpress.org/changeset/29318
		 *
		 * @link https://github.com/WordPress/WordPress/blob/4.0/wp-includes/post.php#L167
		 */
		add_action( 'init', [ $this, 'init' ], 0 ); // Highest priority.
	}

	/**
	 * Initialize.
	 * 
	 * @return void
	 */
	public function init() {
		register_post_type(
			'pronamic_pay_gf',
			[
				'label'              => __( 'Payment Feeds', 'pronamic-pay-with-mollie-for-gravity-forms' ),
				'labels'             => [
					'name'                  => __( 'Payment Feeds', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'singular_name'         => __( 'Payment Feed', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'add_new'               => __( 'Add New', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'add_new_item'          => __( 'Add New Payment Feed', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'edit_item'             => __( 'Edit Payment Feed', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'new_item'              => __( 'New Payment Feed', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'all_items'             => __( 'All Payment Feeds', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'view_item'             => __( 'View Payment Feed', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'search_items'          => __( 'Search Payment Feeds', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'not_found'             => __( 'No payment feeds found.', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'not_found_in_trash'    => __( 'No payment feeds found in Trash.', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'menu_name'             => __( 'Payment Feeds', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'filter_items_list'     => __( 'Filter payment feeds list', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'items_list_navigation' => __( 'Payment feeds list navigation', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					'items_list'            => __( 'Payment feeds list', 'pronamic-pay-with-mollie-for-gravity-forms' ),
				],
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => false,
				'show_in_nav_menus'  => false,
				'show_in_menu'       => false,
				'show_in_admin_bar'  => false,
				'supports'           => [ 'title', 'revisions' ],
				'rewrite'            => false,
				'query_var'          => false,
			]
		);
	}
}
