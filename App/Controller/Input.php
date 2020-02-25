<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Controller;

use Snow_Monkey\Plugin\Forms\App\Contract;
use Snow_Monkey\Plugin\Forms\App\Helper;

class Input extends Contract\Controller {

	protected function set_controls() {
		return $this->controls;
	}

	protected function set_action() {
		ob_start();

		if ( true === $this->setting->get( 'use_confirm_page' ) ) {
			Helper::the_control(
				'button',
				[
					'attributes' => [
						'data-action' => 'confirm',
					],
					'label' => __( 'Confirm', 'snow-monkey-forms' ) . '<span class="smf-sending" aria-hidden="true"></span>',
				]
			);

			Helper::the_control(
				'hidden',
				[
					'attributes' => [
						'name'  => '_method',
						'value' => 'confirm',
					],
				]
			);
		} else {
			Helper::the_control(
				'button',
				[
					'attributes' => [
						'data-action' => 'complete',
					],
					'label' => __( 'Send', 'snow-monkey-forms' ) . '<span class="smf-sending" aria-hidden="true"></span>',
				]
			);

			Helper::the_control(
				'hidden',
				[
					'attributes' => [
						'name'  => '_method',
						'value' => 'complete',
					],
				]
			);
		}

		return ob_get_clean();
	}

	protected function set_message() {
		return $this->message;
	}
}