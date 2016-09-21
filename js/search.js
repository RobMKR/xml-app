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
			Search.emptyTable(2);
		}
	});
});