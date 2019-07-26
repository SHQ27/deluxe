var productoListados = function()
{
	var self = this;
	
	this.init = function()
	{
    $.ias({
        container  : ".resultados",   
        item       : ".resultado",
        pagination : "#contentPaginator",
        next       : "#contentPaginator .next",
        loader     : "/images/eshop/paginator-loader.gif",
        onPageChange: function(pageNum, pageUrl, scrollOffset) {
          var posSigno = window.location.href.indexOf('?');
          if ( posSigno == -1 ) posSigno = window.location.href.length;
          var posNumeral = window.location.href.indexOf('#');
          if ( posNumeral == -1 ) posNumeral = window.location.href.length;
          
          var pos = ( posNumeral < posSigno ) ? posNumeral : posSigno;
            
          var baseUrl = ( pos == -1 ) ? window.location.href : window.location.href.substr(0, pos );
          ga('send', 'pageview', baseUrl + pageUrl);
        }
    });	    
        
	};
	
	this.init();   
}

$(document).ready( function() { new productoListados(); } );