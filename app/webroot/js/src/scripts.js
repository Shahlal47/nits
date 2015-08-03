function zeroFill( number, width )
{
  width -= number.toString().length;
  if ( width > 0 )
  {
    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
  }
  return number + ""; // always return a string
}

function fixedsidemode() {
	return false;
}
function RefreshTable(tableId, urlData) {
	//Retrieve the new data with $.getJSON. You could use it ajax too
	$.getJSON(urlData, null, function(json) {
		table = $(tableId).dataTable();
		oSettings = table.fnSettings();

		table.fnClearTable(this);

		for ( var i = 0; i < json.aaData.length; i++) {
			table.oApi._fnAddData(oSettings, json.aaData[i]);
		}

		oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
		table.fnDraw();
	});
}

var VTS_FN = {
	VTS_XHR : null,
	selectMenu : function(action) {
		// remove class from current
		$('#left-menu li').removeClass('active');
		// add class in the action
		$('#li-' + action).addClass('active');
	},
	ajax_start : function() {
		$('#ajax-loader').show("fast");
		$("button[type=submit]").attr("disabled", true);
	},
	ajax_stop : function() {
		$('#ajax-loader').hide("fast");
		$("button[type=submit]").attr("disabled", false);
	},
	ajax_error : function() {
		this.ajax_stop();
	},
	ajax_login : function(data) {
		// if success
		//VTS_FN.ajax_stop();
		var msg = JSON.parse(data);
		if (msg.msg[0].status == "success") {
			$("#ajax-login-modal").modal('hide');
		} else {
			alert(msg.msg[1].msg);
		}
	}

};
var VTS_AJAX = {
	getFullPath : function(action) {
		var url = VTS_URL_ROOT + action;
		return url;
	},
	getContentsByAction : function(action) {
		var url = VTS_AJAX.getFullPath(action);
		VTS_AJAX.getContentsByUrl(url);
	},
	getContentsByUrl : function(url) {
		//alert(url);
		if (VTS_XHR)
			VTS_XHR.abort();
		VTS_XHR = $.ajax({
			url : url,
			success : function(data, textStatus, jqXHR) {
				$('#ajax-contents').html(data);
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert('Error Occurred!!!');
			}
		});
	},
	loadContentsByUrl : function(url, placeholder) {
		//alert(url);
		url = VTS_URL_ROOT + url;
		VTS_FN.ajax_start();
		if (VTS_XHR)
			VTS_XHR.abort();
		VTS_XHR = $.ajax({
			url : url,
			success : function(data, textStatus, jqXHR) {
				$(placeholder).html(data);
				VTS_FN.ajax_stop();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert('Error Occurred!!!');
				VTS_FN.ajax_error();
			}
		});
	},
	loadContents : function(url, callback) {
		//alert(url);
		url = VTS_URL_ROOT + url;
		VTS_FN.ajax_start();
		if (VTS_XHR)
			VTS_XHR.abort();
		VTS_XHR = $.ajax({
			url : url,
			success : function(data, textStatus, jqXHR) {
				callback(data);
				VTS_FN.ajax_stop();
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert('Error Occurred!!!');
				VTS_FN.ajax_error();
			}
		});
	}
};