<?php 


class FeaturePost extends WP_Widget {
	
	function FeaturePost() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'FeaturePost', 'description' => __('Show posts or recent work in style.','h-framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Feature Posts",'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['count']= strip_tags($new_instance['count']); 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['post_type']= strip_tags($new_instance['post_type']); 
			return $instance;
	}
	function form($instance) {
		 
		$count = esc_attr($instance['count']);
			$title = $instance['title'];
		$post_type = $instance['post_type'];	
	
		 ?>
        
        <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_type'); ?>"> <?php _e('Post Type','h-framework'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
		 <?php 
		 $array = array("popular","recent","featured","portfolio");
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		 ?>
        </select>
		</p>
        
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        
		<p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('count'); ?>"> <?php _e('Number of posts to display','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
		
           
       
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	global $more;
	extract($args); 
	$post_type = $instance['post_type'];	
		$count = esc_attr($instance['count']);
	$title = esc_attr($instance['title']);
		echo $before_widget;
		if($title!="")
		echo "<h5 class='custom-font widget-posts-title' > ".$instance['title']." </h5>";
		?>

 <ul class="widget-posts clearfix" >
            			<?php 
						$popPosts = new WP_Query();
						
						if($post_type=="popular")
						$popPosts->query('caller_get_posts=1&showposts='.$count.'&orderby=comment_count');
					    else if($post_type=="recent")
						$popPosts->query('caller_get_posts=1&showposts='.$count.'&orderby=date&order=DESC');
						else if($post_type=="featured") 
						$popPosts->query('showposts='.$count.'&tag=featured');
						else if($post_type=="portfolio") 
						$popPosts->query('showposts='.$count.'&post_type=portfolio');
						 
						while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0;?>
                        
                        <li class="clearfix" >
                        	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
                            <div class="image">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(216,9999)); ?></a>
                            </div><!--image-->
                            <?php endif; ?>
                            
                            <div class="description">
                                <h3 ><a href="<?php the_permalink(); ?>"><?php $this->shortenContent(50,strip_shortcodes( get_the_title() )); ?></a></h3>
                                <p><?php $this->shortenContent(60,strip_shortcodes( strip_tags(get_the_content()))); ?></p>
                            </div><!--details-->
                        </li>
                        
                        <?php endwhile; ?>
                        
                        <?php wp_reset_query(); ?>

                    </ul>
					
					
		<?php
			echo $after_widget; 
		
		}
		
	function shortenContent($num,$stitle) {
	
	$limit = $num+1;
	if (!strnatcmp(phpversion(),'5.2.10') >= 0) 
	$title = str_split($stitle);
	else
	$title = $this->str_split_php4_utf8($stitle);
	$length = count($title);
	if ($length>=$num) {
	    $title = array_slice( $title, 0, $num);
	    $title = implode("",$title)."...";
	    _e( $title, 'h-framework');
	  } else {
	    _e( $stitle, 'h-framework');
	  }
	}
	
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("FeaturePost");'));
?>