var moveInterface = function()
{
	var thisClass = this;
	
	
	this.init = function()
	{
		this.moveButtons();
	}
	
	this.moveButtons = function()
	{
		$(".sf_admin_action_new").parents("form").prepend('<ul class="sf_admin_actions"></ul>');
		var div = $(".sf_admin_action_new");
		$(".sf_admin_actions").first().append( div.get(0) );
		var div = $(".sf_admin_action_ver");
		$(".sf_admin_actions").first().append( div.get(0) );
	}	
	
	this.init();   
}

$(document).ready( function() { new moveInterface(); } );