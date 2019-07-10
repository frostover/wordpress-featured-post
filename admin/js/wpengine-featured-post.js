( function( wp ) {
	let registerPlugin = wp.plugins.registerPlugin;
	let PluginSidebar = wp.editPost.PluginPostStatusInfo;
	let el = wp.element.createElement;
	const { BaseControl, CheckboxControl } = wp.components;
	const { withDispatch, withSelect } = wp.data;
	const { compose } = wp.compose;

	//Register the meta field value
	registerPlugin( 'wpengine-featured-post', {
		render: function() {

			//Basic custom checkbox control. Using simple compose to handle
			//the data management.
			var MetaCheckboxControl = compose(
				withDispatch( function(dispatch, props) {
					return {
						setMetaValue: function(metaValue) {
							metaValue = metaValue === true ? 1 : 0;
							wp.data.dispatch('core/editor').editPost(
								{ meta: {_wpengine_featured_post_meta: metaValue } }
							);
						}
					}
				} ),
				withSelect(function(select, props) {
					return {
						metaValue: wp.data.select('core/editor').getEditedPostAttribute('meta')['_wpengine_featured_post_meta'],
					}
				} ) )( function(props) {
					return el(CheckboxControl, {
						label: props.title,
						checked: props.metaValue,
						onChange: function(content) {
							props.setMetaValue(content);
						},
					});
				}
			);

			//Display the meta box
			return el( PluginSidebar,
				{
					name: 'wpengine-featured-post',
					title: 'WPEngine Featured Post',
				},
				el( 'div',
					{ className: 'wpengine-featured-post-content' },
					el( BaseControl, {
						id: 'wpengine-featured-post',
					},

						el( MetaCheckboxControl, {
							metaKey: '_wpengine_featured_post_meta',
							title: 'WPEngine Featured Post?'
						})
					)
				)
			);
		}
	} );

} )( window.wp );
