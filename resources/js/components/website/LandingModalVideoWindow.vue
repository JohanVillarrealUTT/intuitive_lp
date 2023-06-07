<template>
    <modal :show-modal="showModal" :max-width="'1280px'">
        <video-section-frame>
            <iframe class="resp-iframe"  :src="activeSlide.url" frameborder="0" allowfullscreen ></iframe>
        </video-section-frame>
        <slide-layout>
            <div class="arrow-cont" @click="prevStep">
                <img src="/images/landing-page/slide-images/left-arrow.png">
            </div>
            <button-secundary  @click="emitClose">Cerrar</button-secundary>
            <video-section-text>
                <span>SIGUIENTE</span>
                <span>Trabaja como Asociado de Manufactura #SoyToyotaBC</span>
            </video-section-text>

            <!-- <div class="thumbnail">
                <img src="/images/landing-v2/thumbnails/thumbnail-1.png">
            </div> -->
            <div class="arrow-cont" @click="nextStep">
                <img src="/images/landing-page/slide-images/right-arrow.png">
            </div>
        </slide-layout>
    </modal>
</template>

<script>
import $ from 'jquery'
import styled, { css } from 'vue-emotion'
import colors from '@/config/website/WebsiteColors.js'
import { EventBus } from '@/event-bus.js'
import Modal from '@/components/website/LandingModalWindow.vue'
import DialogueSlider from '@/components/website/VideoSlideComponent.vue'
import variables from '@/config/website/WebsiteVariables.js'
import {ButtonSecundary} from '@/config/website/BaseConstants.vue'

const SlideLayout = styled('div')`
		display: grid;
        
        grid-template-columns: auto 5fr auto;
        @media (min-width: 701px) {
            grid-template-columns: 1fr 2fr 5fr 1fr;
        }
        
        align-items: center;
        background-color: ${colors.landing.darkGray};
        padding: ${variables.dialogueModalVideo.padding};

		.arrow-cont {
            justify-self: center;
        
			padding: 1.5rem;
			opacity: .5;
			transition: ${variables.transition};
		}

		.arrow-cont:hover {
			opacity: 1;
        }

        .thumbnail {
            padding: 10px
            display: block;
            display: none;
            @media (min-width: 701px) {
                display:block;
            }
        }
        
        .thumbnail img {;
            width: 180px;
            height: 100px;
        }
    `

const VideoSectionFrame = styled('div')`
    position: relative;
    overflow: hidden;
    padding-top: 56.25%;
    .resp-iframe{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
`
const VideoSectionText = styled('p')`
		color: white;
        text-align: Right;
        padding: 10px;
        display: none;
        @media (min-width: 701px) {
            display:block;
        }

		& > :first-of-type {
			font-weight: ${variables.sections.videoCard.hashtagFontWeight};
            font-size: ${variables.sections.videoCard.hashtagFontSize};
            margin: 5px;
        }
        
        & > :nth-of-type(2) {
            font-weight: ${variables.dialogueModalVideo.mutedText.fontWeight};
            font-size: ${variables.dialogueModalVideo.mutedText.fontSize};
            color: ${colors.landing.clearGray};
        }

		span {
			display: block;
		}
    ` 

export default {
	name: 'LandingModalVideoWindow',
    components: {
        Modal,
        ButtonSecundary,
        SlideLayout,
        VideoSectionFrame,
        VideoSectionText
    },
    props: ['show-modal', 'max-width'],
    
  data() {
        return {
            modalContentMaxWidthCss: css({
                maxWidth: this.maxWidth
            }),
			activeSlide: {},

			slides: [
				{
					url: 'https://www.youtube.com/embed/f2FKJRvkMWc',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/CqlsQkhx71M',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/vVHusOBWGcs',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/uxaEyCTs9zY',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/g5U8563KI4s',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/dMGf3iPoBbk',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/U1JSHtLjYiQ',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/NRVutC-djSk',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/IXwJ5pYCM5M',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed//DdxiTiI92K0',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/91rlrTTmxtY',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/6uHLtsKS_e8',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/6-wp3pNBIMY',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
				{
					url: 'https://www.youtube.com/embed/2qtALfhLnFM',
					title: 'Trabaja como Asociado de Manufactura #SoyToyotaBC'
				},
            ],
        }
    },
    
    created() {
        this.activeSlide = this.slides[0];
        // this.automatic()
    },
    methods: {

        emitClose() {
            EventBus.$emit('closeVideoModal')
        },

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

    },
}
</script>