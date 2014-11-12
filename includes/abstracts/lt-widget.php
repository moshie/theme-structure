<?php

if( ! class_exists( 'LT_Widget' ) ) {
	
	abstract class LT_Widget extends WP_Widget {

		protected $widget = array();
		protected $fields = array();

		/*











			Init/Constructor creates the widget

		*/

		public function __construct() {

			$this->WP_Widget( $this->widget['id'], $this->widget['name'], $this->widget['options'] );
		}

		/*











			Update widget settings

		*/

		public function update( $new, $old ) {

			return $new;
		}

		/*











			Widget Form, this output fields dependant on your settings

		*/

		public function form( $instance ) {

			if( ! $this->fields ) {
				
				echo '<p>' . __( 'This widget has no options', LTCON_ADMIN_TEXTDOMAIN ) . '</p>';
				return;
			}
			
			foreach( $this->fields as $key => $field ) {
				
				$value = isset( $instance[$key] ) ? $instance[$key] : $field['default'];
				$placeholder = strlen( $field['placeholder'] ) > 0 ? ' placeholder="' . esc_attr( $field['placeholder'] ) . '"' : '';

				$id = esc_attr( $this->get_field_id( $key ) );
				$name = esc_attr( $this->get_field_name( $key ) );

				switch( $field['type'] ) {

					case 'boolean' :

						$checked = checked( $value, true, false );
						
						echo '<p class="ltcon-field field-toggle ltcon-group field-wrap field-boolean">';
							echo '<label><input type="hidden" value="0" name="' . $name . '" />';
							echo '<input type="checkbox" value="1" class="field boolean" name="' . $name . '"' . $checked . ' /> ' . $field['label'] . '</label>';
						echo '</p>';

						break;

					case 'checkbox' :
						
						if( ! count( $field['choices'] ) > 0 ) {
							
							_e( 'Please provide some options', LTCON_ADMIN_TEXTDOMAIN );
							continue;
						}
						
						echo '<p>';
							echo '<label>' . $field['label'] . '</label><br/>';
						
							foreach( $field['choices'] as $val => $label ) {
					
								$checked = checked( in_array( $val, ( is_array( $value ) ? $value : array( $value ) ) ), true, false );
							
								echo '<label title="' . esc_attr( $label ) . '">';
									echo '<input type="checkbox" name="' . esc_attr( $this->get_field_name( $key ) . '[]' ) . '"' . $checked . ' value="' . esc_attr( $val ) . '" /> ' . $label;
								echo '</label><br/>';
							}
						echo '</p>';
						
						break;
						
					case 'colorpicker' :
						
						echo '<div class="ltcon-widget-colorpicker">';
							echo '<label for="' . $id . '">' . $field['label'] . '</label><br/>';
							echo '<div class="field-inner ltcon-group">';
					
								echo '<div class="color swatch"><div></div></div>';
								echo '<input type="text" id="' . $id . '" name="' . $name . '" class="color widefat text field" value="' . esc_attr( $value ) . '"' . $placeholder . ' />';
					
							echo '</div>';
						echo '</div>';
						
						break;
					
					case 'html' :

						echo isset( $field['args']['content'] ) ? $field['args']['content'] : '';

						break;

					case 'radio' :
					case 'radioimage' :
					
						if( ! count( $field['choices'] ) > 0 ) {
						
							_e( 'Please provide some options', LTCON_ADMIN_TEXTDOMAIN );
							continue;
						}
						
						$count = 0;
			
						reset( $field['choices'] );
						$k = key( $field['choices'] );
			
						$image = is_array( $field['choices'][$k] ) && isset( $field['choices'][$k]['image'] ) ? true : false;
						
						echo '<p class="ltcon-group ltcon-widget-radio' . ( $image ? '-image' : '' ) . '">';
							echo '<label>' . $field['label'] . '</label><br/>';
					
							foreach( $field['choices'] as $val => $data ) {
							
								$count++;
							
								if( $count == 1 )
									$value = $value ? $value : $val;
							
								$checked = checked( in_array( $val, ( is_array( $value ) ? $value : array( $value ) ) ), true, false );
						
								echo '<label class="single-label" title="' . esc_attr( $label ) . '">';
									echo '<input type="radio" class="field radio" name="' . $name . '"' . $checked . ' value="' . esc_attr( $val ) . '" /> ' . ( ! $image ? ' ' : '' );
							
									if( $image ) {
							
										$label = isset( $data['label'] ) ? $data['label'] : $v;
									
										echo '<img src="' . esc_url( $data['image'] ) . '" alt="' . esc_attr( $label ) . '" title="' . esc_attr( $label ). '" />';
									} else {
							
										echo $data;
									}
								
								echo '</label>' . ( ! $image ? '<br/>' : '' );
							}
						echo '</p>';
					
						break;

					case 'select' :

						?>
						<p>
							<label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label>
							<select class="widefat" id="<?php echo $id; ?>" name="<?php echo $name; ?>"><?php echo esc_textarea( $value ); ?></textarea>
								<?php

								foreach( $field['choices'] as $val => $label ) {
								
									$selected = selected( $val, $value, false );
									echo '<option value="' . esc_attr( $val ) . '"' . $selected . '>' . esc_html( $label ) . '</option>';
								}

								?>
							</select>
						</p>
						<?php

						break;
						
					case 'text' :
					default :

						?>
						<p>
							<label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label>
							<input class="widefat"<?php echo $placeholder; ?> id="<?php echo $id; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
						</p>
						<?php

						break;

					case 'textarea' :

						?>
						<p>
							<label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label>
							<textarea style="min-height: 80px;" class="widefat"<?php echo $placeholder; ?> id="<?php echo $id; ?>" name="<?php echo $name; ?>"><?php echo esc_textarea( $value ); ?></textarea>
						</p>
						<?php

						break;
					
					case 'upload' :
						
						?>
						<div class="ltcon-widget-upload ltcon-group field-upload has-upload">
							<div class="field-inner ltcon-group">
							
								<label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label>
								<input type="text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" class="widefat field upload" <?php echo $placeholder; ?> />
					
								<div class="button-wrap">
									<a title="<?php _e( 'Upload', LTCON_ADMIN_TEXTDOMAIN ); ?>" target="_blank" data-title="<?php _e( 'Add Image', LTCON_ADMIN_TEXTDOMAIN ); ?>" data-button="<?php _e( 'Attach', LTCON_ADMIN_TEXTDOMAIN ); ?>" class="btn-upload button" href="<?php echo esc_url( admin_url( 'media-new.php' ) ); ?>"><?php _e( 'Upload', LTCON_ADMIN_TEXTDOMAIN ); ?></a>
									<a title="<?php _e( 'Preview', LTCON_ADMIN_TEXTDOMAIN ); ?>"  target="_blank" class="btn-preview button" href="#"><?php _e( 'Preview', LTCON_ADMIN_TEXTDOMAIN ); ?></a>
									<a title="<?php _e( 'Remove', LTCON_ADMIN_TEXTDOMAIN ); ?>"  target="_blank" class="btn-remove button" href="#"><?php _e( 'Remove', LTCON_ADMIN_TEXTDOMAIN ); ?></a>
								</div>
					
							</div>
				
							<div class="upload-preview ltcon-group">
								<a href="#" class="btn-preview-remove"><?php _e( 'Remove Preview', LTCON_ADMIN_TEXTDOMAIN ); ?></a>
							</div>
				
						</div>
						<?php
						
						break;
				}
			}
		}
	
		/* 
		
		
		
		
		
		
		
		
		
		
		
	        Add new widget setting 
		
	    */
  	
	    public function add_field( $id = '', $args = array() ) { 

			if( empty( $id ) ) 
				return; 

			$this->fields[$id] = wp_parse_args( $args, array( 
				'id' => $id, 
				'label' => $id, 
				'description' => '', 
				'type' => '', 
				'default' => '', 
				'choices' => '', 
				'placeholder' => '',
				'args' => array() 
			) );
	    }
	}
}