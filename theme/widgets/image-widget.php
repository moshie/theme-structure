<?php

if( ! class_exists( 'LT_Image_Widget' ) ) { 
  
    class LT_Image_Widget extends LT_Widget { 
          
        protected $widget = array(); 
        protected $fields = array(); 
  
        public function __construct() { 
  
            $this->widget = array( 
                'id' => 'image-widget', 
                'name' => __( '+ Image Widget', LTCON_ADMIN_TEXTDOMAIN ), 
                'options' => array( 
                    'classname' => 'image-widget', 
                    'description' => __( 'Image Widget - Will display an image to your sidebar.', LTCON_ADMIN_TEXTDOMAIN )
                ) 
            ); 

			$this->add_field( 'title', array( 
				'type' => 'text', 
				'label' => __( 'Title', LTCON_ADMIN_TEXTDOMAIN )
			) );

			$this->add_field( 'image', array(
				'label' => __( 'Image Upload', LTCON_ADMIN_TEXTDOMAIN ),
				'type' => 'upload'
			) );

			$this->add_field( 'image_alt', array(
				'label' => __( 'Image ALT', LTCON_ADMIN_TEXTDOMAIN ),
				'type' => 'text'
			) );

			$this->add_field( 'link', array( 
				'type' => 'text', 
				'label' => __( 'Hyperlink?', LTCON_ADMIN_TEXTDOMAIN )
			) );

			$this->add_field( 'new_window', array( 
				'type' => 'boolean', 
				'label' => __( 'Open link in new window?', LTCON_ADMIN_TEXTDOMAIN )
			) );
			
            parent::__construct(); 
        } 
  
        /* 
  
  
  
  
  
  
  
  
  
  
  
            Widget Callback 
  
        */
  
        public function widget( $args, $instance ) { 
  
            $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ); 
  			$link = $instance['link'];
  			$window = $instance['new_window'] ? ' target="_blank"' : '';


            echo $args['before_widget']; 

            	if( $title )
					echo $args['before_title'] . $title . $args['after_title'];

                echo '<div class="thumbnail">'; 
				
					if( $link )
						echo '<a href="' . esc_url( $link ) . '"' . $window . '>';

					if( $instance['image'] )
						echo '<img src="' . esc_url( $instance['image'] ) . '" alt' . ( $instance['image_alt'] ? '="' . esc_attr( $instance['image_alt'] ) . '" ' : ' ' ) . ' />';

					if( $link )
						echo '</a>';
				
				echo '</div>';
				
            echo $args['after_widget']; 
        }
    } 
    register_widget( 'LT_Image_Widget' ); 
}