(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

})(jQuery);


var FroalaEditor = require('froala-editor');

// Load a plugin.
// require('froala-editor/js/plugins/align.min');
//require('froala-editor/js/plugins/image.min');

require('froala-editor/js/plugins/align.min.js');
require('froala-editor/js/plugins/char_counter.min.js');
require('froala-editor/js/plugins/code_beautifier.min.js');
require('froala-editor/js/plugins/code_view.min.js');
require('froala-editor/js/plugins/colors.min.js');
require('froala-editor/js/plugins/draggable.min.js');
require('froala-editor/js/plugins/edit_in_popup.min.js');
require('froala-editor/js/plugins/emoticons.min.js');
require('froala-editor/js/plugins/entities.min.js');
require('froala-editor/js/plugins/file.min.js');
require('froala-editor/js/plugins/files_manager.min.js');
require('froala-editor/js/plugins/font_family.min.js');
require('froala-editor/js/plugins/font_size.min.js');
require('froala-editor/js/plugins/forms.min.js');
require('froala-editor/js/plugins/fullscreen.min.js');
require('froala-editor/js/plugins/help.min.js');
require('froala-editor/js/plugins/image.min.js');
require('froala-editor/js/plugins/image_manager.min.js');
require('froala-editor/js/plugins/inline_class.min.js');
require('froala-editor/js/plugins/inline_style.min.js');
require('froala-editor/js/plugins/line_breaker.min.js');
require('froala-editor/js/plugins/line_height.min.js');
require('froala-editor/js/plugins/link.min.js');
require('froala-editor/js/plugins/lists.min.js');
require('froala-editor/js/plugins/markdown.min.js');
require('froala-editor/js/plugins/paragraph_format.min.js');
require('froala-editor/js/plugins/paragraph_style.min.js');
require('froala-editor/js/plugins/print.min.js');
require('froala-editor/js/plugins/quick_insert.min.js');
require('froala-editor/js/plugins/quote.min.js');
require('froala-editor/js/plugins/save.min.js');
require('froala-editor/js/plugins/special_characters.min.js');
require('froala-editor/js/plugins/table.min.js');
require('froala-editor/js/plugins/track_changes.min.js');
require('froala-editor/js/plugins/trim_video.min.js');
require('froala-editor/js/plugins/url.min.js');
require('froala-editor/js/plugins/video.min.js');
require('froala-editor/js/plugins/word_paste.min.js');


$(document).ready(function() {
    if($(".froalaEditor").length) {
        new FroalaEditor('.froalaEditor', {
      		toolbarSticky: false
        });
    }

    $('.reply_comment').click(function(){
        let id = $(this).attr('data-id');
        $("#commentForm #reply_id").val(id);
    })
})
