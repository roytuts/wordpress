<?php

/**
 * Name: Popular Posts widget.
 * Author: https://www.roytuts.com
 */
class Popular_Post_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'popular_post_widget', // Base ID
			esc_html__( 'Popular Posts', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'A Popular Post Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {		
		$title = $instance['title'];
		$postscount = $instance['posts'];
		 
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>
		
		<ul>
			<?php
				global $wpdb;
    
				$posts = $wpdb->get_results("SELECT comment_count, ID, post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0, $postscount");
				
				foreach ($posts as $post) {
					setup_postdata($post);
					$id = $post->ID;
					$title = $post->post_title;
					$count = $post->comment_count;
					
					echo '<li><a href="' . get_permalink($id) . '" title="' . $title . '">' . $title . '</a></li>';
				}
			?>
		</ul>
		
		<?php
		
		echo $args['after_widget'];;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular Posts', 'text_domain' );
		$posts = ! empty( $instance['posts'] ) ? $instance['posts'] : esc_html__( '5', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>"><?php esc_attr_e( 'Number of Posts:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts' ) ); ?>" type="text" value="<?php echo esc_attr( $posts ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['posts'] = ( ! empty( $new_instance['posts'] ) ) ? sanitize_text_field( $new_instance['posts'] ) : '';

		return $instance;
	}

}

//Register Popular_Post_Widget widget
function register_popular_post_widget() {
    register_widget( 'Popular_Post_Widget' );
}
add_action( 'widgets_init', 'register_popular_post_widget' );