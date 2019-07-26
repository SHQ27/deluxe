var miCuenta = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.miCuentaHelper = new miCuentaHelper();
    };
    

    this.init();
};

$(document).ready( function() { new miCuenta(); } );