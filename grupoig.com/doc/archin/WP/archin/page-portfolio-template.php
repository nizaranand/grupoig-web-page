<?php
/*
Template Name: Portfolio Page Template
*/
?>
<?php 
    
	$items_limit = get_option("arc_portfolio1_item_limit");
	$items_limit =  (!$items_limit) ? 6 : $items_limit ; 
	
	
	$limit = get_option("arc_portfolio1_limit");
    $limit = (int) (!$limit) ? 250 : $limit;
	$label = get_option("arc_blurb_label");
   	// echo $limit;
get_header();
   
 ?>   


<div class="blurb-wrapper">

            <div class="blurb clearfix">
          <p class="custom-font"><?php echo get_option("arc_blurb_text"); ?></p>
          <?php if($label) : ?> <a href="<?php echo get_option("arc_blurb_link"); ?>"> <?php echo $label; ?></a> <?php endif; ?>
          </div>

</div>
 <div class="page-body-wrapper"></div>    
 
<div class="container clearfix page">

       
   	<div class="<?php if($sidebar=="true") echo 'two-third-width'; else echo 'full-width';  ?>">
        <div class="clearfix content-wrapper">
         	<?php 	if(have_posts()): while(have_posts()) : the_post(); ?>
            
            <div class="title">
            <h4 class="custom-font heading"> <?php the_title(); ?></h4>
            </div>
            <?php endwhile; endif; ?>
            
            <div class="page-content">
			  
              <div class="breadcrumb clearfix"><?php $helper->the_breadcrumb();?></div>
			  
              <div class="portfolio-taxonomy clearfix">
                    <ul class="clearfix">
                      <li class="active"><a href="#"> All </a></li>  
                      <?php  wp_list_categories("&title_li=&taxonomy=portfoliocategory");  ?> 
                     </ul>
               </div>
                   
              
              <div class="content clearfix">
                  
                
              <div class="portfolio-one-column portfolio">
              
              <?php $helper->showPortfolioPosts(array( "post_type"=>"portfolio" , "image_width"=> 451 , "image_height"=> 250, 'extras' => true , 'content_limit' =>$limit ,  'clear' => 1 , 'limit'=> $items_limit ));  ?>
              
              </div>
                  
               <?php kriesi_pagination(); ?>
            
            
            </div>
            
			
                  
                
             </div>     
          </div>
    </div><!-- End of two third column -->
    
	<?php wp_reset_query(); ?>
</div>
<?php get_footer(); ?>
      