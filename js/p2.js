var loggedin = false;

jQuery(function($) {
				
	/*
	* Submits a new post via ajax
	*/
	function newPost(trigger) {
		var thisForm = $(trigger.target);
		var thisFormElements = $('#title, #site, #description, #lbls, :input',thisForm).not('input[type=hidden]');

		var submitProgress = thisForm.find('span.progress');
		var description = $.trim($('#description').val());

		if(jQuery('.no-posts')) jQuery('.no-posts').hide();

		if ("" == posttext) {
			$("label#posttext_error").text('This field is required').show().focus();
			return false;
		}

		toggleUpdates('unewposts');
		if (typeof ajaxCheckPosts != "undefined")
			ajaxCheckPosts.abort();
		$("label#posttext_error").hide();
		thisFormElements.attr('disabled', true);
		thisFormElements.addClass('disabled');

		submitProgress.show();
		var tags = $('#lbls').val();
		if (tags == p2txt.tagit) tags = '';
		var post_cat = $('#post_cat').val();
		var post_title = $('#title').val();

		var args = {action: 'new_site', _ajax_post:nonce, title: title, description: description, post_cat: post_cat  };
		var errorMessage = '';
		$.ajax({
			type: "POST",
			url: ajaxUrl,
			data: args,
			success: function(result) {
				if ("0" == result)
					errorMessage = p2txt.not_posted_error;

				$('#posttext').val('');
				$('#tags').val(p2txt.tagit);
				if(errorMessage != '')
					newNotification(errorMessage);

				if ($.suggest)
					$('ul.ac_results').css('display', 'none'); // Hide tag suggestion box if displayed

				if (isFirstFrontPage && result != "0") {
					getPosts(false);
				} else if (!isFirstFrontPage && result != "0") {
					newNotification(p2txt.update_posted);
				}
				submitProgress.fadeOut();
				thisFormElements.attr('disabled', false);
				thisFormElements.removeClass('disabled');
			  },
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				submitProgress.fadeOut();
				thisFormElements.attr('disabled', false);
				thisFormElements.removeClass('disabled');
			},
			timeout: 60000
		});
		thisFormElements.blur();
		toggleUpdates('unewposts');
	}

	function newNotification(message) {
		$("#notify").stop(true).prepend(message + '<br/>')
			.fadeIn()
			.animate({opacity: 0.7}, 3000)
			.fadeOut('3000', function() {
				$("#notify").html('');
			}).click(function() {
				$(this).stop(true).fadeOut('fast').html('');
			});
	}

	// Activate inline editing plugin
	if ((inlineEditPosts || inlineEditComments ) && isUserLoggedIn) {
		$.editable.addInputType('autogrow', {
		    element : function(settings, original) {
		        var textarea = $('<textarea class="expand" />');
		        if (settings.rows) {
		            textarea.attr('rows', settings.rows);
		        } else {
		            textarea.attr('rows', 4);
		        }
		        if (settings.cols) {
		            textarea.attr('cols', settings.cols);
		        } else {
		            textarea.attr('cols', 45);
		        }
				textarea.width('95%');
		        $(this).append(textarea);
		        return(textarea);
		    },
		    plugin : function(settings, original) {
		        $('textarea', this).keypress(function(e) {autgrow(this, 3);});
		        $('textarea', this).focus(function(e) {autgrow(this, 3);});
		    }
		});
	}

	// Set tabindex on all forms
	var tabindex = 4;
	$('form').each(function() {
		$(':input',this).not('#subscribe, input[type=hidden]').each(function() {
        	var $input = $(this);
			var tabname = $input.attr("name");
			var tabnum = $input.attr("tabindex");
			if(tabnum > 0) {
				index = tabnum;
			} else {
				$input.attr("tabindex", tabindex);
			}
			tabindex++;
		});
     });

	// Bind actions to comments and posts
	jQuery('.post, .page').each(function() { bindActions(this, 'post'); });
	jQuery('body .comment').each(function() { bindActions(this, 'comment'); });


	$('#cancel-comment-reply-link').click(function() {
		$('#comment').val('');
		if (!isSingle) $("#respond").hide();
		$(this).parents("li").removeClass('replying');
		$(this).parents('#respond').prev("li").removeClass('replying');
		$("#respond").removeClass('replying');
	});


	// Activate Tag Suggestions for logged users on front page
	if (isFrontPage && prologueTagsuggest && isUserLoggedIn)
		$('input[name="tags"]').suggest(ajaxUrl + '&action=tag_search', { 
			delay: 350, 
			minchars: 2, 
			multiple: true, 
			multipleSep: ", " 
		} );

	// Catch new posts submit
	$("#new_site").submit(function(trigger) {
		newsite(trigger);
		trigger.preventDefault();
	});
	$("#new_snip").submit(function(trigger) {
		newsnip(trigger);
		trigger.preventDefault();
	});
	$("#new_status").submit(function(trigger) {
		newstats(trigger);
		trigger.preventDefault();
	});
	$("#new_question").submit(function(trigger) {
		newquestion(trigger);
		trigger.preventDefault();
	});

	// Hide error messages on load
	$('#posttext_error, #commenttext_error').hide();

});