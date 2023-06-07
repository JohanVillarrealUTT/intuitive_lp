<template>
	<modal :show-modal="show_modal" :max-width="'600px'">
		
        <modal-content v-if="subscription_response == true">
            <b>Gracias por compartir tu información</b>
            <h2>¡Pasaste a la siguiente fase del proceso!</h2>
            <p>
                <b>¿Que sigue?</b> Ingresa a tu cuenta de correo electrónico, ya que <b>te hemos enviado un correo que contiene las instrucción y un enlace para llevar a cabo un examen.</b>
            </p>
            <p>
                Te recomendamos tener tu RFC y datos de contacto a la mano, así como <b>realizar el examen en una computadora.</b>
            </p>
            <p>
                ¡Nuevamente gracias!
            </p>
            <p>
                Atentamente: R.H. Reclutamiento
            </p>
            <p-button :full_width="false" @on-click="show_modal = false">Cerrar</p-button>
		</modal-content>
        <modal-content v-if="subscription_response == false">
            <b>Gracias por compartir tu información</b>
            <h2>Lo sentimos..</h2>
            <p>
                Después de evaluar tu información, encontramos que lamentablemente <b>tu perfil no se adecúa a los requisitos que estamos buscando para esta vacante.</b>    
            </p>
            <p>
               Te queremos agradecer por el tiempo e interés mostrado por trabajar en <b>Toyota Motor Manufacturing de Baja California.</b>    
            </p>
            <p>
                Seguimos en contacto.
            </p>
            <p>
                Atentamente: R.H. Reclutamiento
            </p>
            <p-button :full_width="false"  @on-click="emitAccept">Cerrar</p-button>
		</modal-content>
	</modal>
</template>

<script>
	import modal from '@/components/website/LandingModalWindow.vue'
	import styled from 'vue-emotion'
	// import pButton from '@/components/website/ButtonSecondary.vue'
	import {EventBus} from '@/event-bus.js' 
    import {ModalContent, ButtonPrimary as pButton} from '@/config/website/BaseConstants.vue'
    import colors from '@/config/website/WebsiteColors.js'


	export default {
		props: ['show_modal', 'subscription_response'], 

		name: 'SubscriptionResponseNotification',

		components: {
			modal,
			ModalContent,
			pButton
		},

		methods: {
			emitAccept() {
				EventBus.$emit('closeNotification')
			}
		}

	}
</script>