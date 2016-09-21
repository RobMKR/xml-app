var Search = new function(){

	var limit = 25;
	var url = '';
	var type = 'get';
	var dataType = 'json';
	var table = $('.results');
	var table_body = $('.results tbody');

	this.prepareAjax = function(data){
		if(typeof(data.url) != "undefined" && data.url !== null){
			url = data.url;
		}
		if(typeof(data.type) != "undefined" && data.type !== null){
			type = data.type;
		}
		if(typeof(data.limit) != "undefined" && data.limit !== null){
			limit = data.limit;
		}
		if(typeof(data.dataType) != "undefined" && data.dataType !== null){
			dataType = data.dataType;
		}
		return this;
	}

	this.emptyTable = function(type){
		if(type === 1){
			table_body.html('');
		}else if(type === 2){
			table_body.html('<tr><td class="notFound" colspan="5">Nothing Found</td></tr>');
		}
	}

	var insertRows = function(rows){
		var results;
		$.each(rows, function(key, value){
			results += '<tr>' 
						+ '<td>' + (parseInt(key)+1) + '</td>' 
						+ '<td>' + value.to + '</td>' 
						+ '<td>' + value.from + '</td>' 
						+ '<td>' + value.heading + '</td>' 
						+ '<td>' + value.body + '</td>' 
						+'</tr>';
		});
		Search.emptyTable(1);
		table_body.html(results);
		table.trigger("update");
	}

	this.getResults = function(searchable){
		$.ajax({
			url: url,
			type: type,
			dataType: dataType,
			data: {
				'key' : searchable,
				'limit' : limit
			},
			success: function(data){
	        	if(data.status){
	        		if(data.params.length === 0){
	        			Search.emptyTable(2);
	        		}else{
	        			insertRows(data.params);
	        		}
	        	}else{
	        		alert('Something Went Wrong');
	        	}
	    	},
	    	error: function(data){
	    		location.reload();
	    	}
		});
	}
}