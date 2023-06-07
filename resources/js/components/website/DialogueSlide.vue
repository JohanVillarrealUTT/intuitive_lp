<template>
	<main-slider>
		<div class="will-fade">
    		<slide-p>
    			{{slide_text}}
    		</slide-p>
    	</div>
    	<div class="will-fade">
    		<slide-image class="slider-image" :src="`/images/landing-page/slide-images/${slide_img}`" alt=""></slide-image>
    	</div>
	</main-slider>
</template>

<script>
	import styled, { css } from 'vue-emotion'
	import variables from '@/config/website/WebsiteVariables.js'


	const MainSlider = styled('div')`
		display: grid;
		grid-template-columns: 1fr;
		grid-template-rows: .6fr 1fr;
		align-items: center;
		text-align: center;
		overflow: hidden;

		@media (min-width: ${variables.dialogueSlide.breakpoint}) {
			grid-template-columns: 1.5fr 1fr;
			grid-template-rows: 1fr;
		}
	`

	const SlideP = styled('p')`
		color: white;
		font-weight: 600;
		font-size: ${variables.dialogueSlide.textBreakpoints.sm.fontSize};

		@media (min-width: ${variables.dialogueSlide.textBreakpoints.sm.screen}) {
			font-size: ${variables.dialogueSlide.textBreakpoints.sm.fontSize};
		}

		@media (min-width: ${variables.dialogueSlide.textBreakpoints.md.screen}) {
			font-size: ${variables.dialogueSlide.textBreakpoints.md.fontSize};
		}

		@media (min-width: ${variables.dialogueSlide.textBreakpoints.lg.screen}) {
			font-size: ${variables.dialogueSlide.textBreakpoints.lg.fontSize};
		}
	`

	const SlideImage = styled('img')`
		width: 100%;
		max-width: 200px;
		display: block;
		margin: auto;
	`


	export default {
		name: 'DialogueSlide',

		props: ['slide_img', 'slide_text'],

		components: {
			MainSlider,
			SlideP,
			SlideImage
		}
	}
</script>