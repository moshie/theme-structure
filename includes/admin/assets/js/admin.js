( function( $ ) {
	
	var ltconAdmin = {
		
		colorPicker : function() {
			
			$( '.color.swatch' ).each( function() {
				
				var el = $( this ),
				textfield = el.parent().find( '.color.text' );
				
				el.ColorPicker( {
					onChange : function( hsb, hex, rgb ) {
						el.find( 'div' ).css( { 'background-color': '#' + hex } );
						textfield.val( '#' + hex.toUpperCase() );
					},
					onBeforeShow : function() {
					 	
						el.ColorPickerSetColor( textfield.val().substring( 1 ) );
					}
				} );
				
				textfield.on( 'keyup', function() {
					el.find( 'div' ).css( { 'background-color': textfield.val() } );
				} ).trigger( 'keyup' );
			} );
		},
		
		/*
		
		
		
		
		
		*/
		
		radioImageToggle : function() {
			
			$( '.radio.field' ).on( 'click', function() {
				$( '.radio.field:not(:checked)' ).parent().removeClass( 'checked' );
				$( '.radio.field:checked' ).parent().addClass( 'checked' );
			} ).filter( ':checked' ).click();
		},
		
		/*
		
		
		
		
		
		*/
		
		refreshFields : function() {
			
			ltconAdmin.colorPicker();
			ltconAdmin.imageUploader();
			ltconAdmin.radioImageToggle();
			ltconAdmin.booleanToggleFields();
		},
		
		/*
		
		
		
		
		
		*/
		
		settingsTabs : function() {
			
			var tab_wrap = $( '.ltcon-tabs' ),
				h3 = tab_wrap.find( '> h3' ),
				form_table = tab_wrap.find( '> .form-table' ),
				navigation = $( '.ltcon-navigation'),
				top = navigation.find( '> li' ),
				children = navigation.find( '.children' ),
				a = navigation.find( 'a' );
			
			var wrapped = h3.wrap( '<div class="ltcon-tab" />' );
			wrapped.each( function() {
				
				$( this ).parent().append( $( this ).parent().nextUntil( 'div.ltcon-tab' ) );
			} );
			form_table.wrap( '<div class="tab-inner" />' );
			
			var tabs = tab_wrap.find( 'div.ltcon-tab' );
			
			tabs.each( function() {
				
				var str = $( this ).children( '.ltcon-section-id' ).attr( 'data-id' ).toString();
				$( this ).attr( 'id', str );
			} );
			
			top.find( '> a' ).on( 'click', function() {
				
				if( ! $( this ).hasClass( 'active' ) ) {
			
					children.slideUp( 100 );
					$( this ).parent().find( '.children' ).slideDown( 100 );
				}
				
				a.removeClass( 'active' );
				$( this ).addClass( 'active' );
		
				$( this ).parent().find( 'ul a' ).first().addClass( 'active' );
			} );
			
			children.find( 'a' ).click( function() {
				
				children.find( 'a' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
		
			} );
			
			a.click( function() {
		
				tabs.hide().filter( this.hash ).fadeIn(100);
				return false;
		
			} ).filter( ':first' ).click();
		},
		
		/*
		
		
		
		
		
		*/
		
		settingsToggleTr : function() {
			
			$( '.ltcon-settings .field-toggle' ).each( function() {
				
				var field = $( this ),
					tr = field.closest( 'tr' ),
					_toggle = field.data( 'if' );
				
				//
				tr.attr( 'data-if', _toggle );
				field.removeClass( 'field-toggle' );
				tr.addClass( 'field-toggle' );
				
			} );
		},
		
		/*
		
		
		
		
		
		*/
		
		booleanToggleFields : function() {
			
			$( '.field.boolean' ).each( function() {
				
				var el = $( this ),
					toggle;
				
				toggle = el.data( 'toggle' );
				
				el.on( 'click', function() {
					
					ltconAdmin.doBooleanToggleFields( el, toggle );
					
				} );
				
				ltconAdmin.doBooleanToggleFields( el, toggle );
				
			} );
		},
		
		/*
		
		
		
		
		
		*/
		
		doBooleanToggleFields : function( el, toggle ) {
			
			if( el.is( ':checked' ) ) {
				
				$( '.field-toggle' ).filter( function() {
				
					console.log( toggle + ' = ' + $( this ).data( 'if' ) );
				
					if( $( this ).data( 'if' ) == toggle )
						return true;
				
					return false;
				
				} ).removeClass( 'ltcon-hidden' );
			} else {
				
				$( '.field-toggle' ).filter( function() {
				
					console.log( toggle + ' = ' + $( this ).data( 'if' ) );
				
					if( $( this ).data( 'if' ) == toggle )
						return true;
				
					return false;
				
				} ).addClass( 'ltcon-hidden' );
			}
		},
		
		/*
		
		
		
		
		
		*/
		
		imageUploader : function() {
			
			$( '.field-upload' ).ltconUpload();
		},

		/*
		
		
		
		
		
		*/

		sortableFixHelper : function( e, tr ) {
			
			var originals = tr.children(),
				helper = tr.clone();
				
			helper.children().each( function( index ) {
				$( this ).width( originals.eq( index ).width() );
				$( this ).addClass( 'active' );
			} );
			
			return helper;
		},

		/*
		
		
		
		
		
		*/

		getSortableOrder : function( e, ui ) {
			
			var table = ui.item.closest('.table-sortable'),
				rows = table.find( 'tbody tr' );
			
			ltconAdmin.setTableOrders( table.data('name'), rows );
		},

		/*
		
		
		
		
		
		*/

		setTableOrders : function( n, e ) {
			
			var count = 0;
			
			e.each( function() {
				
				var key = $( this ).data( 'name' );
				$( this ).find( 'input[name^="' + key + '[order]"]' ).prop('name', key + '[order][' + count + ']' );
				count++;
				
			} );
		}
		
	};
	
	$( document ).ready( function() {
		
		ltconAdmin.settingsToggleTr();
		ltconAdmin.refreshFields();
		ltconAdmin.settingsTabs();
	} );
	
	$( document ).ajaxSuccess( function( e, xhr, settings ) {
		
		if( settings.data.search( 'action=save-widget' ) != -1 ) {
			
			ltconAdmin.settingsToggleTr();
			ltconAdmin.refreshFields();
			ltconAdmin.settingsTabs();
		}
	});
	
} )( jQuery );