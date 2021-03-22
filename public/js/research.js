$(document).ready(function()
{
	$("#search-bar").keyup(function()
	{
		let keyword = $(this).val();

		if (keyword != '')
		{
			$.ajax({
			type: "GET",
			url: "backend-search.php",
			data: "keyword=" + encodeURIComponent(keyword),
			success: function(data) {
				if (data != '') {
					console.log(data);
				}
				else {
					alert("Aucun mot-clé saisi !");
				}
			}});
		}
		
	});
});
