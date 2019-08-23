var customPagesBackend = {
	copyTextToClipboard: function (text) {
		var copyText = $('<input>', {'style': 'position:absolute;left:-9999px;'});
		copyText.val(text);
		copyText = copyText.appendTo($('body'));
		copyText.get(0).select();
		document.execCommand("copy");
		copyText.remove();
	}
};

$(function () {
	$('.custom-pages-albums')
		.on('click', '.albums-controls-add', function (e) {
			e.preventDefault();
			var wrapper = $(this).parents('.albums-wrapper');
			var list = wrapper.find('.albums-list');
			var blank = wrapper.find('.albums-blank').clone();
			var formName = blank.find('.input-images-wrapper').attr('data-form-name');
			var album_id = 'album' + Date.now();
			blank.find('.albums-item').attr('data-id', album_id);
			var blank_html = blank.html();
			blank_html = blank_html.replace(/blankid/g, album_id);
			list.append(blank_html);
			var callback_id = formName.toLowerCase() + '-albums-' + album_id;
			mihaildev.elFinder.register(callback_id, InputImagesHandler);
			$(document).on('click', '#' + callback_id + '_button', function () {
				mihaildev.elFinder.openManager({
					"url": "/admin/elfinder/manager?filter=image&callback=" + callback_id + "&lang=ru&multiple=1",
					"width": "auto",
					"height": "auto",
					"id": callback_id
				});
			});
		})
		.on('click', '.albums-item-remove', function (e) {
			e.preventDefault();
			var item = $(this).parents('.albums-item');
			item.remove();
		})
		.on('click', '.albums-item-copy-gallery', function (e) {
			e.preventDefault();
			var album_id = $(this).parents('.albums-item').attr('data-id');
			customPagesBackend.copyTextToClipboard('[gallery ' + album_id + ']');
			alert('Copied');
		})
		.on('click', '.albums-item-copy-slider', function (e) {
			e.preventDefault();
			var album_id = $(this).parents('.albums-item').attr('data-id');
			customPagesBackend.copyTextToClipboard('[slider ' + album_id + ']');
			alert('Copied');
		})
});