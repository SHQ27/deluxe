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
                width: 488,
                height: 380,
                modal: true,
                resizable: false,
                zindex: 99999
            });
            
            $(".ui-widget-overlay").click(function(){ $("#olvidastePass").dialog('close') });
            $("#olvidastePass .cerrar").click(function(){ $("#olvidastePass").dialog('close') });
        });
                
        if ( olvidastePass )
        {
            $(".olvidastePass").click();
        }        
    };
    

    this.init();
};

$(document).ready( function() { new login(); } );