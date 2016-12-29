<?php
/**
 * Magazine Columns Widget
 *
 * Display the latest posts from two categories in a two column layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Pocono Pro
 */

/**
 * Magazine Widget Class
 */
class Pocono_Pro_Magazine_Columns_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'pocono-magazine-columns', // ID.
			esc_html__( 'Magazine: Columns', 'pocono-pro' ), // Name.
			array(
				'classname' => 'pocono_magazine_columns',
				'description' => esc_html__( 'Displays your posts from two selected categories. Please use this widget ONLY in the Magazine Homepage widget area.', 'pocono-pro' ),
				'customize_selective_refresh' => true,
			) // Args.
		);

		// Delete Widget Cache on certain actions.
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );
	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'category_one'			=> 0,
			'category_two'			=> 0,
			'category_one_title'	=> '',
			'category_two_title'	=> '',
			'number'				=> 4,
			'highlight_post'		=> true,
		);

		return $defaults;
	}

	/**
	 * Main Function to display the widget
	 *
	 * @uses this->render()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 */
	function widget( $args, $instance ) {

		$cache = array();

		// Get Widget Object Cache.
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_pocono_magazine_columns', 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		// Display Widget from Cache if exists.
		if ( isset( $cache[ $this->id ] ) ) {
			echo $cache[ $this->id ];
			return;
		}

		// Start Output Buffering.
		ob_start();

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output.
		echo $args['before_widget'];
		?>
		<div class="widget-magazine-columns widget-magazine-posts clearfix">

			<div class="widget-magazine-posts-content clearfix">

				<?php echo $this->render( $args, $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// Set Cache.
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_pocono_magazine_columns', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

	}

	/**
	 * Renders the Widget Content
	 *
	 * Displays left and right column with posts
	 *
	 * @uses this->magazine_posts()
	 * @used-by this->widget()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $args, $settings ) {
		?>

		<div class="magazine-column-left magazine-column clearfix">

			<div class="magazine-column-content clearfix">

				<?php // Display Category Title.
					$this->category_title( $args, $settings, $settings['category_one'], $settings['category_one_title'] ); ?>

				<div class="magazine-column-post-list clearfix">
					<?php $this->magazine_posts( $settings, $settings['category_one'] ); ?>
				</div>

			</div>

		</div>

		<div class="magazine-column-right magazine-column clearfix">

			<div class="magazine-column-content clearfix">

				<?php // Display Category Title.
					$this->category_title( $args, $settings, $settings['category_two'], $settings['category_two_title'] ); ?>

				<div class="magazine-column-post-list clearfix">
					<?php $this->magazine_posts( $settings, $settings['category_two'] ); ?>
				</div>

			</div>

		</div>

		<?php
	}

	/**
	 * Display Magazine Posts Loop
	 *
	 * @used-by this->render()
	 *
	 * @param array $settings / Settings for this widget instance.
	 * @param int   $category_id / ID of the selected category.
	 */
	function magazine_posts( $settings, $category_id ) {

		// Get latest posts from database.
		$query_arguments = array(
			'posts_per_page' => (int) $settings['number'],
			'ignore_sticky_posts' => true,
			'cat' => (int) $category_id,
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Display excerpt for first post.
			set_query_var( 'pocono_post_excerpt', true );

			// Display Posts.
			while ( $posts_query->have_posts() ) :

				$posts_query->the_post();

				if ( true === $settings['highlight_post'] and 0 === $i ) :

					Pocono_Pro::load_theme_template( 'template-parts/widgets/magazine-content', 'large-post' );

				else :

					Pocono_Pro::load_theme_template( 'template-parts/widgets/magazine-content', 'small-post' );

				endif; $i++;

			endwhile;

		endif;

		// Reset Postdata.
		wp_reset_postdata();

	}

	/**
	 * Displays Category Widget Title
	 *
	 * @param array  $args / Parameters from widget area created with register_sidebar().
	 * @param array  $settings / Settings for this widget instance.
	 * @param int    $category_id / ID of the selected category.
	 * @param String $category_title / Category Title.
	 */
	function category_title( $args, $settings, $category_id, $category_title ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $category_title, $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Category Title.
			if ( $category_id > 0 ) :

				// Set Link URL and Title for Category.
				$link_title = sprintf( __( 'View all posts from category %s', 'pocono-pro' ), get_cat_name( $category_id ) );
				$link_url = get_category_link( $category_id );

				// Display Widget Title with link to category archive.
				echo '<div class="widget-header">';
				echo '<h3 class="widget-title"><a class="category-archive-link" href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_title ) . '">' . $widget_title . '</a></h3>';
				echo '<div class="category-description">' . category_description( $category_id ) . '</div>';
				echo '</div>';

			else :

				// Display default Widget Title without link.
				echo $args['before_title'] . $widget_title . $args['after_title'];

			endif;

		endif;

	}

	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['category_one_title'] = sanitize_text_field( $new_instance['category_one_title'] );
		$instance['category_one'] = (int) $new_instance['category_one'];
		$instance['category_two_title'] = sanitize_text_field( $new_instance['category_two_title'] );
		$instance['category_two'] = (int) $new_instance['category_two'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['highlight_post'] = ! empty( $new_instance['highlight_post'] );

		$this->delete_widget_cache();

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance.
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_one_title' ); ?>"><?php esc_html_e( 'Left Category Title:', 'pocono-pro' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'category_one_title' ); ?>" name="<?php echo $this->get_field_name( 'category_one_title' ); ?>" type="text" value="<?php echo $settings['category_one_title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_one' ); ?>"><?php esc_html_e( 'Left Category:', 'pocono-pro' ); ?></label><br/>
			<?php // Display Category One Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'pocono-pro' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_one'],
					'name'               => $this->get_field_name( 'category_one' ),
					'id'                 => $this->get_field_id( 'category_one' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_two_title' ); ?>"><?php esc_html_e( 'Right Category Title:', 'pocono-pro' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'category_two_title' ); ?>" name="<?php echo $this->get_field_name( 'category_two_title' ); ?>" type="text" value="<?php echo $settings['category_two_title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_two' ); ?>"><?php esc_html_e( 'Right Category:', 'pocono-pro' ); ?></label><br/>
			<?php // Display Category One Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'pocono-pro' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_two'],
					'name'               => $this->get_field_name( 'category_two' ),
					'id'                 => $this->get_field_id( 'category_two' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts:', 'pocono-pro' ); ?>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo (int) $settings['number']; ?>" size="3" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'highlight_post' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['highlight_post'] ); ?> id="<?php echo $this->get_field_id( 'highlight_post' ); ?>" name="<?php echo $this->get_field_name( 'highlight_post' ); ?>" />
				<?php esc_html_e( 'Highlight first post (big image + excerpt)', 'pocono-pro' ); ?>
			</label>
		</p>

		<?php
	}

	/**
	 * Delete Widget Cache
	 */
	public function delete_widget_cache() {

		wp_cache_delete( 'widget_pocono_magazine_columns', 'widget' );

	}
}
