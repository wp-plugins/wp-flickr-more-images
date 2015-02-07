<?php
/*
Plugin Name: WP Flickr more images
Description: Get more image from Flickr
Plugin URI: http://wpbootstrap.net
Author: WPBootstrap
Author URI: http://wpbootstrap.com
Version: 1.1
License: GPL2
Text Domain: wpboot
*/

/*

    Copyright (C) 2015  WPBootstrap  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Adds Wpboot_MoreFlickr widget.
 */
class Wpboot_MoreFlickr extends WP_Widget {
  /**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'wpboot_moremlickr', // Base ID
			'WP Flickr more images', // Name
			array( 'description' => __( 'Widget to display More Flickr Image', 'wpboot' ), ) // Args
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
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$flickrid = (!empty($instance['flickrid']))?($instance['flickrid']):'101898334@N02';
		$flickrtemplate = (!empty($instance['flickrtemplate']))?($instance['flickrtemplate']):'<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>';
		$flickrnumber = (!empty($instance['flickrnumber']))?($instance['flickrnumber']):'9';

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		?>
			<ul class="flickrwg" data-id="<?php echo $flickrid;?>" data-num="<?php echo $flickrnumber;?>"></ul>
			<textarea style="display:none;" class="flickrtemplate"><?php echo $flickrtemplate; ?></textarea>


		<?php
		echo $after_widget;
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrid'] = strip_tags($new_instance['flickrid']);
		//$instance['flickrtemplate'] = strip_tags($new_instance['flickrtemplate']);
		$instance['flickrtemplate'] = (!empty($new_instance[ 'flickrtemplate' ])) ? ($new_instance[ 'flickrtemplate' ]) :'<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>';
		$instance['flickrnumber'] = strip_tags($new_instance['flickrnumber']);
		return $instance;
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ( isset( $instance[ 'title' ] ) ) ? ($instance[ 'title' ]) : ( __( 'Flickr', 'wpboot' ));
		$flickrid = (isset($instance[ 'flickrid' ])) ? (strip_tags($instance[ 'flickrid' ])) :'101898334@N02';
		$flickrtemplate = (isset($instance[ 'flickrtemplate' ])) ? (($instance[ 'flickrtemplate' ])) :'<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>';
		$flickrnumber = (isset($instance[ 'flickrnumber' ])) ? (int)(strip_tags($instance[ 'flickrnumber' ])) :'9';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('flickrid'); ?>">
		<?php _e('Flickr ID:', 'wpboot'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickrid'); ?>" name="<?php echo $this->get_field_name('flickrid'); ?>" type="text" value="<?php echo
			esc_attr($flickrid); ?>" /></p>
		<p> get your flickr id from <a href="//idgettr.com/">idgettr.com</a></p>
		<p><label for="<?php echo $this->get_field_id('flickrnumber'); ?>">
		<?php _e('Flickr number:', 'wpboot'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickrnumber'); ?>" name="<?php echo $this->get_field_name('flickrnumber'); ?>" type="text" value="<?php echo
			esc_attr($flickrnumber); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('flickrtemplate'); ?>">
		<?php _e('Flickr template:', 'wpboot'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('flickrtemplate'); ?>" name="<?php echo $this->get_field_name('flickrtemplate'); ?>" type="text"><?php echo esc_attr($flickrtemplate); ?></textarea>

		<?php
	}
} // class Wpboot_MoreFlickr
function myplugin_register_widgets() {
	register_widget( 'Wpboot_MoreFlickr' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );





/* enqueue js */
function Wpboot_MoreFlickrEnqueue() {
	wp_enqueue_script('jflickrfeed',plugins_url( '/js/jflickrfeed.min.js' , __FILE__ ),	array( 'jquery' ),'1.0',true);
	wp_enqueue_style('jflickrfeed',plugins_url( '/css/jflickrfeed.css' , __FILE__ ));
}

add_action( 'wp_enqueue_scripts', 'Wpboot_MoreFlickrEnqueue' );


/**
 * add inline script
 */
function Wpboot_MoreFlickrInline() {
  if ( wp_script_is( 'jquery', 'done' ) ) {
?>

<script>
	(function($){
		//want to load it after all page have been load, use it
		//$(window).on('load',function(){

		$(document).ready(function(){
			//just use it if you want make sure this plugin is working
			//alert('its working');
			$('.flickrwg').each(function(){
				$(this).jflickrfeed({
					limit:$(this).data('num'),
					qstrings:{
						id: $(this).data('id')
					},
					itemTemplate:$(this).next().text()
				});
			});
		});

	})(jQuery);
</script>

<?php
  }
}
add_action( 'wp_footer', 'Wpboot_MoreFlickrInline' );
?>