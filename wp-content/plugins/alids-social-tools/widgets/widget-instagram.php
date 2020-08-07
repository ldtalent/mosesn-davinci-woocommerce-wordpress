<?php
/**
 * Instagram Widget.
 */

class ADSWST_Instagram_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
	 
		parent::__construct( 'adswst_instagram_widget', __( 'ADS Instagram Feed', 'adswst' ), [
            'description'                 => __( 'Drag and drop this widget for Instagram box integration', 'adswst' ),
            'customize_selective_refresh' => true,
        ] );
	}

	public function update( $new_instance, $old_instance ) {

		$instance                  = $old_instance;
		$instance[ 'title' ]       = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'title_inner' ] = strip_tags( $new_instance[ 'title_inner' ] );
		$instance[ 'username' ]    = trim( strip_tags( $new_instance[ 'username' ] ) );
		$instance[ 'number' ]      = ! absint( $new_instance[ 'number' ] ) ? 9 : $new_instance[ 'number' ];
		$instance[ 'size' ]        = in_array( $new_instance[ 'size' ], [ 'thumbnail', 'small', 'large', 'original' ] )
            ? $new_instance[ 'size' ] : 'large';
		$instance[ 'target' ]      = $new_instance[ 'target' ] === '_blank' ? '_blank' : '_self';
		
		return $instance;
	}

	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, [
			'title'       => __( 'Follow Us', 'adswst' ),
			'title_inner' => __(  'Follow Us On Instagram', 'adswst' ),
			'username'    => '',
			'size'        => 'thumbnail',
			'number'      => 6,
			'target'      => '_blank',
		] );
		
		$title       = $instance[ 'title' ];
		$title_inner = $instance[ 'title_inner' ];
		$username    = $instance[ 'username' ];
		$number      = absint( $instance[ 'number' ] );
		$size        = $instance[ 'size' ];
		$target      = $instance[ 'target' ];
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>">
                <?php esc_html_e( 'Title', 'adswst' ) ?>:
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>"
                       type="text"
                       value="<?php echo esc_attr( $title ) ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_inner' ) ) ?>">
                <?php esc_html_e( 'Title inner', 'adswst' ) ?>:
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'title_inner' ) ) ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title_inner' ) ) ?>"
                       type="text"
                       value="<?php echo esc_attr( $title_inner ) ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ) ?>">
                <?php esc_html_e( '@username or #tag', 'adswst' ) ?>:
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'username' ) ) ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'username' ) ) ?>"
                       type="text"
                       value="<?php echo esc_attr( $username ) ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ) ?>">
                <?php esc_html_e( 'Number of photos', 'adswst' ) ?>:
                <input class="widefat"
                       id="<?php echo esc_attr( $this->get_field_id( 'number' ) ) ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ) ?>"
                       type="number"
                       min="1"
                       max="15"
                       step="1"
                       value="<?php echo esc_attr( $number ) ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ) ?>">
                <?php esc_html_e( 'Photo size', 'adswst' ) ?>:
            </label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ) ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'size' ) ) ?>"
                    class="widefat">
                <option value="thumbnail" <?php selected( 'thumbnail', $size ) ?>><?php esc_html_e( 'Thumbnail', 'adswst' ) ?></option>
                <option value="small" <?php selected( 'small', $size ) ?>><?php esc_html_e( 'Small', 'adswst' ) ?></option>
                <option value="large" <?php selected( 'large', $size ) ?>><?php esc_html_e( 'Large', 'adswst' ) ?></option>
                <option value="original" <?php selected( 'original', $size ) ?>><?php esc_html_e( 'Original', 'adswst' ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ) ?>">
                <?php esc_html_e( 'Open links in', 'adswst' ) ?>:
            </label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ) ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'target' ) ) ?>"
                    class="widefat">
                <option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window (_self)', 'adswst' ) ?></option>
                <option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window (_blank)', 'adswst' ) ?></option>
            </select>
        </p>
		<?php
	}

	public function widget( $args, $instance ) {

		wp_enqueue_style( 'adswst-widget-instagram',
            ADSWST_URL .'/assets/css/widget-instagram' . ADSWST_MIN .'.css', [], ADSWST_VERSION, 'all' );

		wp_enqueue_style( 'adswst-css-social-icons',
            ADSWST_URL .'/assets/css/social-icons' . ADSWST_MIN .'.css', [], ADSWST_VERSION, 'all' );

		$title       = empty( $instance[ 'title' ] ) ? '' : apply_filters( 'widget_title', $instance[ 'title' ] );
		$title_inner = empty( $instance[ 'title_inner' ] ) ? '' : $instance[ 'title_inner' ];
		$username    = empty( $instance[ 'username' ] ) ? '' : $instance[ 'username' ];
		$limit       = empty( $instance[ 'number' ] ) ? 6 : $instance[ 'number' ];
		$size        = empty( $instance[ 'size' ] ) ? 'thumbnail' : $instance[ 'size' ];
		$target      = empty( $instance[ 'target' ] ) ? '_blank' : $instance[ 'target' ];
		$shortcode   = empty( $instance[ 'shortcode' ] ) ? false : $instance[ 'shortcode' ];

		if( ! $shortcode ) {
			echo $args[ 'before_widget' ];
		}

		if ( ! empty( $title ) && ! $shortcode ) {
		 
			if( isset( $args[ 'before_title' ] ) )
				echo $args[ 'before_title' ];

			echo $title;

			if( isset( $args[ 'after_title' ] ) )
				echo $args[ 'after_title' ];
		}

		echo '<div class="instagram-wrap">';

		if ( '' !== $username ) {

			if ( ! empty( $title_inner ) && ! $shortcode )
			    echo '<h2 class="instagram-title">' . wp_kses_post( $title_inner ) . '</h2>';

			if( ! $shortcode )
				echo '<div class="instagram-by">
                        <a href="//instagram.com/' . str_replace( '@', '', $username ) . '"
                            target="' . esc_attr( $target ) . '">' . __( 'by', 'adswst' ) . ' ' . $username . '</a>
                    </div>';

			$instagram_array = $this->scrape_instagram( $username );

			if ( is_wp_error( $instagram_array ) ) {

				echo wp_kses_post( $instagram_array->get_error_message() );

			} else {

				if( ! $shortcode ) {
					echo '<div class="instagram-info">
                            <div class="photo-count">
                                <i class="social-icon-camera"></i> ' . $instagram_array['info']['photos'] . '
                            </div>
                            <div class="followers-count">
                                <i class="social-icon-user"></i> ' . $instagram_array['info']['followers'] . '
                            </div>
                        </div>';
				}
				
				if ( $images_only = apply_filters( 'adswst_images_only', false ) ) {
					$instagram_array[ 'images' ] = array_filter( $instagram_array[ 'images' ], [ $this, 'images_only' ] );
				}
				
				$instagram_array[ 'images' ] = array_slice( $instagram_array[ 'images' ], 0, $limit );
				
				$ulclass       = apply_filters( 'adswst_instagram_list_class', 'instagram-pics instagram-size-' . $size );
				$liclass       = apply_filters( 'adswst_instagram_item_class', 'instagram-pics-item' );
				$aclass        = apply_filters( 'adswst_instagram_a_class', '' );
				$imgclass      = apply_filters( 'adswst_instagram_img_class', '' );
				$template_part = apply_filters( 'adswst_instagram_template_part', 'parts/wp-instagram-widget.php' );

				echo '<div class="' . esc_attr( $ulclass ) . '">';
				
				foreach( $instagram_array[ 'images' ] as $item ) {

					if ( locate_template( $template_part ) !== '' ) {
						include locate_template( $template_part );
					} else {
						echo '<div class="' . esc_attr( $liclass ) . '">
						        <a href="' . esc_url( $item[ 'link' ] ) . '"
						            target="' . esc_attr( $target ) . '" class="' . esc_attr( $aclass ) . '">
						            <img src="' . esc_url( $item[ $size ] ) . '"
						                alt="' . esc_attr( $item[ 'description' ] ) . '"
						                title="' . esc_attr( $item[ 'description' ] ) . '"
						                class="img-fluid ' . esc_attr( $imgclass ) . '"/>
                                </a>
                            </div>';
					}
				}
				
				echo '</div>';
			}
		}

		echo '</div>';

		if( ! $shortcode ) {
			echo $args[ 'after_widget' ];
		}
	}
	
	function scrape_instagram( $username ) {

		$username = trim( strtolower( $username ) );

		switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
				$transient_prefix = 'h';
				break;

			default:
				$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
				$transient_prefix = 'u';
				break;
		}

		$instagram = get_transient( 'insta-adswst-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ;

		if ( ! $instagram ) {

			$remote = wp_remote_get( $url );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'davinciwoo' ) );
			}

			if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'davinciwoo' ) );
			}

			$shards      = explode( 'window._sharedData = ', $remote[ 'body' ] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'davinciwoo' ) );
			}

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'davinciwoo' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'davinciwoo' ) );
			}

			$instagram = [
				'images' => []
            ];

			foreach ( $images as $image ) {
				
				$type = true === $image[ 'node' ][ 'is_video' ] ? 'video' : 'image';

				$caption = __( 'Instagram Image', 'davinciwoo' );

				$instagram[ 'images' ][] = [
					'description' => $caption,
					'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
					'time'        => $image['node']['taken_at_timestamp'],
					'comments'    => $image['node']['edge_media_to_comment']['count'],
					'likes'       => $image['node']['edge_liked_by']['count'],
					'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
					'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
					'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
					'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
					'type'        => $type,
				];
			}

			$instagram[ 'info' ] = [
                'followers' => ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'] ) )
                    ? $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'] : '',
                'photos' => ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'] ) )
                    ? $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'] : '',
            ];
            
			if ( ! empty( $instagram[ 'images' ] ) ) {
				set_transient( 'insta-adswst-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		if ( ! empty( $instagram ) )
			return  $instagram;
		
        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'adswst' ) );
	}

	function images_only( $media_item ) {

		if ( 'image' === $media_item[ 'type' ] ) {
			return true;
		}

		return false;
	}

}