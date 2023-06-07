<template>
	<modal :show-modal="showModal" :max-width="'600px'">		
        <modal-content>
        	<modal-head-content>
        		<small>
        			<b>¡FELICIDADES!</b>
        		</small>
				<modal-title>Has completado satisfactoriamente el formulario de evaluación</modal-title>
	        	<box class="outlined sm">
					Tu folio de registro es: <b>{{ subscriptionData.folio }}</b>
				</box>
        		<p>
					Ahora te invitamos a seleccionar el día y hora en el que te gustaría realizar el proceso de reclutamiento.</strong>
				</p>
        	</modal-head-content>
        	
        	<hr>

        	<modal-body-content>

				<boxes-selection class="dates-selection">
					<p class="title">
	                    <i> <img src="/images/landing-page/icons/calendar-alt.svg"> </i>
	                    Fechas disponibles
	                </p>
					<div v-if="availableDates.length" class="selection-area">
						<box
							v-for="date in availableDates"
							:class="['box', { active: selectedDate && selectedDate.id == date.id }]"
							:key="date.id"
							@click="onSelectDate(date)">
							{{ date.date | formatDate }}
						</box>
					</div>
					
					<div v-else-if="!state.datesLodaded">
						Cargando fechas disponibles, espera un momento.
					</div>

					<div v-else class="empty-dates">
						Sin fechas disponibles.
					</div>

				</boxes-selection>

				<boxes-selection v-if="selectedDate" class="dates-selection">
					<p class="title">
	                    <i> <img src="/images/landing-page/icons/clock.svg"> </i>
	                    Horarios disponibles
	                </p>
					<div v-if="availableDates.length" class="selection-area">
						<box
							v-for="schedule in selectedDate.hours"
							:class="['box', { active: selectedSchedule && selectedSchedule.id == schedule.id }]"
							:key="schedule.id"
							@click="selectedSchedule = schedule">
							{{ schedule.hour }}
						</box>
					</div>
					
					<div v-else>
						No hay horarios disponibles en esta fecha.
					</div>

				</boxes-selection>


				<boxes-selection v-if="selectedDate">
					<modal-title>Fecha y hora seleccionados</modal-title>
					<div class="selection-area">
						<box class="active"> {{ selectedDate.date | formatDate }} </box>
						<box class="active" v-if="selectedSchedule"> {{ selectedSchedule.hour }} </box>
					</div>
				</boxes-selection>

				<hr>


	            <p-button
	            	:full_width="false"
	            	@click="onSubmit()"
	            	:disabled="!selectedDate || !selectedSchedule || state.sending"
	            >
	            	Agendar cita
	            </p-button>

	            <p class="thanks-text">
	            	¡Nuevamente gracias!
	            	<br>
	            	Atentamente: R.H. Reclutamiento
	            </p>
        	</modal-body-content>

		</modal-content>
	</modal>
</template>

<script>
	import modal from '@/components/website/LandingModalWindow.vue'
	import services from '@/services/WebsiteServices.js'
	import appointmentSetupMixin from '@/mixins/appointmentSetupMixin.js'
	import {EventBus} from '@/event-bus.js' 
	import styled, {css} from 'vue-emotion'
	import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'
    
    import {
    	Box,
    	ButtonPrimary
    } from '@/config/website/BaseConstants.vue'

    const ModalContent = styled('div')`
    	padding: 2rem;

    	hr {
    		border: none;
    		border-bottom: ${ colors.general.dimGrey } 1px solid;
    		margin: 2rem 0;
    	}

    	.thanks-text {
    		color: ${ colors.brand.mid };
    		text-align: center;
    	}
    `

    const ModalHeadContent = styled('div')`
    	text-align: center;
    `
    const ModalBodyContent = styled('div')`
    	.empty-dates {
    		color: ${colors.landing.red};
    	}
    `
    const ModalTitle = styled('h2')`
		font-size: 1em;
		color: ${ colors.brand.prim };
		text-transform: uppercase;

    `


    const pButton = styled(ButtonPrimary)`
		width: 100%;
		padding: 1rem;
    `

    const BoxesSelection = styled('div')`
		text-align: left;
		
    	.title {
    		margin-bottom: 1rem;
    	}

    	.selection-area {
			display: flex;
			flex-wrap: wrap;
			margin-bottom: 1rem;
			
			> * {
				margin: .25rem;
				cursor: pointer;
			}
    	}

    `

	export default {
		props: ['showModal', 'subscriptionData'], 
		name: 'SubscriptionAppointmentModal',
		components: {
			ModalHeadContent,
			ModalBodyContent,
			ModalTitle,
			Box,
			BoxesSelection,
			modal,
			ModalContent,
			pButton,
		},
		mixins: [ appointmentSetupMixin ],
		mounted() {
			this.loadDates();
		},
		methods: {
			onSubmit() {

				this.state.sending = true;

				let data = {
					subscriber_id: this.subscriptionData.subscriber_id,
			        appointment_hour_id: this.selectedSchedule.id
				};
				
				this.state.sending = false;

				services.postAppointment(data)
					.then(r => {
						this.closeModal();

						this.$toast.success(r.data.message, {
				            position: 'top',
				            duration: 15000,
				        })

						// window.location.reload()
					})
					.catch(e => {
						this.handleException(e)
					})

				// console.log({data})
			},
			closeModal() {
				this.$emit('close')
				// location.reload();
			},
			handleException() {
	            alert("Ocurrió un error. Intente de nuevo más tarde");
	        },
		}

	}
</script>