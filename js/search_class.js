var Search = new function(){

	var limit = 25;
	var url = '';
	var type = 'get';
	var dataType = 'json';
	var table;
	var table_body = $('.results tbody');
	var dropdown = $('.results-dropdown');
	var finded_results = [];
	
	
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
	
	this.emptyTables = function(){
		$('table tbody').html('');
	}
	
	this.emptyDropdown = function(){
		dropdown.html('');
	}
	
	var cleanUp = function(){
		finded_results = [];
	}

	var collectRows = function(rows, object){
		var distance, row;
		cleanUp();
		$.each(rows, function(key, value){
			row = {};
			distance = Gps.getDistance(object.lng, object.ltd, value.longitude, value.latitude);
			
			row.adress = value.adress;
			row.distance = Math.round(distance * 100) / 100;
			finded_results.push(row);
		});
	}
	
	var insertOptions = function(rows){
		var results = '<ul>';
		
		$.each(rows, function(key, value){
			results +=  '<li class="dropdown-option"><a data-id="'+value.id+'" data-lng="'+value.longitude+'" data-ltd="'+value.latitude+'">' + value.adress + '</a></li>';
		});
		results += '</ul>';
		Search.emptyDropdown();
		dropdown.html(results);
	}
	
	var selectTable = function(slug){
		switch(slug){
			case 5:
				table = $('.results5');
				table_body = $('.results5 tbody');
				break;
			case 10:
				table = $('.results10');
				table_body = $('.results10 tbody');
				break;
			case 15:
				table = $('.results15');
				table_body = $('.results15 tbody');
				break;
			default:
				return false;
		}
	}
	
	var insertRows = function(rows){
		var result = '';
		$.each(rows, function(key, value){
			
			if(value.distance <= 5){
				selectTable(5);
			}else if(value.distance <= 10){
				selectTable(10);
			}else if(value.distance <= 15){
				selectTable(15);
			}
			
			result += '<tr>';
			result += '<td>'+value.adress+'</td>';
			result += '<td>'+value.distance+'km</td>';
			result += '</tr>';
			
			Search.emptyTable(1);
			table_body.html(result);
			table.trigger("update");
		});
		
	}

	this.getResults = function(searchable){
		$.ajax({
			url: url,
			type: type,
			dataType: dataType,
			data: {
				'type' : 1,
				'key' : searchable,
				'limit' : limit
			},
			success: function(data){
	        	if(data.status){
	        		if(data.params.length === 0){
	        			Search.emptyDropdown();
						dropdown.hide();
	        		}else{
	        			insertOptions(data.params);
						dropdown.show();
	        		}
	        	}else{
	        		alert('Something Went Wrong');
	        	}
	    	},
	    	error: function(data){
	    		// location.reload();
	    	}
		});
	}
	
	this.getRecords = function(data){
		var object = data;
		$.ajax({
			url: url,
			type: type,
			dataType: dataType,
			data: {
				'type' : 2,
				'id': data.id,
				'limit': limit,
			},
			success: function(data){
	        	if(data.status){
	        		if(data.params.length === 0){
						Search.emptyTable(2);
	        		}else{
						collectRows(data.params, object);
						insertRows(finded_results);
	        		}
	        	}else{
	        		alert('Something Went Wrong');
	        	}
	    	},
	    	error: function(data){
	    		// location.reload();
	    	}
		});
	}

};


