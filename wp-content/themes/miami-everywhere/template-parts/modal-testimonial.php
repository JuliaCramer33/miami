<?php
/**
 * Template Part: Testimonial Modal Structure (Refactored)
 *
 * @package MiamiEverywhere
 */
?>
<!-- Testimonial Modal -->
<div id="testimonial-modal" class="testimonial-modal" aria-labelledby="testimonial-modal-title" role="dialog" aria-modal="true">

	<div class="testimonial-modal__content-wrapper">

		<div class="testimonial-modal__header bg-primary">
			<button class="testimonial-modal__close" aria-label="Close modal">
				<span>Close</span>
				<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
			</button>
		</div> <!-- /testimonial-modal__header -->

		<!-- Section 1: Hero (Image & Meta) -->
		<section class="testimonial-modal__section testimonial-modal__section--hero has-warm-white-background-color">
			<div class="container container-lg">
				<div class="testimonial-modal__hero-image">
					<!-- Populated by JS: <img src="..." alt="..." > -->
				</div>
				<div class="testimonial-modal__hero-meta">
					<h2 id="testimonial-modal-title" class="testimonial-modal__hero-name">
						<!-- Populated by JS: Student Name -->
					</h2>
					<ul class="testimonial-modal__hero-details">
						<li class="testimonial-modal__hero-detail--class">
							<p class="font-semibold">Class:&nbsp;</p><p class="value"><!-- Populated by JS --></p>
						</li>
						<li class="testimonial-modal__hero-detail--major">
							<p class="font-semibold">Major(s):&nbsp;</p><p class="value"><!-- Populated by JS --></p>
						</li>
						<li class="testimonial-modal__hero-detail--minor">
							<p class="font-semibold">Minor(s):&nbsp;</p><p class="value"><!-- Populated by JS --></p>
						</li>
					</ul>
				</div>
			</div> <!-- /container -->
		</section> <!-- /testimonial-modal__section--hero -->

		<!-- Section 2: Main Content -->
		<section class="testimonial-modal__section testimonial-modal__section--content">
			<div class="container container-md">
				<div class="testimonial-modal__content-body">
					<!-- Populated by JS: Story Main Content -->
				</div>
			</div> <!-- /container -->
		</section> <!-- /testimonial-modal__section--content -->

		<!-- Section 3: Gallery -->
		<section class="testimonial-modal__section testimonial-modal__section--gallery">
			<div class="container container-lg">
				<div class="testimonial-modal__gallery-slider">
					<!-- Populated by JS: Slider HTML -->
				</div>
			</div> <!-- /container -->
		</section> <!-- /testimonial-modal__section--gallery -->

		<!-- Section 4: Quote -->
		<section class="testimonial-modal__section testimonial-modal__section--quote has-warm-white-background-color">
			<div class="container container-md">
				<div class="testimonial-modal__quote-content">
					<svg class="testimonial-modal__quote-icon text-primary block mb-4" width="70" height="58" viewBox="0 0 70 58" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
						<path d="M20.5 0.675537L29.75 8.17555C21.75 13.4255 14.5 23.4255 13.75 31.4255C14 31.4255 15.75 31.1755 17 31.1755C24 31.1755 29 36.4255 29 43.9255C29 51.1755 23.25 57.1755 15.75 57.1755C7.5 57.1755 0.25 50.4255 0.25 38.1755C0.25 22.9256 9 8.92554 20.5 0.675537ZM60.5 0.675537L69.75 8.17555C61.75 13.4255 54.75 23.4255 53.75 31.4255C54 31.4255 55.75 31.1755 57 31.1755C64 31.1755 69.25 36.4255 69.25 43.9255C69.25 51.1755 63.25 57.1755 55.75 57.1755C47.5 57.1755 40.25 50.4255 40.25 38.1755C40.25 22.9256 49 8.92554 60.5 0.675537Z" fill="currentColor"/>
					</svg>
					<blockquote class="max-w-2xl mx-auto mb-4 text-left">
						<!-- Populated by JS: Story Pull Quote -->
					</blockquote>
					<cite class="testimonial-modal__quote-cite not-italic block">
						<!-- Populated by JS: Student Name (Quote Attribution) -->
					</cite>
				</div>
			</div> <!-- /container -->
		</section> <!-- /testimonial-modal__section--quote -->

	</div><!-- /content-wrapper -->
</div><!-- /modal -->
