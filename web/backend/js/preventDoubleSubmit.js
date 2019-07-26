var preventDoubleSubmit = function()
{	
	this.init = function(divContentForm)
	{
		$('.' + divContentForm + ' form').submit( function(e) {

			if ( $(this).data('submitted') === true ) {
				e.preventDefault();
			} else {
				$(this).data('submitted', true);
				$('.' + divContentForm + ' input[type=submit]').last().after('<span class="procesando">Procesando...</span>');
			}
		});
	};
};

var preventDoubleSubmit;
$(document).ready( function() { preventDoubleSubmit = new preventDoubleSubmit(); } );