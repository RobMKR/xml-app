$(document).ready(function(){
	
	$('.results').tablesorter({
		selectorHeaders: 'thead th.sortable',
	    sortReset      : true,
	    sortRestart    : true
	});
	$('.search').keyup(function(){
		var value = $(this).val();
		if(value.length > 1){
			var configs = {
				'url': 'api/getSearchResults.php',
				'type': 'post',
				'dataType' : 'json',
				'limit' : 10
			};
			Search.prepareAjax(configs).getResults(value);
		}else{
			Search.emptyTables();
			$('.results-dropdown').hide();
		}
	});
	
	$(document).on('click', '.dropdown-option a', function(){
		var data = {
			id: $(this).attr('data-id'),
			lng: $(this).attr('data-lng'),
			ltd: $(this).attr('data-ltd'),
		};
		var configs = {
			'url': 'api/getSearchResults.php',
			'type': 'post',
			'dataType' : 'json',
			'limit' : 50
		};
		Search.prepareAjax(configs).getRecords(data);
	})
});