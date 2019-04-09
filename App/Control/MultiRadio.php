<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Control;

use Snow_Monkey\Plugin\Forms\App\Contract;
use Snow_Monkey\Plugin\Forms\App\Helper;

class MultiRadio extends Contract\Control {
	public    $name        = '';
	public    $data        = [];
	public    $value       = '';
	protected $options     = [];
	protected $validations = [];

	public function input() {
		$attributes = get_object_vars( $this );
		unset( $attributes['name'] );
		unset( $attributes['value'] );

		$options = [];
		foreach ( $this->options as $value => $label ) {
			$option_attributes = [
				'name'    => $this->name,
				'value'   => $value,
				'label'   => $label,
				'checked' => $value === $this->value,
			];

			$options[] = Helper::control( 'radio', $option_attributes )->input();
		}

		return sprintf(
			'<span class="c-multi-radio" %1$s>%2$s</span>',
			$this->generate_attributes( $attributes ),
			implode( '', $options )
		);
	}

	public function confirm() {
		if ( ! isset( $this->options[ $this->value ] ) ) {
			return;
		}

		return sprintf(
			'%1$s%2$s',
			esc_html( $this->options[ $this->value ] ),
			Helper::control( 'hidden', [ 'name' => $this->name, 'value' => $this->value ] )->input()
		);
	}

	public function error( $error_message = '' ) {
		$this->data['invalid'] = true;

		return sprintf(
			'%1$s%2$s',
			$this->input(),
			$error_message
		);
	}
}
