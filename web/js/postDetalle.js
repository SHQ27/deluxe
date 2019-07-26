var postDetalle = function()
{
	var thisClass = this;

	this.init = function()
	{
		$("form.recomendarPost").live("submit", function (ev) { thisClass.recomendarPost(ev, this); });
	}
	
	this.recomendarPost = function(ev, form)
	{
		ev.preventDefault();	

		$.ajax
		(
			{
			  type: "POST",
			  url: "/post/recomendar",
			  dataType: "json",
			  data: $(form).serialize(),
			  success: function(result)
			  			{
				  			if (result.status == 'OK')
				  			{
				  				$(document).trigger('close.facebox');
				  			}
				  			else
				  			{
				  				$('.recomendarPost div.alert').html(result.message);
				  			}
				  		}
			}
		);
		
	}
	
	this.init();   
}

$(document).ready( function() { new postDetalle(); } );