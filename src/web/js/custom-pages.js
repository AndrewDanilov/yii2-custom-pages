$(function() {
	// слайдер в новостях
	new Swiper('.custom-pages-slider', {
		slidesPerView: 'auto',
		spaceBetween: 30,
		zoom: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
});