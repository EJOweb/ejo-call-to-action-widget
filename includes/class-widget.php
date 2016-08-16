<?php

final class EJO_Call_To_Action_Widget extends WP_Widget
{
	//* Slug of this widget
    const SLUG = EJO_Call_To_Action_Widget_Plugin::SLUG;

	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = __('Call To Action Widget', self::SLUG);

		$widget_info = array(
			'classname'   => 'call-to-action-widget',
			'description' => __('Encourage your visitors with this widget!', self::SLUG)
		);

		parent::__construct( self::SLUG, $widget_title, $widget_info );
	}

	public function widget( $args, $instance ) 
	{
		//* Combine $instance data with defaults
        $instance = wp_parse_args( $instance, array( 
            'title' => '',
            'subtitle' => '',
            'text' => '',
            'linked_page_id' => '',
            'link_text' => __('Lees meer', self::SLUG),
        ));

        //* Try to load theme template
		if ( class_exists( 'EJO_Widget_Template_Loader' ) ) {

			$template_loaded = EJO_Widget_Template_Loader::load_template( $args, $instance, $this );
		}

		//* If no template loaded, proceed widget output
		if ( empty($template_loaded) ) {

			//* Allow filtered widget-output
			$filtered_output = apply_filters( 'ejo_call_to_action_widget_output', '', $args, $instance, $this );

			//* Print filtered_output
			echo $filtered_output;

			//* If no filtered output show default widget 
			if ( ! $filtered_output ) {
				$this->render_default_widget($args, $instance);
			}
		}
	}


	/**
	 * Render default widget
	 */
	public function render_default_widget($args, $instance)
	{
		echo $args['before_widget'];
		?>

		<div class="entry-content">
			<h4><?php echo $instance['subtitle']; ?></h4>
			<h2><?php echo $instance['title']; ?></h2>
			<?php echo wpautop($instance['text']); ?>
		</div>
		<footer class="entry-footer">
			<a href="<?php echo get_permalink($instance['linked_page_id']); ?>" class="button"><?php echo $instance['link_text']; ?></a>
		</footer>
		
		<?php
		echo $args['after_widget'];
	}

 	public function form( $instance ) 
 	{
 		//* Combine $instance data with defaults
        $instance = wp_parse_args( $instance, array( 
            'title' => '',
            'subtitle' => '',
            'text' => '',
            'linked_page_id' => '',
            'link_text' => __('Lees meer', self::SLUG),
        ));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" value="<?php echo $instance['subtitle']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Tekst:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $instance['text']; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link_text'); ?>">Link tekst:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" value="<?php echo $instance['link_text']; ?>" />
		</p>
		<?php

		//* Get all pages
		$all_pages = get_pages();

		?>
		<p>
			<label for="<?php echo $this->get_field_id('linked_page_id'); ?>">Linken naar pagina:</label>
			<select name="<?php echo $this->get_field_name('linked_page_id'); ?>" id="<?php echo $this->get_field_id('linked_page_id'); ?>" class="widefat">
				<?php
				//* Show all pages as an option
				foreach ($all_pages as $page) {
					printf( 
						'<option value="%s" %s>%s</option>',
						$page->ID,
						selected($instance['linked_page_id'], $page->ID, false),
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
		$instance['link_text'] = isset( $new_instance['link_text'] ) ? $new_instance['link_text'] : '';
		$instance['linked_page_id'] = isset( $new_instance['linked_page_id'] ) ? $new_instance['linked_page_id'] : '';

		return $instance;
	}
}