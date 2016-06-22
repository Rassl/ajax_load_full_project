<?php

function cots_style_n_scritps(){
	wp_enqueue_style('dashicons');
	wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css'  );
	wp_enqueue_style('child-style', get_stylesheet_directory_uri().'/style.css', array('parent-style')  );
	wp_enqueue_script('ajax_load_js', get_stylesheet_directory_uri().'/js/ajax_load.js', array('jquery')  );
	wp_localize_script( 'ajax_load_js', 'ajaxloadpost', array(
		'url'=> admin_url('admin-ajax.php'),
		'request_uri'=>$_SERVER[REQUEST_URI]
	) );
	
}

add_action('wp_enqueue_scripts', 'cots_style_n_scritps');

// redirect if user want to access post by pagination Example:http://localhost/ajax/page/2/
function cots_redict_user_if_access_bypagination_url(){
	$full_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if(strchr($full_url, '/page/')){
		if(get_option('page_for_posts')){
			wp_redirect( esc_url(get_permalink(get_option('page_for_posts'))), 301 );
			exit();
			
		}else{
			wp_redirect( esc_url( home_url( ) ), 301 );
			exit();
			
		}
		
		
	}
	
	
	
	
}
add_action('template_redirect', 'cots_redict_user_if_access_bypagination_url');


function cots_ajaload_function (){
	$page = $_POST['page'] + 1;
// the query
$the_query = new WP_Query( array(
	'post_type'=>'post',
	'paged' => $page

) ); 

 if ( $the_query->have_posts() ) :

	
	while ( $the_query->have_posts() ) : $the_query->the_post(); 
	set_query_var( 'newpost', 'newpost' );
		get_template_part( 'template-parts/content', get_post_format() );
	endwhile;
	
endif;
	 wp_reset_postdata();

die();	
}
add_action('wp_ajax_ajax_load_post_action', 'cots_ajaload_function');
add_action('wp_ajax_nopriv_ajax_load_post_action', 'cots_ajaload_function');