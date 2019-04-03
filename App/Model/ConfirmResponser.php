<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Model;

use Snow_Monkey\Plugin\Forms\App\Control;

class ConfirmResponser extends Responser {
	public function get_response_data() {
		$controls = [];
		foreach ( $this->setting->get( 'controls' ) as $control ) {
			$attributes = isset( $control['attributes'] ) ? $control['attributes'] : [];
			$value = $this->get( $attributes['name'] );

			$label = $value;
			if ( is_array( $value ) ) {
				$labels = [];
				$children = isset( $control['children'] ) ? $control['children'] : [];
				foreach ( $children as $child ) {
					$child_attributes = isset( $child['attributes'] ) ? $child['attributes'] : [];
					if ( isset( $child_attributes['value'] ) && in_array( $child_attributes['value'], $value ) ) {
						$labels[] = $child['label'];
					}
				}
				$label = implode( ', ', $labels );
			}

			$controls[ $control['attributes']['name'] ] = implode(
				'',
				[
					$label,
					Control::render(
						'hidden',
						[
							'attributes' => [
								'name'  => $control['attributes']['name'],
								'value' => $value,
							],
						]
					),
				]
			);
		}

		return array_merge(
			parent::get_response_data(),
			[
				'controls' => $controls,
				'action' => [
					Control::render( 'button', [ 'attributes' => [ 'value' => '戻る', 'data-action' => 'back' ] ] ),
					Control::render( 'button', [ 'attributes' => [ 'value' => '送信', 'data-action' => 'complete' ] ] ),
					Control::render( 'hidden', [ 'attributes' => [ 'name' => '_method', 'value' => 'complete' ] ] ),
				],
			]
		);
	}
}
