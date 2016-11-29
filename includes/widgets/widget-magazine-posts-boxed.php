<?php
/**
 * Magazine Posts Boxed Widget
 *
 * Display the latest posts from a selected category in a boxed layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Pocono
 */

/**
 * Magazine Widget Class
 */
class Pocono_Pro_Magazine_Posts_Boxed_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'pocono-magazine-posts-boxed', // ID.
			sprintf( esc_html__( 'Magazine Posts: Boxed (%s)', 'pocono-pro' ), 'Pocono Pro' ), // Name.
			array(
				'classname' => 'pocono_magazine_posts_boxed',
				'description' => esc_html__( 'Displays your posts from a selected category in a boxed layout. Please use this widget ONLY in the Magazine Homepage widget area.', 'pocono-pro' ),
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
			'title'				=> '',
			'category'			=> 0,
			'layout'			=> 'horizontal',
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
			$cache = wp_cache_get( 'widget_pocono_magazine_posts_boxed', 'widget' );
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
		<div class="widget-magazine-posts-boxed widget-magazine-posts clearfix">

			<?php // Display Title.
			$this->widget_title( $args, $settings ); ?>

			<div class="widget-magazine-posts-content">

				<?php $this->render( $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// Set Cache.
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_pocono_magazine_posts_boxed', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

	}

	/**
	 * Renders the Widget Content
	 *
	 * Switches between horizontal and vertical layout style based on widget settings
	 *
	 * @uses this->magazine_posts_horizontal() or this->magazine_posts_vertical()
	 * @used-by this->widget()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $settings ) {

		if ( 'horizontal' === $settings['layout'] ) : ?>

			<div class="magazine-posts-boxed-horizontal clearfix">

				<?php $this->magazine_posts_horizontal( $settings ); ?>

			</div>

		<?php else : ?>

			<div class="magazine-posts-boxed-vertical clearfix">

				<?php $this->magazine_posts_vertical( $settings ); ?>

			</div>

		<?php
		endif;

	}

	/**
	 * Display Magazine Posts in Horizontal Layout
	 *
	 * @used-by this->render()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function magazine_posts_horizontal( $settings ) {

		// Get latest posts from database.
		$query_arguments = array(
			'posts_per_page' => 4,
			'ignore_sticky_posts' => true,
			'cat' => (int) $settings['category'],
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Limit the number of words for the excerpt.
			add_filter( 'excerpt_length', 'pocono_magazine_posts_excerpt_length' );

			// Display Posts.
			while ( $posts_query->have_posts() ) :

				$posts_query->the_post();

				if ( 0 === $i ) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post clearfix' ); ?>>

						<div class="post-image">

							<?php pocono_post_image(); ?>

							<?php pocono_entry_categories(); ?>

						</div>

						<div class="post-content">

							<header class="entry-header">

								<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

								<?php pocono_entry_meta(); ?>

							</header><!-- .entry-header -->

							<div class="entry-content">
								<?php the_excerpt(); ?>
								<?php pocono_more_link(); ?>
							</div><!-- .entry-content -->

						</div>

					</article>

				<div class="medium-posts clearfix">

				<?php else : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'medium-post clearfix' ); ?>>

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'pocono-thumbnail-medium' ); ?></a>
						<?php endif; ?>

						<div class="medium-post-content">

							<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

							<?php if ( function_exists( 'pocono_magazine_widgets_entry_meta' ) ) { pocono_magazine_widgets_entry_meta(); } ?>

						</div>

					</article>

				<?php
				endif; $i++;

			endwhile; ?>

				</div><!-- end .medium-posts -->

			<?php
			// Remove excerpt filter.
			remove_filter( 'excerpt_length', 'pocono_magazine_posts_excerpt_length' );

		endif;

		// Reset Postdata.
		wp_reset_postdata();

	} // magazine_posts_horizontal()

	/**
	 * Displays Magazine Posts in Vertical Layout
	 *
	 * @used-by this->render()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function magazine_posts_vertical( $settings ) {

		// Get latest posts from database.
		$query_arguments = array(
			'posts_per_page' => 6,
			'ignore_sticky_posts' => true,
			'cat' => (int) $settings['category'],
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Limit the number of words for the excerpt.
			add_filter( 'excerpt_length', 'pocono_magazine_posts_excerpt_length' );

			// Display Posts.
			while ( $posts_query->have_posts() ) :

				$posts_query->the_post();

				if ( 0 === $i ) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post clearfix' ); ?>>

						<div class="post-image">

							<?php pocono_post_image(); ?>

							<?php pocono_entry_categories(); ?>

						</div>

						<header class="entry-header">

							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

							<?php pocono_entry_meta(); ?>

						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php the_excerpt(); ?>
							<?php pocono_more_link(); ?>
						</div><!-- .entry-content -->

					</article>

				<div class="small-posts clearfix">

				<?php else : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'small-post clearfix' ); ?>>

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'pocono-thumbnail-small' ); ?></a>
						<?php endif; ?>

						<div class="small-post-content">

							<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

							<?php if ( function_exists( 'pocono_magazine_widgets_entry_meta' ) ) { pocono_magazine_widgets_entry_meta(); } ?>

						</div>

					</article>

				<?php
				endif; $i++;

			endwhile; ?>

				</div><!-- end .medium-posts -->

			<?php
			// Remove excerpt filter.
			remove_filter( 'excerpt_length', 'pocono_magazine_posts_excerpt_length' );

		endif;

		// Reset Postdata.
		wp_reset_postdata();

	} // magazine_posts_vertical()

	/**
	 * Displays Widget Title
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Category Title.
			if ( $settings['category'] > 0 ) :

				// Set Link URL and Title for Category.
				$link_title = sprintf( esc_html__( 'View all posts from category %s', 'pocono-pro' ), get_cat_name( $settings['category'] ) );
				$link_url = esc_url( get_category_link( $settings['category'] ) );

				// Display Widget Title with link to category archive.
				echo '<div class="widget-header">';
				echo '<h1 class="widget-title"><a class="category-archive-link" href="' . $link_url . '" title="' . $link_title . '">' . $widget_title . '</a></h1>';
				echo '</div>';

			else :

				// Display default Widget Title without link.
				echo $args['before_title'] . $widget_title . $args['after_title'];

			endif;

		endif;

	} // widget_title()

	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['layout'] = esc_attr( $new_instance['layout'] );
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
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'pocono-pro' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $settings['title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'pocono-pro' ); ?></label><br/>
			<?php // Display Category Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'pocono-pro' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category'],
					'name'               => $this->get_field_name( 'category' ),
					'id'                 => $this->get_field_id( 'category' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php esc_html_e( 'Post Layout:', 'pocono-pro' ); ?></label><br/>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>">
				<option <?php selected( $settings['layout'], 'horizontal' ); ?> value="horizontal" ><?php esc_html_e( 'Horizontal Arrangement', 'pocono-pro' ); ?></option>
				<option <?php selected( $settings['layout'], 'vertical' ); ?> value="vertical" ><?php esc_html_e( 'Vertical Arrangement', 'pocono-pro' ); ?></option>
			</select>
		</p>

	<?php
	} // form()

	/**
	 * Delete Widget Cache
	 */
	public function delete_widget_cache() {

		wp_cache_delete( 'widget_pocono_magazine_posts_boxed', 'widget' );

	}
}
