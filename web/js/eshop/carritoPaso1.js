var carritoPaso1 = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.carritoPaso1Helper = new carritoPaso1Helper();
    };
    

    this.init();
};

$(document).ready( function() { new carritoPaso1(); } );