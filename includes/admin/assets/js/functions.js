( function( $ ) {
	
	$.fn.ltconUpload = function() {
		
		return this.each( function() {
			
			var wrap = $( this ),
				inner = wrap.find( '.field-inner' ),
				textfield = inner.find( '.field.upload' ),
				buttons = inner.find( '.button-wrap' ),
				btn_remove = buttons.find( '.btn-remove' ),
				btn_upload = buttons.find( '.btn-upload' ),
				btn_preview = buttons.find( '.btn-preview' ),
				preview = wrap.find( '.upload-preview' ),
				btn_preview_remove = preview.find( '.btn-preview-remove' ),
				file_frame,
				attachment;
			
			//
			textfield.on( 'keyup', function() {
				
				if( '' != textfield.val() ) {
					wrap.addClass( 'has-remove' );
					wrap.addClass( 'has-preview' );
				} else {
					wrap.removeClass( 'has-remove' );
					wrap.removeClass( 'has-preview' );
					btn_preview_remove.click();
				}
				
			} ).trigger( 'keyup' );
			
			btn_upload.on( 'click', function( e ) {
				
				e.preventDefault();
				
				if( file_frame ) {
					
					file_frame.open();
					return;
				}
				
				file_frame = wp.media.frames.file_frame = wp.media( {
					
					title : $( this ).data( 'title' ),
					button : {
						text : $ (this ).data( 'button' )
					},
					multiple : false
				} );
				
				file_frame.on( 'select', function() {
					
					attachment = file_frame.state().get( 'selection' ).first().toJSON();
					textfield.val( attachment.url ).trigger( 'keyup' );
					console.log( textfield );
					
				} );
				
				file_frame.open();
				
			} );
			
			btn_remove.on( 'click', function( e ) {
				
				e.preventDefault();
				textfield.val( '' ).trigger( 'keyup' );
				
			} );
			
			btn_preview.on( 'click', function( e ) {
				
				e.preventDefault();
				preview.addClass( 'visible' );
				btn_preview.addClass( 'refresh' );
				preview.find( 'img' ).remove();
				preview.append( '<img src="' + textfield.val() + '" />' );
				
			} );
			
			btn_preview_remove.on( 'click', function( e ) {
				
				e.preventDefault();
				preview.removeClass( 'visible' );
				btn_preview.removeClass( 'refresh' );
				preview.find( 'img' ).remove();
			} );
			
		} );
	}
	
} )( jQuery );