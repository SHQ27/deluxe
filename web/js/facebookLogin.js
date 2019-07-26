var facebookLogin = function(appId, redirect)
{
    var thisClass = this;
    this.appId = appId;
    this.redirect = redirect;

    this.init = function()
    {       
        FB.init({
            appId      : thisClass.appId,
            status     : true,
            cookie     : true,
            xfbml      : true 
          });
    }
    
    this.login = function()
    {

        FB.login(function(response) {
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function(response) {
                    window.location = thisClass.redirect;
                });
            }
        }, {scope: 'email'} );

    }


    
    this.init();   
}