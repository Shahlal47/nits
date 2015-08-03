APP_HELPER = {
		
	APP_XHR : null,	
	AJAX_CONTENT_HOLDER: "#ajax-content",
	AJAX_LOADER: "#ajax-loader",
	
	loadIframe : function(url,placeholder){
		var iframe = '<iframe class="iframe span12" style="overflow:hidden" src="'+APP_URL_ROOT+url+'"></iframe>';
		$(placeholder).html(iframe);
		var h = $(window).height();
		$('.iframe').css('height',h-70);	                   
	},
	selectMenu : function(id,action) {
		// remove class from current
		 $(id+' li').removeClass('active');
		// add class in the action
		 $(id+' a[href=#' + action+']').parent().addClass('active');
	},
	
	getFullPath : function(action) {
		var url = APP_URL_ROOT + action;
		return url;
	},
	loadContents : function(contents){
		$(this.AJAX_CONTENT_HOLDER).html(contents);
	},
	loadContentHolder : function(contents, holder){
		$(holder).html(contents);
	},
	ajax_start : function() {
		$(this.AJAX_LOADER).show();
		$('button[type=submit]').attr('disabled',true);
	},
	ajax_stop : function() {
		$(this.AJAX_LOADER).hide();
		$('button[type=submit]').attr('disabled',false);
	},	
	ajax_error : function(status, errorThrown) {
		this.ajax_stop();
		if(status==403){
			$('#loginModal').modal('show');
		}else if(status==404){
			alert("Requested uri not found in the server.");			
		}else{
			//console.debug("Status: " + status + ".\n" + errorThrown);
		}				
	},
	
	ajaxRequestModelAction : function(params){
		var url = this.getFullPath(params);
		this.ajaxLoad(url,this.AJAX_CONTENT_HOLDER);
	},	
	
	ajaxLoad : function(url, placeholder) {		
		if (APP_XHR)
			APP_XHR.abort();
		APP_XHR = $.ajax({
			url : url,
			beforeSend:function (XMLHttpRequest) {
				APP_HELPER.ajax_start();
			}, 
			success : function(data, textStatus, jqXHR) {
				$(placeholder).html(data);
				APP_HELPER.ajax_stop();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				APP_HELPER.ajax_error(jqXHR.status, errorThrown);				
			}
		});
	},
	
	ajaxLoadCallback : function(url, callback) {
		url = APP_URL_ROOT + url;
		if (APP_XHR)
			APP_XHR.abort();
		APP_XHR = $.ajax({
			url : url,
			beforeSend:function (XMLHttpRequest) {
				APP_HELPER.ajax_start();
			}, 
			success : function(data, textStatus, jqXHR) {
				callback(data);
				APP_HELPER.ajax_stop();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				APP_HELPER.ajax_error(jqXHR.status, errorThrown);
			}
		});
	},

	ajaxSubmitData : function(url, data) {
		url = APP_URL_ROOT + url;
		if (APP_XHR)
			APP_XHR.abort();
		APP_XHR = $.ajax({
			async:true, 
			type:"POST", 
			url: url,
			data: data, 
			beforeSend:function (jqXHR) {
				APP_HELPER.ajax_start();
			}, 
			error:function (jqXHR, textStatus, errorThrown) {
				console.debug(jqXHR);
				APP_HELPER.ajax_error(jqXHR.status, errorThrown);
			}, 
			success:function (data, textStatus) {
				APP_HELPER.ajax_stop();
				APP_HELPER.loadContents(data);
			} 
		});
	},
	ajaxSubmitDataCallback : function(url, data, callback) {
		url = APP_URL_ROOT + url;
		if (APP_XHR)
			APP_XHR.abort();
		APP_XHR = $.ajax({
			async:true, 
			type:"POST", 
			url: url,
			data: data, 
			beforeSend:function (jqXHR) {
				APP_HELPER.ajax_start();
			}, 
			error:function (jqXHR, textStatus, errorThrown) {
				console.debug(jqXHR);
				APP_HELPER.ajax_error(jqXHR.status, errorThrown);
			}, 
			success:function (data, textStatus) {
				APP_HELPER.ajax_stop();
				callback(data);
			} 
		});
	},
	ajaxLogin : function(data) {
		url = APP_URL_ROOT + 'ajaxlogin';
		if (APP_XHR)
			APP_XHR.abort();
		APP_XHR = $.ajax({
			async:true, 
			type:"POST", 
			url: url,
			data: data, 
			beforeSend:function (XMLHttpRequest) {
				$('#login-loader').show();
				$('#login-error').hide();
			}, 
			success : function(data, textStatus, jqXHR) {
				$('#login-loader').hide();
				var flg = JSON.parse(data);
				if(flg.login){
					$('#loginModal').modal('hide');
				}else{
					$('#login-error').show();
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
				$('#login-loader').hide();
				APP_HELPER.ajax_error(jqXHR.status, errorThrown);
			}
		});
	},
	
	ajaxDeleteRecordAction : function(action){
		if (confirm('Are you sure you want to delete record from the database?')) {
			this.ajaxRequestModelAction(action);
		}
	},
	ajaxDeleteRecord : function(url, placeholder){
		if (confirm('Are you sure you want to delete record from the database?')) {
			this.ajaxLoad(url, placeholder);
		}
	},
	refreshDataTable : function(tableId, refreshUrl) {
		$.getJSON(refreshUrl, null, function(json) {
			table = $(tableId).dataTable();
			oSettings = table.fnSettings();

			table.fnClearTable(this);

			for ( var i = 0; i < json.aaData.length; i++) {
				console.debug(json.aaData[i]);
				table.oApi._fnAddData(oSettings, json.aaData[i]);
			}

			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			table.fnDraw();
		});
	},
	
	zeroFill : function( number, width )
	{
	  width -= number.toString().length;
	  if ( width > 0 )
	  {
	    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
	  }
	  return number + "";
	}	
};

