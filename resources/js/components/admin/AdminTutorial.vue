<template>
    <modal-window :show-modal="showModal" v-if="selected_step != {}" max-width="600px">
    	<tut-grid>
    		<tut-section>
				<tut-gif class="fadable" :src="`${BaseUrl}/images/admin/tutorial/${selected_step.img}`"></tut-gif>
			</tut-section>
			<tut-section>
				<!-- <tut-bubbles-grid class="tut-grid-center"> -->
				<tut-bubble v-for="step in tutorialSteps" :key="step.title" v-bind:class="{active: step == selected_step}" @click="changeToStep(step)"></tut-bubble>
				<!-- </tut-bubbles-grid> -->
			</tut-section>
			<tut-section>
				<tut-title class="fadable">
					{{selected_step.title}}
				</tut-title>
				<tut-paragraph class="fadable">
					{{selected_step.description}}
				</tut-paragraph>
			</tut-section>
			<tut-section>
				<button-primary @on-click="nextWillInjectCookie">
					<span>Adelante</span>
				</button-primary>
			</tut-section>	
		</tut-grid>
    </modal-window>
</template>

<script>
	import $ from 'jquery'
	import ModalWindow from '@/components/admin/ModalWindow.vue'
	import ButtonPrimary from '@/components/admin/ButtonPrimary.vue'	
	import colors from '@/config/admin/AdminColors.js'
	import styled, { css } from 'vue-emotion'
	import { EventBus } from '@/event-bus.js'

	const TutGrid = styled('div')`
	    align-items: center;
	    display: grid;
	    padding: 1.5rem;
	    grid-template-columns: auto;
	    grid-template-rows: auto;
	`

	const TutSection = styled('div')`
		padding: .5rem 0;
		text-align: center;

		.active {
			background-color: ${colors.primary.UNBlue};
		}
	`
	
	const TutTitle = styled('h4')`
		font-size: 1rem;
		font-weight: bold;
		margin: 0px 0px .5rem 0px;
	`
	
	const TutParagraph = styled('p')`
		font-size: 14px;
		margin: 0;
	`

	const TutBubblesGrid = styled('div')`
		display: grid;
		grid-template-columns: repeat(auto-fill, 1.5rem);
	    grid-template-rows: 1fr;
	    align-items: center;
	`

	const TutBubble = styled('div')`
		border-radius: 50%;
		width: 1rem;
		background-color: ${colors.neutral.Isabelline};
		height: 1rem;
		display: inline-block;
		margin:  0 .25rem;
	`

	const TutGif = styled('img')`
		width: 100%;
		border: 1px solid ${colors.neutral.Isabelline}
	`

	export default {
		name: 'AdminTutorial',

		components: {
			ModalWindow,
			ButtonPrimary,
			TutGrid,
			TutSection,
			TutTitle,
			TutParagraph,
			TutBubblesGrid,
			TutBubble,
			TutGif,
		},

		data: () => ({
			showModal: true,
			tutorialSteps: [
				{
					title:'Aspirantes organizados en pestañas',
					description: 'Esta nueva caracteristica te permitirá enfocarte en los nuevos aspirantes sin que los previamente aceptados o rechazados interrumpan tu proceso de reclutamiento.',
					img: 'pestanas.gif'
				},
				{
					title:'Etiqueta tu proceso de reclutamiento',
					description: 'Esta nueva caracteristica te permitirá organizar facilmente tu proceso de reclutamiento, utilizando una etiqueta de diferente color para cada paso de tu proceso.',
					img: 'etiquetas.gif'
				},
			],
			selected_step: {},

			autoStepsData: {
				active_position: 0,
				is_auto: false,
				step_time: 23000
			},

			animation: ''

		}),

		created() {
			this.selected_step = this.tutorialSteps[0];
			// this.autoSteps()
		},

		watch: {
			selected_step: function () {
				this.ChangeStep(this.selected_step)
			},

			'autoStepsData.is_auto': function(_new, _old) {
				let _this = this

				if (_new) {
					this.animation = setInterval(function() {
						_this.nextStep()
					}, _this.autoStepsData.step_time)
				} else {
					clearTimeout(this.animation)
				}

			}
		},

		computed: {
			BaseUrl: () => {
				return window.location.origin
			},

			isLastStep: function() {
				return this.selected_step == this.tutorialSteps[this.tutorialSteps.length-1] ? true : false
			},

			buttonText: function() {
				return this.isLastStep ? 'Cerrar' : 'Adelante!'
			},

			step: function(index) {
				return this.tutorialSteps[index]
			}
			
		},

		methods: {
			
			autoSteps() {
				this.autoStepsData.is_auto = true
			},

			cancelAutoSteps() {
				this.autoStepsData.is_auto = false
			},

			nextStep() {
				let is_last = this.autoStepsData.active_position == this.tutorialSteps.length-1
				if (is_last) {
					this.autoStepsData.active_position = 0	
				} else {
					++ this.autoStepsData.active_position
				}

				this.ChangeStep(this.tutorialSteps[this.autoStepsData.active_position])

				return new Promise((resolve) => {
					resolve('ok!')
				})

			},

			changeToStep(step) {
				let _this = this
				if (this.selected_step != step) {
					this.ChangeStep(step)
					this.autoStepsData.is_auto = false
					this.autoStepsData.active_position = this.tutorialSteps.indexOf(step)

					setTimeout(function() {
						_this.autoStepsData.is_auto = true
					}, 2000)
				}
			},

			ChangeStep(step) {
				
				if (this.selected_step != step) {
					let _this = this
					$('.fadable').animate({opacity: 0},
						150, function() {
							_this.selected_step = step
							$('.fadable').animate({opacity: 1},150);
					});	
				}

			},

			nextWillInjectCookie() {
				let step = this.tutorialSteps[this.autoStepsData.active_position + 1]
				this.isLastStep ? this.close() : this.changeToStep(step)
			},

			close() {
				EventBus.$emit('finish-tutorial')
			}
		},
	}
</script>