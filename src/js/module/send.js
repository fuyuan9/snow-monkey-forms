'use strict';

import $ from 'jquery';
import snowmonkeyforms from 'snowmonkeyforms';

export default function send( form ) {
	const actionArea = form.find( '.snow-monkey-form__action' );

	form.on(
		'submit',
		( event ) => {
			event.preventDefault();

			$.post(
				snowmonkeyforms.view_json_url,
				form.serialize()
			).done(
				( response ) => {
					response = JSON.parse( response );
					const method = response.data._method;

					actionArea.html( response.action );
					form.find( '.snow-monkey-form__placeholder' ).html( '' );

					if ( '' === method || 'back' === method || 'error' === method || 'confirm' === method ) {
						$.each(
							response.controls,
							( key, control ) => {
								const placeholder = form.find( `.snow-monkey-form__placeholder[data-name="${ key }"]` );
								placeholder.html( control );
							}
						);
					} else if ( 'complete' === method ) {
						form.html( response.message );
					} else {
						form.html( '' );
					}
				}
			);
		}
	);
}