<?php
/**
 * Footer
 * @package amberalert
 * @since 0.0.1
 * @author Edward de Leau <e@leau.net>, http://wp.leau.co
 * @copyright GPL 2 */
namespace leau\co\amberalert_client;


if (!class_exists('\\leau\co\ambertalert_client\\amber_alert_widget'))
{
	/**
	 * Widget: Show amber alert icons
	 * @since 0.0.1
	 * @author Edward de Leau <e@leau.net>, {@link http://wp.leau.co}
	 */
	class amber_alert_widget extends \WP_Widget {

		/**
		 * Constructor
		 */
		function __construct()
		{
			$widget_ops = array('classname' => 'amber_alert_widget', 'description'
					=> __('Toont de Amber Alert button. Daarnaast volgt een paar keer per jaar een popup.'));
			$control_ops = array('width' => 200, 'height' => 350);
			parent::__construct('amber_alert_widget', __('Amber Alert Button'), $widget_ops, $control_ops);
		}

		/**
		 * (non-PHPdoc)
		 * @see WP_Widget::widget()
		 */
		function widget($args, $instance) {
			extract( $args );
			echo $before_widget;
			$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ( !empty( $title ) ) {
				echo $before_title . $title . $after_title;
			}
				
			$size = empty($instance['size']) ? 16 : $instance['size'];
			$instance['text'] = $this->specificOutput($size);
			$text = apply_filters( 'widget_text', $instance['text'], $instance );
			echo $text;
				
			echo $after_widget;
		}

		/**
		 * (non-PHPdoc)
		 * @see WP_Widget::update()
		 */
		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			$instance['title'] = empty($new_instance['title']) ? 'Amber alert' : apply_filters('widget_title', $new_instance['title']);
			$instance['size'] =  $new_instance['size'];
			return $instance;
		}

		/**
		 * (non-PHPdoc)
		 * @see WP_Widget::form()
		 */
		function form($instance)
		{
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'size' => '' ) );
			$title = strip_tags($instance['title']);
			$size = esc_textarea($instance['size']);
			?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input 	class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:'); ?></label>
		<select id="<?php echo $this->get_field_id('size'); ?>"
				name="<?php echo $this->get_field_name('size'); ?>">
		<option <?php if ($size == "16") echo 'selected'; ?> value="16">16x16</option>		
		<option <?php if ($size == "32") echo 'selected'; ?> value="32">32x32</option>
		<option <?php if ($size == "48") echo 'selected'; ?> value="48">48x48</option>
		<option <?php if ($size == "64") echo 'selected'; ?> value="64">64x64</option>		
		</select></p>
		<?php
		}

		/**
		 * The specific output for this widget
		 * Enter description here ...
		 */
		function specificOutput($size='16')
		{
			$output='';			
			$output = 
			'<script type="text/javascript" src="http://www.amberalertnederland.nl/flashalert/javascript/FlashAlert_'.$size.'x'.$size.'.js?uid=e4fb7590-db30-4897-af00-79a821d0414e"></script>' .
			'<div id="primaryFlash"></div>' .
			'<div id="popupFlash" style="position: absolute;' .
			'z-index: 99999999;' .
			'left: 50%;' .
			'top: 50%;' .
			'margin: -165px auto auto -250px;' .
			'width: 500px;' .
			'height: 375px;' .
			'display: none;">' .
			'<span id="popupFlashCnt"></span>' .
			'</div>';
			/* generates this:
			$uri = 'http://www.amberalertnederland.nl/flashalert/';
			$javascript = '<script src="'.$uri.'javascript/FlashAlert_' . $size . 'x'. $size
			 . '.js?uid=e4fb7590-db30-4897-af00-79a821d0414e" type="text/javascript" />';
			$swf_object_closed = '<object width="' . $size . 'px" height="' . $size
			 . 'px" type="application/x-shockwave-flash" id="s01" name="s01" '
			 . 'data="'. $uri .'closed_' . $size . 'x' . $size . 'swf">'
			 . '<param name="allowscriptaccess" value="always"/>'
			 . '<param name="wmode" value="transparent"/></object>';
			$div_popup = '<div style="position: absolute; z-index: 99999999; left: 50%; top: 50%; '
			. 'margin: -165px auto auto -250px; width: 500px; height: 375px; display: none;" '
			. 'id="popupFlash">';
			$swf_object_open = '<object width="500px" height="375px" '
			. 'type="application/x-shockwave-flash" id="s02" name="s02" '
			. 'data="' . $uri. 'opened.swf">'
			. '<param name="allowscriptaccess" value="always"/>'
			. '<param name="wmode" value="transparent"/></object>';
			
			$output = $javascript . $swf_object_closed . $div_popup . $swf_object_open;
			*/
			return $output;
		}

	}
}


if (!class_exists('\\leau\co\ambertalert_client\\automatisch_footer'))
{
	class automatisch_footer extends Plugin
	{
		
		function AddFilter()
		{
			// when the use chooses automatic then add it to the footer invisble
			if (1 == Config::GetOptionsArrayValue(Config::GetPluginSlug() . 'show_in_footer'))
			{			
				add_action('wp_footer', array($this,'ExecuteFilter'), 6, 1);
			}	
			// otherwise add a widget
			else
			{
				// @todo load widget conditionally
				//add_action('widgets_init', 'amber_alert_widget', 1);
				//{
	     		//	return register_widget('\leau\co\amberalert_client\amber_alert_widget');
				//});				
			}
		}
		
		function ExecuteFilter($footer)
		{
			echo '<script type="text/javascript" src="http://www.amberalertnederland.nl/flashalert/javascript/FlashAlert_0x0.js?uid=1a3a0fc0-0975-40bf-bef8-31fdc3df7652"></script>';
			echo '<div id="primaryFlash"></div>';
			echo '<div id="popupFlash" style="position: absolute; z-index: 99999999; left: 50%; top: 50%; margin: -165px auto auto -250px; width: 500px; height: 375px; display: none;"><span id="popupFlashCnt"></span></div>';
		}				
	}
}

add_action('widgets_init',function()
{
	return register_widget('\leau\co\amberalert_client\amber_alert_widget');
});

