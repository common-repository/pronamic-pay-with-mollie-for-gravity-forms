<?php
/**
 * Admin
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Extensions\GravityForms
 */

namespace Pronamic\WordPress\Pay\Extensions\GravityForms;

use RGFormsModel;

/**
 * Title: WordPress pay extension Gravity Forms admin
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.1.14
 * @since   1.0.0
 */
class Admin {
	/**
	 * Bootstrap.
	 *
	 * @return void
	 */
	public static function bootstrap() {
		// Actions.
		add_action( 'admin_init', [ __CLASS__, 'admin_init' ] );
		add_action( 'admin_init', [ __CLASS__, 'maybe_redirect_to_entry' ] );

		add_action( 'gform_entry_info', [ __CLASS__, 'entry_info' ], 10, 2 );

		// Filters.
		add_filter( 'gform_custom_merge_tags', [ __CLASS__, 'custom_merge_tags' ], 10 );

		// Actions - AJAX.
		add_action( 'wp_ajax_gf_get_form_data', [ __CLASS__, 'ajax_get_form_data' ] );
	}

	/**
	 * Admin initialize.
	 *
	 * @return void
	 */
	public static function admin_init() {
		new AdminPaymentFormPostType();
	}

	/**
	 * Add menu item to form settings.
	 *
	 * @param array<array<string, string>> $menu_items Array with form settings menu items.
	 * @return array<array<string, string>>
	 */
	public static function form_settings_menu_item( $menu_items ) {
		$menu_items[] = [
			'name'  => 'pronamic_pay',
			'label' => __( 'Pay', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'query' => [ 'fid' => null ],
		];

		return $menu_items;
	}

	/**
	 * Render entry info of the specified form and lead
	 *
	 * @param string $form_id Gravity Forms form ID.
	 * @param array  $lead    Gravity Forms lead/entry.
	 * @return void
	 */
	public static function entry_info( $form_id, $lead ) {
		$payment_id = gform_get_meta( $lead['id'], 'pronamic_payment_id' );

		if ( ! $payment_id ) {
			return;
		}

		printf(
			'<a href="%s">%s</a>',
			esc_attr( get_edit_post_link( $payment_id ) ),
			esc_html( get_the_title( $payment_id ) )
		);
	}

	/**
	 * Custom merge tags.
	 *
	 * @param array<array<string, string>> $merge_tags Array with merge tags.
	 * @return array<array<string, string>>
	 */
	public static function custom_merge_tags( $merge_tags ) {
		// Payment.
		$merge_tags[] = [
			'label' => __( 'Payment Status', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{payment_status}',
		];

		$merge_tags[] = [
			'label' => __( 'Payment Date', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{payment_date}',
		];

		$merge_tags[] = [
			'label' => __( 'Transaction Id', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{transaction_id}',
		];

		$merge_tags[] = [
			'label' => __( 'Payment Amount', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{payment_amount}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Payment ID', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_id}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Pay Again URL', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_pay_again_url}',
		];

		// Bank transfer.
		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient reference', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_reference}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient bank name', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_bank_name}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient name', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_name}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient IBAN', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_iban}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient BIC', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_bic}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient city', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_city}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient country', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_country}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic bank transfer recipient account number', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_bank_transfer_recipient_account_number}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic consumer bank account name', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_consumer_bank_account_name}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic consumer IBAN', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_payment_consumer_iban}',
		];

		// Subscription.
		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription ID', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_id}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription Payment ID', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_payment_id}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription Amount', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_amount}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription Cancel URL', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_cancel_url}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription Renew URL', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_renew_url}',
		];

		$merge_tags[] = [
			'label' => __( 'Pronamic Subscription Renewal Date', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			'tag'   => '{pronamic_subscription_renewal_date}',
		];

		return $merge_tags;
	}

	/**
	 * Maybe redirect to Gravity Forms entry.
	 *
	 * @return void
	 */
	public static function maybe_redirect_to_entry() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! \array_key_exists( 'pronamic_gf_lid', $_GET ) ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$lead_id = \sanitize_text_field( \wp_unslash( $_GET['pronamic_gf_lid'] ) );

		$lead = RGFormsModel::get_lead( $lead_id );

		if ( false === $lead ) {
			\wp_die( \esc_html__( 'The requested Gravity Forms entry could not be found.', 'pronamic-pay-with-mollie-for-gravity-forms' ) );
		}

		$url = \add_query_arg(
			[
				'page' => 'gf_entries',
				'view' => 'entry',
				'id'   => $lead['form_id'],
				'lid'  => $lead_id,
			],
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $url );

		exit;
	}

	/**
	 * Handle AJAX request get form data
	 */
	public static function ajax_get_form_data() {
		$form_id = \filter_input( INPUT_GET, 'formId', \FILTER_SANITIZE_NUMBER_INT );

		$data = RGFormsModel::get_form_meta( $form_id );

		wp_send_json_success( $data );
	}

	/**
	 * Get new feed URL.
	 *
	 * @since 1.6.3
	 *
	 * @param string $form_id Gravity Forms form ID.
	 * @return string
	 */
	public static function get_new_feed_url( $form_id ) {
		return add_query_arg(
			[
				'page'    => 'gf_edit_forms',
				'view'    => 'settings',
				'subview' => 'pronamic_pay',
				'id'      => $form_id,
				'fid'     => 0,
			],
			admin_url( 'admin.php' )
		);
	}
}
