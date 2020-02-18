import { TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { withSelect, withDispatch } from '@wordpress/data';

const Control = ( props ) => {
	return (
		<TextControl
			label={ __( 'Subject', 'snow-monkey-forms' ) }
			value={ props.administrator_email_subject }
			onChange={ ( value ) => props.setMetaFieldValue( value ) }
		/>
	);
};

const ControlWithData = withSelect( ( select ) => {
	const { getEditedPostAttribute } = select( 'core/editor' );

	const meta = getEditedPostAttribute( 'meta' );

	return {
		administrator_email_subject: meta.administrator_email_subject,
	};
} )( Control );

export default withDispatch( ( dispatch ) => {
	const { editPost } = dispatch( 'core/editor' );

	return {
		setMetaFieldValue: ( value ) =>
			editPost( { meta: { administrator_email_subject: value } } ),
	};
} )( ControlWithData );