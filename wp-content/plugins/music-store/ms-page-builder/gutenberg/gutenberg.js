jQuery(function(){
	( function( blocks, element ) {
		var el = element.createElement,
			InspectorControls = wp.editor.InspectorControls;

		/* Plugin Category */
		blocks.getCategories().push({slug: 'cpms', title: 'Music Store'});

		/* ICONS */
		const iconCPMS = el('img', { width: 20, height: 20, src:  "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAIAAADZrBkAAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAAsSAAALEgHS3X78AAAAHnRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M1LjGrH0jrAAAAFnRFWHRDcmVhdGlvbiBUaW1lADEwLzA2LzEzdw7Y2QAAADVJREFUKJFj/M/QwkA6YCJDz4Bp+1+NIIkAjFQKEmRrcZHD0zYYoLVtqIC6tmGyaWMbTbUBACQXL53t1JHjAAAAAElFTkSuQmCC" } );

		function esc_regexp(str)
		{
			return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
		};

		function get_attr_value(attr, shortcode)
		{
			var reg = new RegExp('\\b'+esc_regexp(attr)+'\\s*=\\s*[\'"]([^\'"]*)[\'"]', 'i'),
				res = reg.exec(shortcode);
			if(res !== null) return res[1];
			return '';
		};

		function generate_shortcode(shortcode, attr, value, props)
		{
			var shortcode = wp.shortcode.next(shortcode, props.attributes.shortcode),
				attrs = shortcode.shortcode.attrs.named;

			shortcode.shortcode.attrs.named[attr] = value;
			props.setAttributes({'shortcode': shortcode.shortcode.string()});
		};

		/* Music Store Shortcode */
		blocks.registerBlockType( 'cpms/music-store', {
			title: 'Music Store',
			icon: iconCPMS,
			category: 'cpms',
			supports: {
				customClassName	: false,
				className		: false
			},
			attributes: {
				shortcode : {
					type 	: 'string',
					default	: '[music_store columns="1"]'
				}
			},

			edit: function( props ) {
				var focus = props.isSelected,
					children = [];

				// Editor
				children.push(
					el(
						'div', {className: 'ms-iframe-container', key: 'ms_iframe_container'},
						el('div', {className: 'ms-iframe-overlay', key: 'ms_iframe_overlay'}),
						el('iframe',
							{
								key: 'ms_store_iframe',
								src: ms_ge_config.url+encodeURIComponent(props.attributes.shortcode),
								height: 0,
								width: 500,
								scrolling: 'no'
							}
						)
					)
				);

				// InspectorControls
				if(!!focus)
				{
					children.push(
						el(
							InspectorControls,
							{
								key: 'ms_inspector'
							},
							[
								el('hr', {key: 'ms_hr'}),

								// Exclude
								el(
									'label',
									{
										htmlFor: 'ms_products_to_exclude',
										style:{fontWeight:'bold'},
										key: 'ms_products_to_exclude_label'
									},
									ms_ge_config.labels.exclude
								),
								el(
									'input',
									{
										key: 'ms_products_to_exclude',
										type: 'text',
										style: {width:'100%'},
										value : get_attr_value('exclude', props.attributes.shortcode),
										onChange : function(evt){generate_shortcode('music_store', 'exclude', evt.target.value, props);}
									}
								),
								el(
									'div',
									{
										style: {fontStyle: 'italic'},
										key: 'ms_products_to_exclude_help'
									},
									ms_ge_config.help.exclude
								),

								// Columns
								el(
									'label',
									{
										htmlFor: 'ms_columns',
										style:{fontWeight:'bold'},
										key: 'ms_columns_label'
									},
									ms_ge_config.labels.columns
								),
								el(
									'input',
									{
										key: 'ms_columns',
										type: 'number',
										style: {width:'100%'},
										value : get_attr_value('columns', props.attributes.shortcode),
										onChange : function(evt){generate_shortcode('music_store', 'columns', evt.target.value, props);}
									}
								),
								el(
									'div',
									{
										style: {fontStyle: 'italic'},
										key: 'ms_columns_help'
									},
									ms_ge_config.help.columns
								),

								// Genres
								el(
									'label',
									{
										htmlFor: 'ms_genres',
										style:{fontWeight:'bold'},
										key: 'ms_genres_label'
									},
									ms_ge_config.labels.genres
								),
								el(
									'input',
									{
										key: 'ms_genres',
										type: 'text',
										style: {width:'100%'},
										value : get_attr_value('genre', props.attributes.shortcode),
										onChange : function(evt){generate_shortcode('music_store', 'genre', evt.target.value, props);}
									}
								),
								el(
									'div',
									{
										style: {fontStyle: 'italic'},
										key: 'ms_genres_help'
									},
									ms_ge_config.help.genres
								),

								// Artists
								el(
									'label',
									{
										htmlFor: 'ms_artists',
										style:{fontWeight:'bold'},
										key: 'ms_artists_label'
									},
									ms_ge_config.labels.artists
								),
								el(
									'input',
									{
										key: 'ms_artists',
										type: 'text',
										style: {width:'100%'},
										value : get_attr_value('artist', props.attributes.shortcode),
										onChange : function(evt){generate_shortcode('music_store', 'artist', evt.target.value, props);}
									}
								),
								el(
									'div',
									{
										style: {fontStyle: 'italic'},
										key: 'ms_artists_help'
									},
									ms_ge_config.help.artists
								),

								// Albums
								el(
									'label',
									{
										htmlFor: 'ms_albums',
										style:{fontWeight:'bold'},
										key: 'ms_albums_label'
									},
									ms_ge_config.labels.albums
								),
								el(
									'input',
									{
										key: 'ms_albums',
										type: 'text',
										style: {width:'100%'},
										value : get_attr_value('album', props.attributes.shortcode),
										onChange : function(evt){generate_shortcode('music_store', 'album', evt.target.value, props);}
									}
								),
								el(
									'div',
									{
										style: {fontStyle: 'italic'},
										key: 'ms_albums_help'
									},
									ms_ge_config.help.albums
								)
							]
						)
					);
				}
				return [children];
			},

			save: function( props ) {
				return props.attributes.shortcode;
			}
		});
	})(
		window.wp.blocks,
		window.wp.element
	);
});