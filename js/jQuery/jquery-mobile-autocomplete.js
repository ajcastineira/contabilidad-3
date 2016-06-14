/* jquery-autocomplete.js
**
** By: Glenn J. Schworak
** Version: 0.1.1
** Help: http://schworak.com/blog/e75/
*/
document.write("<style>.ui-autocomplete-content li {cursor:pointer; opacity:.9} .ui-autocomplete-content li:hover {opacity:1}</style>");
function initAutocomplete()
{
	$('input[type="text"][data-role="autocomplete"][data-url]').each(function() {
		var inp=$(this);
		var minlen=2;
		var loading="";
		var useCache=true;
		var div=inp.next('[data-role="autocomplete-content"]');
		var dataUrl=inp.attr("data-url");
		var dataData="";
		var dataSpeed=200;
		var dataDelay=500;
		var dataNoMatch="";
		var dataHighlight="ui-btn-up-b";
		var q=dataUrl.indexOf("?");
		var prevVal="";
		var dataTimeout=0;
		var rowFormatter="";
		var rowClick="";
		var ajaxObj;
		var dataTheme="";

		if(inp.attr("data-autocomplete-ready")!=undefined) return;
		inp.attr("data-autocomplete-ready","true");
		
		if(q>0)
		{
			dataData=dataUrl.substr(q+1);
			dataUrl=dataUrl.substr(0,q);
		}
		
		if(div.length<1)
		{
			div=$("<div class='ui-autocomplete-content'><div>");
			inp.after(div);
		}
		div.hide();
		if(inp.attr("data-theme"))
		{
			dataTheme=" data-theme='"+inp.attr("data-theme")+"'";
		}
		if(inp.attr("data-no-match"))
		{
			dataNoMatch=inp.attr("data-no-match");
		}
		if(inp.attr("data-formatter"))
		{
			rowFormatter=inp.attr("data-formatter");
		}
		if(inp.attr("data-click"))
		{
			rowClick=inp.attr("data-click");
		}
		if(inp.attr("data-highlight"))
		{
			dataHighlight=inp.attr("data-highlight");
		}
		if(inp.attr("data-speed"))
		{
			try
			{
				dataSpeed=parseInt(inp.attr("data-speed"));
			}
			catch(e)
			{
				dataSpeed=200;
			}
		}
		if(inp.attr("data-delay"))
		{
			try
			{
				dataDelay=parseInt(inp.attr("data-delay"));
			}
			catch(e)
			{
				dataDelay=500;
			}
		}
		if(inp.attr("data-cache"))
		{
			try
			{
				useCache=parseBool(inp.attr("data-cache"));
			}
			catch(e)
			{
				useCache=true;
			}
		}
		if(inp.attr("data-timeout"))
		{
			try
			{
				dataTimeout=parseInt(inp.attr("data-timeout"));
			}
			catch(e)
			{
				useTimeout=0;
			}
		}
		if(inp.attr("data-loading"))
		{
			loading=inp.attr("data-loading");
		}
		if(inp.attr("data-minlen"))
		{
			try
			{
				minlen=parseInt(inp.attr("data-minlen"));
			}
			catch(e)
			{
				minlen=2;
			}
		}
		inp.on("focus",function() {
			var val=inp.val().trim();
			prevVal=val;
		});
		inp.on("keydown",function() {
			if(ajaxObj!=undefined)
			{
				try
				{
					ajaxObj.abort();
				}
				catch(e)
				{
					/* skip it */
				}
			}
		});
		inp.on("keyup",function() {
			clearTimeout($.data(this, 'timer'));
  			var wait = setTimeout(function() {
				var val=inp.val().trim();
				if(val.length>=minlen && val!=prevVal)
				{
					if(dataData.match(/{val}/))
					{
						callData=dataData.replace(/{val}/g,escape(val));
					}
					else
					{
						callData="&query=".escape(val);
					}
					if(div.html()=="<div></div>") div.html(loading);
					div.show(dataSpeed);
					ajaxObj=$.ajax({
						url:dataUrl,
						data:callData,
						cache:useCache,
						dataType:"json",
						type:"get",
						timeout:dataTimeout,
						error:function(dfr,status,errorThrown) { er=""+errorThrown; if(!er.match(/(abort|timeout)/i)) div.text(errorThrown) },
						success:function(json,status,xfr) { div.html(function() {
								var rows=0;
								var out="<ul data-role='listview' data-inset='true' data-mini='true'"+dataTheme+">";
								for(var key in json["suggestion"])
								{
									out+="<li onclick='div=$(this).parent().parent(); div.hide("+dataSpeed+"); div.prev().val($(this).text());";
									if(rowClick!="")
									{
										k=key.replace(/\"/g,"\\\"");
										out+=rowClick+'("'+k+'");';
									}
									out+="'";
									out+=">";
									if(rowFormatter=="")
									{
										reg=RegExp("("+json["query"]+")",'gi');
										out+=json["suggestion"][key].replace(reg,"<strong class='"+dataHighlight+"'>$1</strong>");
									}
									else
									{
										q=json["query"].replace(/\"/g,"\\\"");
										v=json["suggestion"][key].replace(/\"/g,"\\\"");
										out+=eval(rowFormatter+'("'+q+'","'+v+'")');
									}
									out+="</li>";
									++rows;
								}
								out+="</ul>";
								if(rows<1) out=dataNoMatch;
								return out;
							}); div.trigger("create"); }
					});
				}
				else
				{
					div.hide(dataSpeed);
				}
				prevVal=val;
			}, dataDelay);
  			$(this).data('timer', wait);
  		});
		inp.parent().on("blur",function() {
			setTimeout(function() {div.hide(dataSpeed)},10);
			if(ajaxObj!=undefined)
			{
				try
				{
					ajaxObj.abort();
				}
				catch(e)
				{
					/* skip it */
				}
			}
		});
	});
}
$(document).bind('pagecreate', function() { initAutocomplete();});


