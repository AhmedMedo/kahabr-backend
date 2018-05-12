   /**
      This javascript file for handeling all search functions and render results to front end

   */

   $(document).ready(function(){  
        var home_skip=20;
        var feed_skip=20;
        var result_skip=20;
        $('#feed_list').addClass('active');
		
		

        
       // $('#a').attr('src',Cookies.get('country'));
       //Cookies.set('country',$('#selected_country').data('country'));

       //alert(Cookies.get('country'));

       Cookies.remove('search_text');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      $('#search_form').submit(function(){

        var search_text=$('#search_text').val();
        Cookies.set('search_text',search_text);
         var country=$('#hidden_country').attr('value');
        var language=$('#hidden_language').attr('value');
        //alert(Cookies.get('country'));
       
        $.ajax({
                                 type: "POST",
                                 url: 'ajax/result',
                                 data:{search_text:search_text,country:country,language:language},
                                 beforeSend: function(){
                                     $('#loadingDiv').show();
                                 },
                                 success: function(data)
                                 {  

                                         $('#loadingDiv').hide();
                                         //change page title


                                         //load contnet
                                         $('.page-title').html('<h2><span class="fa fa-search"></span> Search Result for <strong>'+search_text+'</strong></h2>');
                                        
                                         $('#content').html(data);

                                        
                                 }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                     $('#loadingDiv').hide();
                                     $('#content').html('<h2 class="text-center"> Error</h2>');
                                     } 
                                   });








        return false;

      });

      $('#countries >div >div a').on('click',function(){
          var old_image=$('#main_country').attr('src');
          var img=$(this).find('img').attr('src');
          //alert($(this).data('country'));
          $(this).find('img').attr('src',old_image);
          $('#main_country').attr('src',img);



          var old_country=$('#orginal_country').attr('data-country');
          var selected_country=$(this).attr('data-country');
          $(this).attr('data-country',old_country);
          $('#orginal_country').attr('data-country',selected_country);

         $('#hidden_country').attr('value',$('#orginal_country').attr('data-country'));



         //update feed lists with feeds related to this country
          var country=$('#hidden_country').attr('value');
          var language=$('#hidden_language').attr('value');
          //var search_text=$('#search_text').val();
            $.ajax({
                                 type: "POST",
                                 url: 'ajax/feedlist',
                                 data:{country:country,language:language},
                                 beforeSend: function(){
                                     $('#loadingDiv').show();
                                 },
                                 success: function(data)
                                 {  
                                     $('#loadingDiv').hide();

                                    $('#feeds').html(data);
                                           $('#feeds  li').click(function(){
                            //var type=$(this).parent().attr("id");

                                                var selected_feed=$(this).text();
                                                $('#feed_title').html(selected_feed);

                                                 $.ajax({
                                                     type: "POST",
                                                     url: 'ajax/feednews',
                                                     data:{selected_feed:selected_feed,search_text:search_text},
                                                     beforeSend: function(){
                                                         $('#loadingDiv').show();
                                                     },
                                                     success: function(data)
                                                     {  

                                                            $('#loadingDiv').hide();
                                                            //alert(data.img);
                                                            $('#content').html(data);
                                                            $('#content').css({'height':($(document).height())+'px'});


                                                            
                                                     }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                                        //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                                         $('#loadingDiv').hide();
                                                         $('#content').html('<h2 class="text-center"> Error</h2>');
                                                         } 
                                                       });


                                               });


                                        
                                 }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                     $('#loadingDiv').hide();
                                     } 
                                   }); 



			if(Cookies.get('search_text'))
			{	
				var data={country:country,language:language,search_text:Cookies.get('search_text')};
			}else{
				var data={country:country,language:language};
				
			}
		 
        $.ajax({
                                 type: "POST",
                                 url: 'ajax/newsbycountry',						 
                                 data:data,
                                 beforeSend: function(){
                                     $('#loadingDiv').show();
                                 },
                                 success: function(data)
                                 {  
                                     $('#loadingDiv').hide();

                                      $('#content').html(data);
                                      $('#content').css({'height':($(document).height())+'px'});
									  

                                          


                                        
                                 }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                     $('#loadingDiv').hide();
                                     } 
                                   }); 






          



      });

      $('#languages >div >div a').on('click',function(){
          var old_lang=$('#lang').html();

          var lang=$(this).find('strong').html();

          //Cookies.set('language', lang, { expires: 7 });
          $('#lang').html(lang);
          $(this).find('strong').html(old_lang);

        $('#hidden_language').attr('value',$('#lang').html());

        //change homepage body to choosen language
          var country=$('#hidden_country').attr('value');
          var language=$('#hidden_language').attr('value');
          //var search_text=$('#search_text').val();
			if(Cookies.get('search_text'))
			{	
				var data={country:country,language:language,search_text:Cookies.get('search_text')};
			}else{
				var data={country:country,language:language};
				
			}
        $.ajax({
                                 type: "POST",
                                 url: 'ajax/newsbycountry',
                                 data:data,
                                 beforeSend: function(){
                                     $('#loadingDiv').show();
                                 },
                                 success: function(data)
                                 {  
                                     $('#loadingDiv').hide();

                                      $('#content').html(data);
                                      $('#content').css({'height':($(document).height())+'px'});

                                                


                                        
                                 }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                     $('#loadingDiv').hide();
                                     } 
                                   }); 





      });
             $(document).on('click', '#btn_more', function(){  

                           //var date = $(this).data("date");
                                     var country=$('#hidden_country').attr('value');
                                    var language=$('#hidden_language').attr('value');

                          
                           $('#btn_more').html("Loading..."); 
                           $.post("ajax/more",{country:country,language:language,skip:home_skip}, function(data, status){
                               if(data != '')  
                                     {  
                                          $('#remove-btn').remove();  
                                          $('#links').append(data);  
                                          home_skip=home_skip+20;
                                          
                                     }  
                                     else  
                                     {  
                                          $('#btn_more').html("No Data");  
                                     } 

                                 

                            });  

                      });
             $('#feeds  li').click(function(){
				 
                 var selected_feed=$(this).text();

				 if(Cookies.get('search_text'))
					{	
						var data={selected_feed:selected_feed,search_text:Cookies.get('search_text')};
					}else{
						var data={selected_feed:selected_feed};
						
					}
                          // var search_text=$('#search_text').val();
                            $('#feed_title').html(selected_feed);
                             $.ajax({
                                 type: "POST",
                                 url: 'ajax/feednews',
                                 data:data,
                                 beforeSend: function(){
                                     $('#loadingDiv').show();
                                 },
                                 success: function(data)
                                 {  



                                        $('#loadingDiv').hide();
                                        $('#content').html(data);
                                        $('#content').css({'height':($(document).height())+'px'});
                                        $('.xn-openable').removeClass('active');

                                        
                                 }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                                     $('#loadingDiv').hide();
                                     $('#content').html('<h2 class="text-center"> Error</h2>');
                                     $('#content').css({'height':($(document).height())+'px'});

                                     } 
                                   });


                           });

                   $(document).on('click', '#news_more', function(){  
                           var title=$(this).data("title");
                           var type=$(this).data("type");
                          //var search_text=$('#search_text').val();
						  if(Cookies.get('search_text'))
						  {
							  var data={title:title,skip:feed_skip,search_text:Cookies.get('search_text')};
						  }else{
							  var data={title:title,skip:feed_skip}
						  }
                           $('#news_more').html("Loading..."); 
                           $.post("ajax/morefeednews",data, function(data, status){
                               if(data != '')  
                                     {  
                                          $('#remove-btn').remove();  
                                          $('#links').append(data);  
                                          feed_skip=feed_skip+20;
                                     }  
                                     else  
                                     {  
                                          $('#news_more').html("No Data");  
                                     } 

                            });  
                      }); 

               


          $(document).on('click', '#result_more', function(){
           var country=$('#hidden_country').attr('value');
        var language=$('#hidden_language').attr('value');
        //alert(Cookies.get('country'));  
          var search_text=$(this).data('key');
           $('#result_more').html("Loading..."); 
           $.post("ajax/moreresult",{search_text:search_text,skip:result_skip,country:country,language:language}, function(data, status){
               if(data != '')  
                     {  
                          $('#remove-btn').remove();  
                          $('#links').append(data); 
                           result_skip=result_skip+20;
 
                     }  
                     else  
                     {  
                          $('#result_more').html("No Data");  
                     } 


            });  
      });
                    
         

     



  
   

     




       
 });