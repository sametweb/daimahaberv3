<?php

 
//Insert ads after second paragraph of single post content.

add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {
	
	$ad_code = '

<div class="thumb"><img src="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID) ).'" /></div>

';

	if ( is_single() && ! is_admin() ) {
		return prefix_insert_after_paragraph( $ad_code, 1, $content );
	}
	
	return $content;
}
 
// Parent Function that makes the magic happen
 
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}
	
	return implode( '', $paragraphs );
}



add_theme_support('post-thumbnails');

add_image_size( 'side-slide', 370, 270, true );
add_image_size( 'manset', 600, 270, true );

update_option("thumbnail_size_w", 119);
update_option("thumbnail_size_h", 89);
update_option("thumbnail_crop", 1);

update_option("medium_size_w", 180);
update_option("medium_size_h", 125);
update_option("medium_crop", 1);

update_option("large_size_w", 250);
update_option("large_size_h", 180);
update_option("large_crop", 1);

if (file_exists(TEMPLATEPATH.'/temapaneli.php')) include_once("temapaneli.php");

register_nav_menu("top-menu", "Top Menu");
register_nav_menu("site-menu", "Site Menu");

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name'          => "Index Page",
'id'            => 'index-page',
'description'   => '',
'before_widget' => '',
'after_widget' => '',
'before_title' => '',
'after_title' => '',
));


if ( function_exists('register_sidebar') )
register_sidebar(array(
'name'          => "Sidebar Right",
'id'            => 'sidebar-right',
'description'   => '',
'before_widget' => '<div class="blok">',
'after_widget' => '</div><div class="clear styled colored"></div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name'          => "Footer",
'id'            => 'footer',
'description'   => '',
'before_widget' => '<div class="blok">',
'after_widget' => '</div>',
'before_title' => '<div class="title">',
'after_title' => '</div>',
));

class SidebarSlider extends WP_Widget
{
  function SidebarSlider()
  {
    $widget_ops = array('classname' => 'SidebarSlider', 'description' => 'Sidebar\'a slider ekleyebilirsiniz.' );
    $this->WP_Widget('SidebarSlider', 'Sidebar Slider', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'showposts' => '' ) );
    $title = $instance['title'];
    $category = $instance['category'];
    $showposts = $instance['showposts'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Başlık: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('category'); ?>">Kategori: <br /><?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $category, 'hide_empty' => '0' ) ); ?></label></p>
  <p><label for="<?php echo $this->get_field_id('showposts'); ?>">Gösterilecek haber sayısı: <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo attribute_escape($showposts); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['category'] = $new_instance['category'];
    $instance['showposts'] = $new_instance['showposts'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
    $showposts = empty($instance['showposts']) ? ' ' : apply_filters('widget_showposts', $instance['showposts']);
 
    // WIDGET CODE GOES HERE ?>

<div id="sidebar-slider">
<div id="slider-side">
<?php query_posts("cat=".$category."&showposts=".$showposts); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
<div><div class="sidebar-manset-title"><?php the_title(); ?></div><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if(has_post_thumbnail()) { the_post_thumbnail("side-slide"); } ?></a></div>
<?php endwhile; endif; ?>
</div>
</div>
<div class="clear"></div>
<div id="sidebar-sayfalama">
<?php $i=1; query_posts("cat=".$category."&showposts=".$showposts); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
<div class="no"><a href="<?php the_permalink(); ?>" class="slider-a" title="<?php the_title(); ?>"><span><?php echo $i; ?></span></a></div>
<?php $i++; endwhile; endif; wp_reset_query(); ?>
</div>
<div class="clear styled colored"></div>
<?php
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("SidebarSlider");') );



class SidebarCategoryNews extends WP_Widget
{
  function SidebarCategoryNews()
  {
    $widget_ops = array('classname' => 'SidebarSlider', 'description' => 'Yan menüye belli bir kategorideki haberleri ekleyebilirsiniz.' );
    $this->WP_Widget('SidebarCategoryNews', 'Sidebar Kategori Haberleri', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'showposts' => '' ) );
    $title = $instance['title'];
    $category = $instance['category'];
    $showposts = $instance['showposts'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Başlık: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('category'); ?>">Kategori: <br /><?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $category, 'hide_empty' => '0' ) ); ?></label></p>
  <p><label for="<?php echo $this->get_field_id('showposts'); ?>">Gösterilecek haber sayısı: <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo attribute_escape($showposts); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['category'] = $new_instance['category'];
    $instance['showposts'] = $new_instance['showposts'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
    $showposts = empty($instance['showposts']) ? ' ' : apply_filters('widget_showposts', $instance['showposts']);
 
    // WIDGET CODE GOES HERE ?>

<div class="sidebar-kategori-haberleri">
<?php  if (!empty($title)) {
      echo $before_title . $title . $after_title; }
?>
<?php query_posts("cat=".$category."&showposts=".$showposts); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<div class="haber">
		<div class="resim"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if(has_post_thumbnail()) { the_post_thumbnail("thumb"); } ?></a></div>
		<div class="baslik"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
	<div class="clear"></div>
	</div>
<?php endwhile; endif; ?>
</div>
<div class="clear styled colored"></div>
<?php
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("SidebarCategoryNews");') );




class Yazarlar extends WP_Widget
{
  function Yazarlar()
  {
    $widget_ops = array('classname' => 'Yazarlar', 'description' => 'Sidebar\'a yazar bölümü ekleyebilirsiniz.' );
    $this->WP_Widget('Yazarlar', 'Yazarlar', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '' ) );
    $title = $instance['title'];
    $category = $instance['category'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Başlık: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('category'); ?>">Kategori: <br /><?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $category, 'hide_empty' => '0' ) ); ?></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['category'] = $new_instance['category'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
 
 
    // WIDGET CODE GOES HERE ?>

<?php  if (!empty($title)) {
      echo $before_title . $title . $after_title; }
?>




<div class="yazarlar">

<?php $catss = ""; 
query_posts("cat=".$category."&showposts=10"); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
<?php $categories = get_the_category(); ?>
<?php $varmi = strpos($catss, $categories[0]->category_nicename);
if ($varmi === false) {   ?>
<div class="yazar">
<img class="yazar-resmi" src="<?php bloginfo("template_directory"); ?>/yazarlar/<?php echo $categories[0]->category_nicename; ?>.jpg" alt="<?php echo $categories[0]->cat_name; ?>" title="<?php echo $categories[0]->cat_name; ?>" />
<p class="yazar-adi"><a href="<?php echo get_category_link($categories[0]->term_id); ?>" title="<?php echo $categories[0]->cat_name; ?> tüm yazıları"><?php echo $categories[0]->cat_name; ?></a></p>
<p class="yazar-yazisi"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
<div class="clear"></div>
</div>
<?php } ?>
<?php $catss .= $categories[0]->category_nicename.","; ?>
<?php endwhile; endif; wp_reset_query(); ?>
</div>




<?php
    echo $after_widget;
?>
<?php
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Yazarlar");') );






class SonDakika extends WP_Widget
{
  function SonDakika()
  {
    $widget_ops = array('classname' => 'SonDakika', 'description' => 'Sidebar\'a son dakika haber bölümü ekleyebilirsiniz.' );
    $this->WP_Widget('SonDakika', 'Son Dakika Haberleri', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'showposts' => '' ) );
    $title = $instance['title'];
    $category = $instance['category'];
    $showposts = $instance['showposts'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Başlık: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('category'); ?>">Kategori: <br /><?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $category, 'hide_empty' => '0' ) ); ?></label></p>
  <p><label for="<?php echo $this->get_field_id('showposts'); ?>">Gösterilecek haber sayısı: <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo attribute_escape($showposts); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['category'] = $new_instance['category'];
    $instance['showposts'] = $new_instance['showposts'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
    $showposts = empty($instance['showposts']) ? ' ' : apply_filters('widget_showposts', $instance['showposts']);
 
 
    // WIDGET CODE GOES HERE ?>

<?php  if (!empty($title)) {
      echo $before_title . $title . $after_title; }
?>
<?php query_posts("cat=".$category."&showposts=".$showposts); if( have_posts() ) : ?>
<div class="sondakika">
<?php while( have_posts() ) : the_post(); ?>
<p class="haber"><span class="kirmizi"><?php the_time("H:i"); ?> </span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
<?php endwhile; endif; wp_reset_query(); ?>
</div>
 <?php
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("SonDakika");') );











class IndexKategori extends WP_Widget
{
  function IndexKategori()
  {
    $widget_ops = array('classname' => 'IndexKategori', 'description' => 'Anasayfaya kategori haberleri ekleyebilirsiniz. 3 çeşit kategori haberi mevcuttur.' );
    $this->WP_Widget('IndexKategori', 'Kategori Haberleri', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'showposts' => '', 'type' => 'genis' ) );
    $title = $instance['title'];
    $category = $instance['category'];
    $showposts = $instance['showposts'];
    $type = $instance['type'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Başlık: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('category'); ?>">Kategori: <br /><?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $category, 'hide_empty' => '0' ) ); ?></label></p>
  <p><label for="<?php echo $this->get_field_id('showposts'); ?>">Gösterilecek haber sayısı: <input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo attribute_escape($showposts); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('type'); ?>">Görünüm Tipi: <br />
  <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="postform">
  <option class="level-0" value="onlu" <?php if($type=="onlu") {echo "selected=\"selected\""; } ?>>Onlu Kategori</option>
  <option class="level-0" value="resimli" <?php if($type=="resimli") {echo "selected=\"selected\""; } ?>>Resimli Kategori</option>
  <option class="level-0" value="resimli2" <?php if($type=="resimli2") {echo "selected=\"selected\""; } ?>>İkili Resimli Kategori</option>
  </select>
  </label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['category'] = $new_instance['category'];
    $instance['showposts'] = $new_instance['showposts'];
    $instance['type'] = $new_instance['type'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
    $showposts = empty($instance['showposts']) ? ' ' : apply_filters('widget_showposts', $instance['showposts']);
    $type = empty($instance['type']) ? ' ' : apply_filters('widget_type', $instance['type']);
 
    // WIDGET CODE GOES HERE ?>

<?php if($type=="onlu") { ?>
<?php $i=0; query_posts("cat=".$category."&showposts=".$showposts); if( have_posts() ) : ?>
<div class="onlu_kategori_haberleri">
<div class="tumunugor"><a href="<?php echo get_category_link($category); ?>" title="<?php echo $title; ?>">Tümü &raquo;</a></div>
<h2><?php echo $title; ?></h2>
<div class="haberler">
<?php while( have_posts() ) : the_post(); ?>
<?php if($i==0) { ?>
<div class="birinci">
<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="haber_kisa"><?php the_excerpt_rss(); ?></p>
</div>
<?php $i++; } else { ?>
<div class="haber"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">&raquo; <?php the_title(); ?></a></div>
<?php } ?>
<?php endwhile; ?>
<div class="clear"></div>
</div>
</div>
<div class="clear styled colored"></div>
<?php endif; wp_reset_query(); ?>
<?php } elseif($type=="resimli") { ?>
<div class="resimli_kategori_haberleri">
<div class="tumunugor"><a href="<?php echo get_category_link($category); ?>" title="<?php echo $title; ?> haberleri">Tümü &raquo;</a></div>
<h2><?php echo $title; ?></h2>
<?php query_posts("cat=".$category."&showposts=".$showposts); $i = 1; if(have_posts()) : while (have_posts()) : the_post(); ?>
<div class="haber<?php if($i%3==0) { echo " son"; } ?>">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if(has_post_thumbnail()) { the_post_thumbnail("medium"); } ?></a>
<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
</div>
<?php if($i%3==0) { echo "<div class='clear'></div>"; } ?>
<?php $i++; endwhile; endif; wp_reset_query(); ?>
</div>
<div class="clear styled colored"></div>
<?php } elseif($type=="resimli2") { ?>
<div class="resimli2_kategori_haberleri">
<div class="tumunugor"><a href="<?php echo get_category_link($category); ?>" title="<?php echo $title; ?> haberleri">Tümü &raquo;</a></div>
<h2><?php echo $title; ?></h2>
<?php query_posts("cat=".$category."&showposts=".$showposts); $i = 1; if(have_posts()) : while (have_posts()) : the_post(); ?>
<div class="haber<?php if($i%2==0) { echo " son"; } ?>">
<div class="p"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if(has_post_thumbnail()) { the_post_thumbnail("large"); } ?></a>

</div>
<?php if($i%2==0) { echo "<div class='clear'></div>"; } ?>
<?php $i++; endwhile; endif; wp_reset_query(); ?>
</div>
<div class="clear styled colored"></div>
<?php } ?>
<?php
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("IndexKategori");') );




function crunchify_social_sharing_buttons($content) {
	global $post;
	if(is_singular()){
	
		// Get current page URL 
		$crunchifyURL = urlencode(get_permalink());
 
		// Get current page title
		$crunchifyTitle = str_replace( ' ', '%20', get_the_title());
		
		// Get Post Thumbnail for pinterest
		$crunchifyThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
 
		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$crunchifyTitle.'&amp;url='.$crunchifyURL.'&amp;via=Crunchify';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$crunchifyURL;
		$googleURL = 'https://plus.google.com/share?url='.$crunchifyURL;
		$bufferURL = 'https://bufferapp.com/add?url='.$crunchifyURL.'&amp;text='.$crunchifyTitle;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$crunchifyURL.'&amp;title='.$crunchifyTitle;
		$whatsappURL = 'whatsapp://send?text='.$crunchifyTitle . ' ' . $crunchifyURL;
		
		// Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$crunchifyURL.'&amp;media='.$crunchifyThumbnail[0].'&amp;description='.$crunchifyTitle;
 
		// Add sharing button at the end of page/page content
		$variable .= '';
		$variable .= '<div class="crunchify-social">';
		$variable .= '<a class="crunchify-link crunchify-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>';
		$variable .= '<a class="crunchify-link crunchify-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>';
		$variable .= '<a class="crunchify-link crunchify-whatsapp" href="'.$whatsappURL.'" target="_blank">WhatsApp</a>';
		$variable .= '<a class="crunchify-link crunchify-googleplus" href="'.$googleURL.'" target="_blank">Google+</a>';
		$variable .= '<a class="crunchify-link crunchify-buffer" href="'.$bufferURL.'" target="_blank">Buffer</a>';
		$variable .= '<a class="crunchify-link crunchify-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>';
		$variable .= '<a class="crunchify-link crunchify-pinterest" href="'.$pinterestURL.'" target="_blank">Pin It</a>';
		$variable .= '</div>';
		
		return $variable.$content;
	}else{
		// if not a post/page then don't include sharing button
		return $variable.$content;
	}
};
add_filter( 'the_content', 'crunchify_social_sharing_buttons');





?>