var login = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.loginHelper = new loginHelper();
        
        // Olvido de Pass
        $(".olvidastePass").click( function(){
            $("#olvidastePass").dialog({
                width: 445,
                height: 290,
                modal: true,
                resizable: false,
                zindex: 99999,
                dialogClass: "alert"
            });
            
            $(".ui-widget-overlay").click(function(){ $("#olvidastePass").dialog('close') });
            $("#olvidastePass .cerrar").click(function(){ $("#olvidastePass").dialog('close') });
        });
                
        if ( olvidastePass ) {
            $(".olvidastePass").click();
        }
        
        // Shoppear
        if (window.top != window.self)
        {
            $("#loginShoppear").show();
            $("#loginNormal").hide();
        }
        else
        {
            $("#loginShoppear").show();
            $("#loginShoppear").hide();
        }        
        
    };
    

    this.init();
};

$(document).ready( function() { new login(); } );