var fallados = function()
{	
	this.init = function()
	{
	    $(".restablecer").click( function(){
	        $(".sf_admin_filter_field_buscador select").val("");
	        $(".sf_admin_filter form").attr('action', $(".sf_admin_filter form").attr('action') + "?page=1");
	        $(".filtrar").click();
	    } );
	    
	    $("#sf_admin_list_batch_checkbox").click( function(){
	        if ( $("#sf_admin_list_batch_checkbox:checked").length ) {
	            $(".sf_admin_row .sf_admin_batch_checkbox").attr('checked','checked');
	        } else {
	            $(".sf_admin_row .sf_admin_batch_checkbox").removeAttr('checked');
	        }    
	    } );
	    
	    $(".sf_admin_batch_actions_choice .submit").click( function(){
	        if ( $(".sf_admin_batch_actions_choice .batch_action").val() == 'RECUPERAR' )
            {
	            var ids = [];
	            
	            $(".sf_admin_row .sf_admin_batch_checkbox:checked").each(
                    function(i, e){ 
                        ids.push( $(e).val() );
                    }
                );
	            
	            window.location = '/backend/fallados/recuperar?ids=' + ids.join(',');
            }
	    } );
	    
	}
	
	this.init();   
}

$(document).ready( function() { new fallados(); } );