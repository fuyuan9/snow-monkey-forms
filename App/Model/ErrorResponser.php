<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Model;

use Snow_Monkey\Plugin\Forms\App\Control;

class ErrorResponser extends Responser {
	public function get_response_data() {
		$controls = [];
		foreach ( $this->setting->get( 'controls' ) as $control ) {
			$attributes = isset( $control['attributes'] ) ? $control['attributes'] : [];
			$control['attributes'] = array_merge( $attributes, [ 'value' => $this->get( $control['attributes']['name'] ) ] );

			$form_control = Control::render( $control['type'], $control );

			$error_message = ! empty( $control['require'] ) && '' === $this->get( $control['attributes']['name'] )
				? '未入力です'
				: '';

			$controls[ $control['attributes']['name'] ] = $form_control . $error_message;
		}

		return array_merge(
			parent::get_response_data(),
			[
				'controls' => $controls,
				'action' => [
					Control::render( 'button', [ 'attributes' => [ 'value' => '確認', 'data-action' => 'confirm' ] ] ),
					Control::render( 'hidden', [ 'attributes' => [ 'name' => '_method', 'value' => 'confirm' ] ] ),
				],
			]
		);
	}
}
