<template>
	<modal :show-modal="show_modal" :max-width="'600px'">
		
        <modal-content v-if="cookie_response == true">
            <h2>¡ Atención !</h2>
            <p>
                Lo sentimos, pero no podemos dejar que te registres de nuevo en esta campaña.<br><br>Si fuiste aceptado, <b>nosotros te contactaremos.</b>
            </p>
            <p-button @click="emitClose">
	            Cerrar
	        </p-button>
		</modal-content>
	</modal>
</template>

<script>
	import modal from '@/components/website/LandingModalWindow.vue'
	import styled from 'vue-emotion'
	import {ButtonPrimary} from '@/config/website/BaseConstants.vue'
	import {EventBus} from '@/event-bus' 
    import colors from '@/config/website/WebsiteColors.js'

	const ModalContent = styled('div')`
		padding: 2rem;
        background-color: white;
        text-align: center;
		
		*:not(button) {
			color: ${colors.brand.dark};
		}

        h2{
            margin-top: 0px;
        }
        color: #fff;
		> h, p, ul, li {
			margin-bottom: 2rem;
		}
	`

	const pButton = styled(ButtonPrimary)`
		width: 100%;
		padding: 1rem;
    `

	export default {
		props: ['show_modal', 'cookie_response'], 

		name: 'CokieResponseNotification',

		components: {
			modal,
			ModalContent,
			pButton
		},

		methods: {
			emitClose() {
				EventBus.$emit('closeAlreadySubscribedModal')
			}
		}

	}
</script>