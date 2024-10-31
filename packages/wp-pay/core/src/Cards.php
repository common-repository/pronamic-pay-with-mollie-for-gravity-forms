<?php
/**
 * Cards
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

/**
 * Cards
 *
 * @author  Reüel van der Steege
 * @version 2.7.1
 * @since   2.4.0
 */
class Cards {
	/**
	 * Cards.
	 *
	 * @var array
	 */
	private $cards;

	/**
	 * Cards constructor.
	 */
	public function __construct() {
		$this->register_cards();
	}

	/**
	 * Register cards.
	 *
	 * @return void
	 */
	private function register_cards() {
		$this->cards = [
			// Cards.
			[
				'bic'   => null,
				'brand' => 'american-express',
				'title' => __( 'American Express', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'carta-si',
				'title' => __( 'Carta Si', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'carte-bleue',
				'title' => __( 'Carte Bleue', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'dankort',
				'title' => __( 'Dankort', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'diners-club',
				'title' => __( 'Diners Club', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'discover',
				'title' => __( 'Discover', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'jcb',
				'title' => __( 'JCB', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'maestro',
				'title' => __( 'Maestro', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'mastercard',
				'title' => __( 'Mastercard', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'unionpay',
				'title' => __( 'UnionPay', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => null,
				'brand' => 'visa',
				'title' => __( 'Visa', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],

			// Banks.
			[
				'bic'   => 'abna',
				'brand' => 'abn-amro',
				'title' => __( 'ABN Amro', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'asnb',
				'brand' => 'asn-bank',
				'title' => __( 'ASN Bank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'bunq',
				'brand' => 'bunq',
				'title' => __( 'bunq', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'hand',
				'brand' => 'handelsbanken',
				'title' => __( 'Handelsbanken', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'ingb',
				'brand' => 'ing',
				'title' => __( 'ING Bank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'knab',
				'brand' => 'knab',
				'title' => __( 'Knab', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'moyo',
				'brand' => 'moneyou',
				'title' => __( 'Moneyou', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'rabo',
				'brand' => 'rabobank',
				'title' => __( 'Rabobank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'rbrb',
				'brand' => 'regiobank',
				'title' => __( 'RegioBank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'snsb',
				'brand' => 'sns',
				'title' => __( 'SNS Bank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'trio',
				'brand' => 'triodos-bank',
				'title' => __( 'Triodos Bank', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
			[
				'bic'   => 'fvlb',
				'brand' => 'van-lanschot',
				'title' => __( 'Van Lanschot', 'pronamic-pay-with-mollie-for-gravity-forms' ),
			],
		];
	}

	/**
	 * Get card.
	 *
	 * @param string $bic_or_brand 4-letter ISO 9362 Bank Identifier Code (BIC) or brand name.
	 * @return array|null
	 */
	public function get_card( $bic_or_brand ) {
		// Use lowercase BIC or brand without spaces.
		$bic_or_brand = \strtolower( $bic_or_brand );

		$bic_or_brand = \str_replace( ' ', '-', $bic_or_brand );

		// Try to find card.
		$cards = \wp_list_filter(
			$this->cards,
			[
				'bic'   => $bic_or_brand,
				'brand' => $bic_or_brand,
			],
			'OR'
		);

		$card = \array_shift( $cards );

		// Return card details.
		if ( ! empty( $card ) ) {
			return $card;
		}

		// No matching card.
		return null;
	}

	/**
	 * Get card logo URL.
	 *
	 * @param string $brand Brand.
	 *
	 * @return string|null
	 */
	public function get_card_logo_url( $brand ) {
		return sprintf(
			'https://cdn.wp-pay.org/jsdelivr.net/npm/@wp-pay/logos@1.16.0/dist/cards/%1$s/card-%1$s-logo-_x80.svg',
			$brand
		);
	}
}
