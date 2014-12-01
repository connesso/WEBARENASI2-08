  window.fbAsyncInit = function() {
    FB.init({
      appId      : '739533262795662',
      status      : true,
      cookie      : true,
      xfbml      : true,
      oauth      : true
    });
  };

  (function(d){
     var js, id = 'facebook-jssdk';
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id;
     js.async = true;
     js.src = "//connect.facebook.net/fr_FR/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
   
   
 jQuery(function($){
     
     $('.facebookConnect').click(function(){
         var url = $(this).attr('href');
         FB.login(function(response){
             if(response.authResponse){
                 window.location = url;
             }
         },{scope : 'email'});
         return false;
     });
       
});
