import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';

import {
	NameControl,
	ValueControl,
	PlaceholderControl,
	IdControl,
	ClassControl,
} from '../components';
import { uniqId } from '../helper';
import withValidations from '../../hoc/with-validations';

const edit = ( { attributes, setAttributes } ) => {
	const {
		name,
		value,
		placeholder,
		id,
		controlClass,
		description,
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Attributes', 'snow-monkey-forms' ) }>
					<NameControl
						value={ name || `textarea-${ uniqId() }` }
						onChange={ ( attribute ) =>
							setAttributes( { name: attribute } )
						}
					/>

					<ValueControl
						multiple={ true }
						value={ value }
						onChange={ ( attribute ) =>
							setAttributes( { value: attribute } )
						}
					/>

					<PlaceholderControl
						value={ placeholder }
						onChange={ ( attribute ) =>
							setAttributes( { placeholder: attribute } )
						}
					/>

					<IdControl
						value={ id }
						onChange={ ( attribute ) =>
							setAttributes( { id: attribute } )
						}
					/>

					<ClassControl
						value={ controlClass }
						onChange={ ( attribute ) =>
							setAttributes( { controlClass: attribute } )
						}
					/>
				</PanelBody>

				<PanelBody
					title={ __( 'Block settings', 'snow-monkey-forms' ) }
				>
					<TextControl
						label={ __( 'Description', 'snow-monkey-forms' ) }
						value={ description }
						onChange={ ( attribute ) =>
							setAttributes( { description: attribute } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div className="smf-placeholder" data-name={ name }>
				<div className="smf-textarea-control">
					<textarea
						name={ name }
						value={ value }
						placeholder={ placeholder }
						disabled="disabled"
						id={ id || undefined }
						className={ `smf-textarea-control__control ${ controlClass }` }
					/>
				</div>
				{ description && (
					<div className="smf-control-description">
						{ description }
					</div>
				) }
			</div>
		</>
	);
};

export default compose( withValidations )( edit );
