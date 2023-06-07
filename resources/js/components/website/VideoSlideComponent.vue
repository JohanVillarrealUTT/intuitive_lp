<template>
    <slide-layout>
    	<div id="main-slider">
			<slide :slide_img="activeSlide.img" :slide_text="activeSlide.text"></slide>
    	</div>
    	<div class="arrow-cont" @click="prevStep">
    		<img src="/images/landing-page/slide-images/left-arrow.png">
    	</div>
    	<div class="arrow-cont" @click="nextStep">
    		<img src="/images/landing-page/slide-images/right-arrow.png">
    	</div>
    </slide-layout>
</template>

<script>
	import $ from 'jquery'
	import styled, { css } from 'vue-emotion'
	import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'

	import slide from '@/components/website/DialogueSlide.vue'

	const SlideLayout = styled('div')`
		display: grid;
		width: 100%;
		max-width: 600px;
		grid-template-columns: auto 5fr auto;
		padding: 0 1rem;
		background-color: ${colors.landing.red};

		.arrow-cont {
			justify-self: center;
			align-self: end;
			padding-bottom: 1rem;
			opacity: .5;
			transition: ${variables.transition};
		}

		.arrow-cont:hover {
			opacity: 1;
		}
	`

	export default {
		name: 'DialogueSlide',

		components: {
			slide,
			SlideLayout,
		},

		data: () => ({

			activeSlide: {},

			slides: [
				{
					text: 'Cada mes estamos rotando turnos, ¡No te puedes perder esta gran aventura!',
					img: 'slide-3.png'
				},
				{
					text: 'Manejamos 3 turnos: el primero de lunes a sábado, el segundo y tercero de lunes a viernes.',
					img: 'slide-2.png'
				},
				{
					text: 'El puesto de asociado de manufactura rola turnos.',
					img: 'slide-1.png'
				},
			],

		}),

		created() {
			this.activeSlide = this.slides[2];
			this.automatic()
		},

		methods: {
			

			nextStep() {
				this.fadeChange()
			},

			prevStep() {
				// true will make dialogue slider go back one slide
				this.fadeChange(true)
			},


			fadeChange(key = false) {
				let _this = this
				$('#main-slider').css( 'height', $('#main-slider').outerHeight() );

				$('.will-fade').fadeOut(100, function() {
					let actual_step = _this.slides.indexOf(_this.activeSlide)
					
					if (!key) {
						if (actual_step != _this.slides.length-1) {
							_this.activeSlide = _this.slides[_this.slides.indexOf(_this.activeSlide) +1]
						}	
						else {
							_this.activeSlide = _this.slides[0]
						}
					}
					else {
						if (actual_step != 0) {
							_this.activeSlide = _this.slides[_this.slides.indexOf(_this.activeSlide) -1]
						}
						else {
							_this.activeSlide = _this.slides[_this.slides.length-1]
						}
					}

					setTimeout(function() {
						$('.will-fade').fadeIn(100);
						$('#main-slider').css( 'height', 'auto' );
					}, 100)

				});			

			},


			automatic() {
				let _this = this

				setTimeout(function() {					
					_this.fadeChange()
					_this.automatic()
				}, 4000)
			}

		},
	}
</script>