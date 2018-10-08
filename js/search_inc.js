function search(){
	//if($("#search_input_txt").val().length >= 3){
		$.post("include/search_core.php", {search: $("#search_input_txt").val()}, function(html){
			$("#searchbox_body").html(html);
		});

		$("#searchbox_body").css("height", $(document).height() - $("#searchbox_header").height() - $("#header").height());
		//console.log("YES....");
	//}

	if($("#search_input_txt").val().length == 0){
		$("#searchbox_body").html("");
	}
}

function search_exe(){
	if($("#search_input_txt").length > 0){
        $.post("include/search_core.php", {search: $("#search_input_txt").val()}, function(html){
            $("#searchbox_body").html(html);
        });
	}
}