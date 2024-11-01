<?php

// // Genero il Widget da poter utilizzare sulle dynamic sidebar

class Centrico_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
                'Centrico_widget', __('Centrico Widget', 'centrico'), array(
            'classname' => 'Centrico_widget',
            'description' => __('A basic form for Centrico subscription', 'centrico')
                )
        );

        load_plugin_textdomain('centrico', false, basename(dirname(__FILE__)) . '/languages');
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $message = $instance['message'];
        $privacy = $instance['privacy'];
        $credits = $instance['credits'];

        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        echo $message;

        echo '<br>';
        echo do_shortcode('[centrico]');

        if (!jQuery) {
            wp_register_script('myjquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', true, '1.7.2', false);
            wp_enqueue_script('myjquery');
        }

        if ($privacy) {
            $url = esc_url(get_permalink($privacy));
            echo '<div style="color:#000">';
            echo '<input name="html" type="checkbox" value="html" checked="checked" id="chk"/> ';
            echo _e('I read and accept the ');
            echo '<a href="' . $url . '">';
            echo _e('Privacy Policy') . '</a>';
            echo '<br>';
            echo '</div>';
            echo '<script>
            ;(function($){
           $("#chk").click(function(){   
    $("#disabledInput").attr("disabled", !this.checked)
});
    })(jQuery);
  
      </script>';

            
        }
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
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['message'] = strip_tags($new_instance['message']);
        $instance['privacy'] = strip_tags($new_instance['privacy']);

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {

        $title = esc_attr($instance['title']);
        $message = esc_attr($instance['message']);
        $privacy = esc_attr($instance['privacy']);
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" placeholder="Es: Sign up our newsletter"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Additional text'); ?></label> 
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" placeholder="Insert a short description"><?php echo $message; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('privacy'); ?>"><?php _e('Privacy policy'); ?></label> 

            <?
            $args = array(
            'name' => $this->get_field_name('privacy'),
            'show_option_none' => 'None',
            'option_none_value' => '-1',
            'selected' => $instance['privacy']
            );
            wp_dropdown_pages( $args );
            ?>
        </p>

        <?php
    }

}

/* Register the widget */
add_action('widgets_init', function() {
    register_widget('Centrico_Widget');
});
