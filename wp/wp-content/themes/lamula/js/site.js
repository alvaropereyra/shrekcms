$(document).ready(function() {
	
	 BACK = "todas";
	 BACK_STATES = "regresar";
   from_outside = true;
	 LAST_STATE = "";
	
	 // $('div#menu_bar a').click(function () { 
	 //      
	 //      $.get(this.href, function(data){
	 //    	  //alert("Data Loaded: " + data);
	 //    	  $('div#featured').html(data);
	 //    	  //$('div#featured').innerHtml(data);
	 //    	});
	 //      return false;
	 //    });

	 
   $("div.scrollable").scrollable({
	
			 size: 3
	
		});     
	
		//TODO agregarle los nombres de los enlazados.. ahora mismo :D
		 //fancybox
		 $('div.post_content a[rel="uploaded_photo"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 $('div.post_content a[rel="uploaded_image"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 
		 $('div.post_content a[rel="uploaded_audio"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		 $('div.post_content a[rel="uploaded_doc"]').fancybox({
			 'zoomOpacity' : true,
			 'overlayShow' : true,
			 'zoomSpeedIn' : 500,
			 'zoomSpeedOut' : 500			 
			 
		 });

		$("div.top_news_featured:not(:first)").hide();
		$("div.class_content:not(:first)").hide();
		$("div.tab_content:not(:first)").hide();
		$("div.sidebox_content:not(:last)").hide();
		$("div.posts_last_content:not(:first)").hide();
				

		$("div.top_news_item h3 a").click(function(){
			
			$(this).parent().parent().siblings().removeClass("portada-active");
			$(this).parent().parent().addClass("portada-active");
			
			var index = $("div.top_news_item h3 a").index(this);
			
			$(".top_news_featured").hide();
			
			$(".top_news_featured:eq(" + index + ")").show();					
				
			return false;
		})
		
		$("ul#lasts_posts li a").click(function(){
			
			$(this).parent().siblings().find("a").removeClass("active");
			$(this).addClass("active");
			
			var index = $("ul#lasts_posts li a").index(this);
			
			$(".posts_last_content").hide("slow");
			
			$(".posts_last_content:eq(" + index + ")").show("fast");					
				
			return false;
		})
	
		$("ul#category_tabs li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("active");
				$(this).addClass("active");
				
				var index = $("ul#category_tabs li a").index(this);
				
				$(".class_content").hide("slow");
				
				$(".class_content:eq(" + index + ")").show("fast");					
					
				return false;
		})
		
		$("ul#corresponsales li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#corresponsales li a").index(this);
				
				$(".tab_content").hide("slow");
				$(".tab_content:eq(" + index + ")").fadeIn("fast");
				return false;
		})

		$("ul#articulos_menu li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#articulos li a").index(this);
				
				$("articulos .sidebox_content").hide("slow");
				$("articulos .sidebox_content:eq(" + index + ")").fadeIn("fast");
				return false;
		})	

		$("ul#ranking_menu li a").click(function(){
		
				$(this).parent().siblings().find("a").removeClass("selected");
				$(this).addClass("selected");
				
				var index = $("ul#articulos li a").index(this);
				
				$("ranking .sidebox_content").hide("slow");
				$("ranking .sidebox_content:eq(" + index + ")").fadeIn("fast");
				return false;
		})	


		$("ul#menu > li.f > a").click(function(){
			
			
						father = $(this).parent();

						//Hides all the siblings
						father.siblings().toggle("fast");
						father.siblings().removeClass("current");
						$(this).addClass("current");
			
						//Shows all the childs "li"
						childs = father.find("li");
						childs.toggle("fast");
		
					// load stuff 
							$(".top_news_item").hide("slow");
							$("#featured.top_news_featured h3").hide("fast");		
							
							$("#featured.top_news_featured .top_news_featured_content").hide("fast");		
							
								location.hash = "#" + $(this).text();
		//					$("#featured.top_news_featured h3 a").text("Noticias desde " + $(this).text());		

							$("#featured.top_news_featured h3").show("fast");		
							$("#featured.top_news_featured .top_news_featured_content").show("fast");		

							$(".top_news_item").show("slow");						
					
						//Setups get back content
						//TODO: I hate how this works
						if ($(this)[0].textContent != BACK){
				
							$(this)[0].textContent = BACK;
							$(this).addClass("current_option");
											
						}
						else {

							$(this)[0].textContent = childs[0].innerHTML;
							$(this).removeClass("current_option");				
						}
		
			
		});
		
		
			$("ul#menu li ul > li.s a").click(function(){

				//alert();

					father = $(this).parent();

					//Hides all the siblings
					//Shows all the childs "li"
					childs = father.find("ul");
			//		alert ( childs.children().length );

						if (childs.children().length > 1 ) { 

						father.siblings().toggle("fast");
						father.siblings().removeClass("current");
						$("li.s a").removeClass("current_option");
						$(father.siblings()[0]).addClass("current");

						childs.toggle("fast");

						//Setups get back content
						//TODO: I hate how this works
						
						// load stuff 
						$(".top_news_item").hide("slow");
									$("#featured.top_news_featured h3").hide("fast");		
								
									$("#featured.top_news_featured .top_news_featured_content").hide("fast");		
								
									location.hash = "#" + $(this).text();
								// $("#featured.top_news_featured h3 a").text("Noticias desde " + $(this).text());		
								
									$("#featured.top_news_featured h3").show("fast");		
									$("#featured.top_news_featured .top_news_featured_content").show("fast");		
								
									$(".top_news_item").show("slow");						
	
			//				$(this)[0].textContent = BACK_STATES;
						if (from_outside)
						{
								from_outside = false;
								$(this).addClass("current_option");							
						}
						else 
							{
								from_outside = true;
							}

					
					}

			});
	
	
		       var skin = {};
               skin['BORDER_COLOR'] = 'transparent';
               skin['ENDCAP_BG_COLOR'] = 'transparent';
               skin['ENDCAP_TEXT_COLOR'] = '#333333';
               skin['ENDCAP_LINK_COLOR'] = '#0000cc';
               skin['ALTERNATE_BG_COLOR'] = 'transparent';
               skin['CONTENT_BG_COLOR'] = 'transparent';
               skin['CONTENT_LINK_COLOR'] = '#0000cc';
               skin['CONTENT_TEXT_COLOR'] = '#333333';
               skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
               skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
               skin['CONTENT_HEADLINE_COLOR'] = '#333333';
               skin['HEADER_TEXT'] = 'Historias recomendadas';
               skin['RECOMMENDATIONS_PER_PAGE'] = '5';
               google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
               google.friendconnect.container.renderOpenSocialGadget(
                { id: 'div-6886351088514799323',
                  url:'http://www.google.com/friendconnect/gadgets/recommended_pages.xml',
                  site: '18025864853307811361',
                  'view-params':{"docId":"recommendedPages"}
                },
                 skin);
			
});
