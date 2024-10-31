<?php
/**
 * Admin View: Notice - License
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $data ) ) {
	return;
}

$class = ( 'valid' === $data->license ) ? 'updated' : 'error';

?>
<div class="<?php echo esc_attr( $class ); ?>">
	<p>
		<strong><?php esc_html_e( 'Pronamic Pay', 'pronamic-pay-with-mollie-for-gravity-forms' ); ?></strong> —
		<?php

		if ( 'valid' === $data->license ) {
			echo \esc_html(
				\sprintf(
					/* translators: %s: Pronamic Pay */
					\__( 'Thank you for activating your license and using the %s plugin.', 'pronamic-pay-with-mollie-for-gravity-forms' ),
					\__( 'Pronamic Pay', 'pronamic-pay-with-mollie-for-gravity-forms' )
				)
			);
		} elseif ( 'invalid' === $data->license && \property_exists( $data, 'activations_left' ) && 0 === $data->activations_left ) {
			echo \wp_kses(
				__( 'This license does not have any activations left. Maybe you have to deactivate your license on a local/staging server. This can be done on your <a href="https://www.pronamic.shop/" target="_blank">Pronamic.shop account</a>.', 'pronamic-pay-with-mollie-for-gravity-forms' ),
				[
					'a' => [
						'href'   => true,
						'target' => true,
					],
				]
			);
		} else {
			\esc_html_e( 'There was a problem activating your license key, please try again or contact support.', 'pronamic-pay-with-mollie-for-gravity-forms' );
		}

		?>
	</p>
</div>
