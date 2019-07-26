var contacto = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.contactoHelper = new contactoHelper();        
    };


    this.init();
};

$(document).ready( function() { new contacto(); } );