/* For Tag Suggest *
$(function() {
	jQuery('input#lables' + id)
		.suggest("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=label", {
		multiple:true, 
		multipleSep: ", "
		});
	jQuery('input#tags' + id)
		.suggest("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=post_tag", {
		multiple:true, 
		multipleSep: ", "
		});
});
*/
function siteValue(value){
	var input = $('#mshot');
	( value.length != 0 ) ? input.html(value) : input.html('');
}

$(function() {
	// $('.gallery-thumbs li a img').fadeOut().fadeIn();
	
	/* Fade in / Fade out links */
	$("a img").css("opacity","1"); 	
	$("a img").hover(function () { 	
		$(this).stop().animate({ opacity: 0.5 }, 'fast' );
	}, function () {
		$(this).stop().animate({ opacity: 1 }, 'fast' );
	});

	/* Create Layout Switcher */
	$("a.switch_thumb").toggle(function(){
		$(this).addClass("swap");
		$("ul.display").fadeOut("fast", function() {
			$(this).fadeIn("fast").addClass("thumb_view");
		});
	}, function () {
		$(this).removeClass("swap");
		$("ul.display").fadeOut("fast", function() {
			$(this).fadeIn("fast").removeClass("thumb_view");
		});
	});
		
	/* Dialog Link & Tabs */
	$('#tabs').tabs();
	
	$('#dialog').dialog({ autoOpen: false, width: 400, buttons: { "Cancel": function() { $(this).dialog("close");}} });
	$('#dialog_link').click(function(){ $('#dialog').dialog('open'); return false; });
	$('#dialog_link, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);

/*
$('#submitsite').click(function(e) {
		var formData = $('form#new_site').serialize();
		$.ajax({
			type: "POST",
			url: "/wp-admin/admin-ajax.php",
			data: formData,
			success: function(d) {
				console.log(d);
			$('div').empty().html("hi " + d);
			}
		});
		e.preventDefault();
	});
*/	
});

(function($){$.fn.TextAreaExpander=function(minHeight,maxHeight){var hCheck=!($.browser.msie||$.browser.opera);function ResizeTextarea(e){e=e.target||e;var vlen=e.value.length,ewidth=e.offsetWidth;if(vlen!=e.valLength||ewidth!=e.boxWidth){if(hCheck&&(vlen<e.valLength||ewidth!=e.boxWidth))e.style.height="0px";var h=Math.max(e.expandMin,Math.min(e.scrollHeight,e.expandMax));e.style.overflow=(e.scrollHeight>h?"auto":"hidden");e.style.height=(h - 5)+"px";e.valLength=vlen;e.boxWidth=ewidth}return true};this.each(function(){if(this.nodeName.toLowerCase()!="textarea")return;var p=this.className.match(/expand(\d+)\-*(\d+)*/i);this.expandMin=minHeight||(p?parseInt('0'+p[1],10):0);this.expandMax=maxHeight||(p?parseInt('0'+p[2],10):99999);ResizeTextarea(this);if(!this.Initialized){this.Initialized=true;$(this).css('padding-bottom', 0).css('padding-top', 5);$(this).bind("keyup",ResizeTextarea).bind("focus",ResizeTextarea);}});return this}})(jQuery);
// initialize all expanding textareas
jQuery(document).ready(function() {
	jQuery("textarea[class*=expand]").TextAreaExpander();
});

/* Equal height divs */
jQuery(function(){function equalHeight(group) { var tallest = 0; group.each(function() { var thisHeight = jQuery(this).height(); if(thisHeight > tallest) { tallest = thisHeight; } }); group.height(tallest); } equalHeight(jQuery(".gallery-thumbs li, .widget"));});