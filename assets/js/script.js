$("#recv-b").on('click', function(){
	$(this).addClass("active");
	$("#sent-b").removeClass("active");
	$("#sent").hide();
	$("#received").show();
});
$("#sent-b").on('click', function(){
	$(this).addClass("active");
	$("#recv-b").removeClass("active");
	$("#received").hide();
	$("#sent").show();
});
function fixFooter(){
	if ($(window).height() > $("body").height()){
		$("#footer").addClass("sticky");
	}
	else {
		$("footer").removeClass("sticky");
	}
}
$(window).on('resize', fixFooter);
fixFooter();