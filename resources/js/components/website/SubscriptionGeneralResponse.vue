<template>
	<modal :show-modal="show_modal" :max-width="'540px'">
		<div style="text-align: right;">
			<modal-close-button @click="$emit('close')">
				<img src="/images/landing-page/icons/material-close.svg">
			</modal-close-button>
		</div>
        <s-modal-content>
        	<h2>{{ modal_title }}</h2>
        	<div v-html="message"></div>
            <button-secundary
            	:full_width="false"
            	@click="$emit('close')"
            >
            	Cerrar
            </button-secundary>
		</s-modal-content>
	</modal>
</template>

<script>
	import modal from '@/components/website/LandingModalWindow.vue'
	import {EventBus} from '@/event-bus.js' 
	import styled from 'vue-emotion'
    import {
    	ModalContent,
    	ButtonSecundary
    } from '@/config/website/BaseConstants.vue'

    const SModalContent = styled(ModalContent)`
    	padding: 0 4rem 2rem;
    	line-height: 1.5;
    `

    const ModalCloseButton = styled('button')`
    	appearance: none;
    	border: none;
    	background-color: transparent;
    	padding: .5rem;
    	cursor: pointer;
    `

	export default {
		props: ['show_modal', 'message', 'modal_title'], 

		name: 'SubscriptionResponseNotification',

		components: {
			modal,
			SModalContent,
			ButtonSecundary,
			ModalCloseButton
		},

	}
</script>