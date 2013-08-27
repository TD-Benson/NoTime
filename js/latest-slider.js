(function(jQuery) {

	jQuery.fn.latestSlider = function(options) {
		return this.each(function(i) {
			new latestSlider(this, options);
		});
	};

	// Methods
	//
	var latestSlider = function(el, options) {
		this.element = jQuery(el);

		this.slides = null;
		this.currentSlideIndex = 0;
		this.currentSlide = null;

		this.options = options;

		// Initialise
		//
		this.init = function() {
			this.slides = this.element.children('div');
			this.slides.hide();
			this.slides.css('visibility', 'visible');

			this.currentSlideIndex = -1;

			this.advance();
		};

		// Display next slide
		//
		this.advance = function() {
			var nextSlideIndex = this.currentSlideIndex + 1;
			if (nextSlideIndex >= this.slides.length)
				nextSlideIndex = 0;

			var nextSlide = jQuery(this.slides[nextSlideIndex]);
			var currentSlide = jQuery(this.slides[this.currentSlideIndex]);

			currentSlide.css('z-index', 1);
			nextSlide.css('z-index', 0);

			// Crossfade
			currentSlide.fadeOut(this.options.transitionSpeed);
			nextSlide.fadeIn(this.options.transitionSpeed);

			// Advance in the future
			setTimeout(jQuery.proxy(this.advance, this), this.options.slideDelay + this.options.transitionSpeed);

			this.currentSlideIndex = nextSlideIndex;
		}

		this.init();
	}

})(jQuery);