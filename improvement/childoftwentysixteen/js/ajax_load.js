jQuery(document).ready(function($){
	
	$(document).on('click', '.load-btn', function(){
		var that = $(this);
		var page = that.data('page');
		var newpage = page + 1;
		that.addClass('its-loading');
		$.ajax({
			url:ajaxloadpost.url,
			type: 'POST',
			data:{
			page: page,
			action:'ajax_load_post_action'
				
			},
			error:function(response){
				alert(response);
				
			},
			success:function(response){
				if(response == ''){
					 that.remove();
					$('.load-container').html('<h2 class="nomorepost">NO MORE POST FOUND</h2>');
					
				}else{
					setTimeout(function(){
					
					$('body.blog main#main').append(response);
					that.data('page', newpage );
					that.removeClass('its-loading');
					$('.site-main article.newpost').hide().slideDown(500).removeClass('newpost');
					window.history.pushState('New Page', 'Page', ajaxloadpost.request_uri + 'page/' + newpage );
					
				}, 800 );
				}
				
				
				
			}
			
			
		});// ajax function end
		
		
		
		
		
	} );// click function end
	
	
	
	
	
});