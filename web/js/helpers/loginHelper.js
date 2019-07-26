var loginHelper = function()
{
	var self = this;

	this.init = function()
	{	    
	    // Radio del widget Sexo
        $("[for=usuario_sexo_" + $('[name="usuario[sexo]"]:checked').val() + "]" ).click();
	};
	
	this.init();
};