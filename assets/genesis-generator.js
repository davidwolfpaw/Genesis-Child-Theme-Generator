/**
 * This could use a lot more work.
 *
 * @see http://www.amitpatil.me/multi-step-form-with-progress-bar-and-validation/
 */


(function($, document, window, undefined) {

	'use strict';

	var $fp = $('#form-pager');

	function main() {

		var current = 1;
		var $document = $(document);
		var $progress = $('#progress');
		var $toggle = $('.step-control-toggle');
		var $show = $('.step-control-show');
		var $hide = $('.step-control-hide');
		var $form = $fp.find('form');
		var $nav = $fp.find('.steps-nav');
		var $step = $fp.find('.step');
		var $prev = $fp.find('.prev');
		var $next = $fp.find('.next');
		var $submit = $fp.find('.submit');
		var top = function() { $document.scrollTop(0); };
		// Change progress bar action:
		var progress = function(step) {

			var percent = parseFloat(100 / $step.length) * step;

			percent = percent.toFixed();

			$progress
				.children('div')
				.css('width', percent + '%')
				.end()
				.children('span')
				.text(percent + '%');

		};
		// Hide buttons according to the current step:
		var buttons = function(step) {

			var limit = parseInt($step.length);

			$nav.find('button').hide();

			if (step < limit) {
				$next.show();
			}

			if (step > 1) {
				$prev.show();
			}

			if (step == limit) {
				$next.hide();
				$submit.show();
			}

		};
		var hash = function() {

			var what = window.location.hash;
			var $what = $(what);

			if ($what.length && $what.hasClass('step')) {

				if (what) {

					current = ($fp.find('.step').index($what) + 1);

				}

				go();

			}

		};
		var go = function() {

			$step
				.show()
				.not(':eq(' + (current - 1) + ')')
				.hide();

			buttons(current);
			progress(current);

		};
		var control = function(kind) {

			var self = this;
			var $this = $(self);
			var $data = $this.data('pageIds');
			var $rules = $this.data('pageRules');
			var $elements = $($data);
			var $count = $elements.length;

			if ($rules && $rules.length) {

				$.each($rules.split(','), function(index, value) {

					if ($.isFunction(window[value])) {

						kind = window[value].call(self);

					}

				});

			}

			switch(kind) {
				case 'toggle':
					$elements
						.toggleClass('step step-hide');
					break;
				case 'show':
					$elements
						.removeClass('step-hide')
						.addClass('step');
					break;
				case 'hide':
					$elements
						.removeClass('step')
						.addClass('step-hide');
					break;
			}


			$step = $fp.find('.step');

			current = ($step.index($this.parents('.step')) + 1);

			go();

		};

		// Initialize validation plugin:
		$form.validate({
			ignore: ':not(:visible)',
			rules: {
				name: 'required'//,
				// Just an example of how to do more advanced validation checks:
				/*
				dob: {
					required: true,
					date: true
				}
				*/
			}
			// If you don’t want to deal with the default error placement:
			/*
			errorPlacement: function(error, element) {
				var $label = element.parent('label');
				if ($label.length) {
					$label.before(error);
				} else {
					element.before(error);
				}
			}
			*/
		});

		$toggle.change(function() {

			control.call(this, 'toggle');

		});

		$show.change(function() {

			control.call(this, 'show');

		});

		$hide.change(function() {

			control.call(this, 'hide');

		});

		$next.click(function($event) {

			$event.preventDefault();

			if (current < $step.length) {

				if ($form.valid()) {

					$step.show();

					$step
						.not(':eq(' + (current++) + ')')
						.hide();

					top();

					progress(current);

				}
			}

			buttons(current);

		});

		$prev.click(function($event) {

			$event.preventDefault();

			if (current > 1) {

				current = current - 2;

				if (current < $step.length) {

					$step.show();

					$step
						.not(':eq(' + (current++) + ')')
						.hide();

					top();

					progress(current);

				}

			}

			buttons(current);

		});

		$nav.show();

		go();

		$(window).on('hashchange', hash);

	}

	$(function() {

		if ($fp.find('.steps').length) {

			main();

		}

	});

}(jQuery, document, window));