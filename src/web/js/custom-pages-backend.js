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
	$('.custom-pages-sliders')
		.on('click', '.sliders-controls-add', function (e) {
			e.preventDefault();
			var wrapper = $(this).parents('.sliders-wrapper');
			var list = wrapper.find('.sliders-list');
			var blank = wrapper.find('.sliders-blank').clone();
			var formName = blank.find('.input-images-wrapper').attr('data-form-name');
			var slider_id = 'slider' + Date.now();
			blank.find('.sliders-item').attr('data-id', slider_id);
			var blank_html = blank.html();
			blank_html = blank_html.replace(/blankid/g, slider_id);
			list.append(blank_html);
			var callback_id = formName.toLowerCase() + '-sliders-' + slider_id;
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
		.on('click', '.sliders-item-remove', function (e) {
			e.preventDefault();
			var item = $(this).parents('.sliders-item');
			item.remove();
		})
		.on('click', '.sliders-item-copy', function (e) {
			e.preventDefault();
			var slider_id = $(this).parents('.sliders-item').attr('data-id');
			customPagesBackend.copyTextToClipboard('[' + slider_id + ']');
			alert('Скопировано');
		})
});