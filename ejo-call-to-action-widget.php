<?php
/*
	Plugin Name: EJO Call To Action Widget
	Description: A widget to a call to action
	Version: 0.1
	Author: EJOweb
	Author URI: http://www.ejoweb.nl/
	
	GitHub Plugin URI: https://github.com/EJOweb/ejo-call-to-action-widget
	GitHub Branch:     master
 */

add_action( 'widgets_init', 'register_call_to_action_widget' );

//* Register Widget
function register_call_to_action_widget() 
{ 
    //* Include Widget Class
    register_widget( 'Call_To_Action_Widget' ); 
}

final class Call_To_Action_Widget extends WP_Widget
{
	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = 'Call To Action';

		$widget_info = array(
			'classname'   => 'call-to-action-widget',
			'description' => 'Korte informatie met een button',
		);

		parent::__construct( 'call-to-action-widget', $widget_title, $widget_info );
	}

	public function widget( $args, $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$subtitle = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';
		$linked_page = isset( $instance['linked-page'] ) ? $instance['linked-page'] : '';

		echo $args['before_widget'];
		?>

		<div class="entry-content">
			<h4><?php echo $subtitle; ?></h4>
			<h2><?php echo $title; ?></h2>
			<?php echo wpautop($text); ?>
		</div>
		<footer class="entry-footer">
			<a href="<?php echo get_permalink($linked_page); ?>" class="button"><?php echo $link_text; ?></a>
		</footer>
		
		<?php
		echo $args['after_widget'];
	}

 	public function form( $instance ) 
 	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$subtitle = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';
		$linked_page = isset( $instance['linked-page'] ) ? $instance['linked-page'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" value="<?php echo $subtitle; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Tekst:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link-text'); ?>">Link tekst:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link-text'); ?>" name="<?php echo $this->get_field_name('link-text'); ?>" value="<?php echo $link_text; ?>" />
		</p>
		<?php

		//* Get all pages
		$all_pages = get_pages();

		?>
		<p>
			<label for="<?php echo $this->get_field_id('linked-page'); ?>">Linken naar pagina:</label>
			<select name="<?php echo $this->get_field_name('linked-page'); ?>" id="<?php echo $this->get_field_id('linked-page'); ?>" class="widefat">
				<?php
				//* Show all pages as an option
				foreach ($all_pages as $page) {
					printf( 
						'<option value="%s" %s>%s</option>',
						$page->ID,
						selected($linked_page, $page->ID, false),
						$page->post_title
					);
				} 
				?>
			</select>
		</p>		
		<?php
	}

	public function update( $new_instance, $old_instance ) 
	{
		//* Store old instance as defaults
		$instance = $old_instance;

		//* Store new title
		$instance['title'] = strip_tags( $new_instance['title'] );

		//* Store info
		$instance['subtitle'] = isset( $new_instance['subtitle'] ) ? $new_instance['subtitle'] : '';
		$instance['text'] = isset( $new_instance['text'] ) ? $new_instance['text'] : '';
		$instance['link-text'] = isset( $new_instance['link-text'] ) ? $new_instance['link-text'] : '';
		$instance['linked-page'] = isset( $new_instance['linked-page'] ) ? $new_instance['linked-page'] : '';
		
		return $instance;
	}
}