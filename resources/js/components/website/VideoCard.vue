<template>
	<main-video-card>
		<div>
			<video-section-copy class="copy">
				<span>#SoyToyotaBC</span>
				<span>Conoce el testimonio de nuestros asociados.</span>
			</video-section-copy>
			<button-secundary  id="show-modal" @click="showModal = true">Ver videos</button-secundary>
			<video-modal :show-modal="showModal"  :max-width="'960px'"></video-modal>
		</div>
	</main-video-card>
</template>

<script>
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'
	import styled from 'vue-emotion'	
	import VideoModal from '@/components/website/LandingModalVideoWindow.vue'
	import {ButtonSecundary} from '@/config/website/BaseConstants.vue'
	import { EventBus } from '@/event-bus.js'


    const MainVideoCard = styled('div')`
    	display: grid;
        padding: ${variables.sections.videoCard.padding};
        background:  ${colors.landing.orange};

        @media (min-width: ${variables.sections.halfs.breakPoint}) {
        	background-position-x: ${variables.sections.videoCard.backgroundNegativeMargin};
        }

        & > :first-of-type {
        	align-self: center;
        	margin: 0;
	    	justify-self: center;
	    	text-align: center;
        }

        @media (min-width: 600px) {
        	background:  ${colors.landing.orange} url('${variables.sections.videoCard.backgroundImage}') no-repeat;
	        background-position-x: ${variables.sections.videoCard.responsiveBackgroundNegativeMargin};

        	& > :first-of-type {
				margin-right: 20rem;
				justify-self: unset;
		    	text-align: left;
        	}
        }
    `

    const VideoSectionCopy = styled('p')`
		color: white;

		& > :first-of-type {
			font-weight: ${variables.sections.videoCard.hashtagFontWeight};
			font-size: ${variables.sections.videoCard.hashtagFontSize};
		}

		span {
			display: block;
		}
    ` 

	export default {
		name: 'VideoCard',

		components: {
			MainVideoCard,
			ButtonSecundary,
			VideoSectionCopy,
			VideoModal
		},
		
		data: () => ({
			showModal: false
		}),

		created() {
			let _this = this
			EventBus.$on('closeVideoModal', function(e) {
	            _this.showModal = false
	        })
		},

		methods: {
			manageShowModal(){
				this.showModal = !this.showModal
			}
		},
	}
</script>