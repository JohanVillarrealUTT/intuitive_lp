<template>
    <div>
        <landing-nav></landing-nav>
        <app-main>
            <landing-section>
                <appointment-page-content>
                    <div class="form-container">
                        <title-h1 class="title">{{ isCreating ? 'Crear' : 'Cambiar'}} Cita</title-h1>
                        <p>Ingresa el folio o número de teléfono de tu registro</p>
                        <form
                            method="get"
                            @submit.prevent="onGetAppointment()"
                            :disabled="subscriptionData"
                        >
                            <input-group class="input-group">
                                <text-input
                                    v-model="form.keyword"
                                    :label="'Folio o teléfono'"
                                    :name="'keyword'"
                                    :v_validate_rules="'required'"
                                ></text-input>
                            </input-group>
                            <input-group>
                                <button-primary
                                    class="block"
                                    :disabled="subscriptionData"
                                >Buscar</button-primary>
                            </input-group>
                        </form>

                    </div>
                    <div class="appointment-selection-container">
                        <template v-if="subscriptionData">
                            <box class="current-appointment">
                                <div>
                                    <div class="titles">
                                        <span>Nombre</span>
                                    </div>
                                    <div class="text">
                                        <span>{{ subscriptionData | formatName }}</span>
                                    </div>
                                </div>
                                <div v-if="subscriptionData && subscriptionData.appointment_hour">
                                    <div class="titles">
                                        <span>Fecha</span>
                                        <br>
                                        <span>Hora</span>
                                    </div>
                                    <div class="text">
                                        <span>{{ subscriptionData.appointment_hour.date.date | formatDate }}</span>
                                        <br>
                                        <span>{{ subscriptionData.appointment_hour.hour }}</span>
                                    </div>
                                </div>
                            </box>
                            
                            <div class="appointment-selection">
                                
                                <small>Selecciona la nueva fecha y hora</small>
                                
                                <div class="appointment-selection-section">
                                    <p>
                                        <i> <img src="/images/landing-page/icons/calendar-alt.svg"> </i>
                                        Fechas disponibles
                                    </p>
                                    <div class="available-dates">
                                        <template v-if="availableDates.length">
                                            <box
                                                v-for="date in availableDates"
                                                :class="{ active: selectedDate && selectedDate.id == date.id }"
                                                :key="date.id"
                                                @click="onSelectDate(date)">
                                                {{ date.date | formatDate }}
                                            </box>
                                        </template>
                                        <template v-else>
                                            <error-message class="mt0">Sin fechas disponibles</error-message>
                                        </template>
                                    </div>
                                </div>
                                
                                <div class="appointment-selection-section" v-if="selectedDate">
                                    <p>
                                        <i> <img src="/images/landing-page/icons/clock.svg"> </i>
                                        Horarios disponibles
                                    </p>
                                    <div class="available-dates">
                                        <template v-if="selectedDate.hours.length">
                                            <box
                                                v-for="shcedule in selectedDate.hours"
                                                :class="{ active: selectedSchedule && selectedSchedule.id == shcedule.id }"
                                                :key="shcedule.id"
                                                @click="selectedSchedule = shcedule">
                                                {{ shcedule.hour }}
                                            </box>
                                        </template>
                                        <template v-else>
                                            <error-message class="mt0">Sin horarios disponibles</error-message>
                                        </template>
                                    </div>
                                </div>

                                <hr>

                                <div class="new-appointment">
                                    <title-h2>Nueva fecha y hora</title-h2>
                                    <div class="new-appointment-wrapper">
                                        <div class="boxes">
                                            <box class="active" v-if="selectedDate">
                                                {{ selectedDate.date | formatDate }}
                                            </box>
                                            <box class="active" v-if="selectedSchedule">
                                                {{ selectedSchedule.hour }}
                                            </box>
                                        </div>
                                        <div>
                                            <button-primary
                                                class="block"
                                                :disabled="!selectedDate || !selectedSchedule || state.sending"
                                                @click="onSubmit()"
                                            >
                                                Confirmar
                                            </button-primary>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>
                        <template v-else-if="subscriptionDataError">
                            <box>
                                <error-message class="mt0">
                                    Folio o Teléfono no encontrado
                                </error-message>
                            </box>
                        </template>

                    </div>
                </appointment-page-content>
            </landing-section>
        </app-main>

        <modal :show-modal="showSuccessModal" max-width="370px">
            <success-modal-content>
                <div class="icon">
                    <img src="/images/landing-page/icons/calendar-check.svg">
                </div>
                <p>Tu nueva fecha de cita es:</p>

                <box class="new-date-box">
                    {{ newAppointment.date | formatDate }}
                    <br>
                    {{ newAppointment.hour }}
                </box>

                <div class="appointment-location">
                    <p>Lugar de la cita:</p>
                    <div class="location">
                        <div class="icon">
                            <img src="/images/landing-page/icons/location-blue.svg">
                        </div>
                        <p class="location-text">
                            Calzada Venustiano Carranza 1745, Colonia sin asignación, entre calles Blvd, Lázaro Cárdenas y Calle Palmar de Santa Anita CP 21226
                        </p>
                    </div>
                    <a href="https://www.google.com/maps/d/edit?mid=1XFNCathHJCZ8XMq5E4N7hvlmTkPAp7Yv&usp=sharing" title="">Ver mapa</a>
                </div>

                <button-primary class="block" @click="reset()">
                    Aceptar
                </button-primary>
            </success-modal-content>
        </modal>

        <landing-footer></landing-footer>
    </div>
</template>

<script>
import TRY from '@/config/website/BaseConstants.vue'
import variables from '@/config/website/WebsiteVariables.js'
import colors from '@/config/website/WebsiteColors.js'
import Modal from '@/components/website/LandingModalWindow.vue'

import styled, { css } from 'vue-emotion'
import {
    AppMain,
    TitleH1,
    TitleH2,
    LandingSection,
    BorderedBox,
    ImageAndTextBullet,
    ButtonPrimary,
    InputGroup,
    Box,
    ErrorMessage,
} from '@/config/website/BaseConstants.vue'
import LandingNav from '@/components/website/LandingNav.vue'
import LandingFooter from '@/components/website/Footer.vue'
import TextInput from "@/components/website/TextInput.vue";
import services from "@/services/WebsiteServices.js";
import appointmentSetupMixin from '@/mixins/appointmentSetupMixin.js'

const AppointmentPageContent = styled('div')`
    line-height: 1.8;
    padding: 2rem;
    font-size: .875rem;

    .form-container {
        margin-bottom: 2rem;
    }

    .form-container p {
        font-size: 1em;
        margin-bottom: 2rem;
        color: ${colors.brand.dimSec}
    }

    .appointment-selection-container {
        flex-grow: 1;
    }

    .current-appointment {
        padding: 1rem;

        > div {
            display: flex;
            width: 100%;
        }
        
        .titles {
            width: 100%;
            max-width: 70px;
            text-align: right;
            font-weight: 600;
            text-transform: uppercase;
            color: ${colors.brand.prim};
            margin-right: .5rem;
        }
        .text {
            flex-grow: grow;
        }
    }

    .appointment-selection {
        > small {
            color: ${colors.brand.dimSec}
        }

        .appointment-selection-section {
            margin-bottom: 1rem;

            > p {
                font-size: 1em;
                img {
                    width: 12px;
                    margin-right: .5rem;
                }
            }
        }

        .available-dates {
            display: flex;
            flex-wrap: wrap;

            > * {
                margin-right: .5rem;
                margin-bottom: .5rem;
            }
        }
    }

    hr {
        margin: 1.5rem 0;
        border: 0;
        border-top: ${colors.general.stainedGray} 1px solid;
    }

    .new-appointment {
        h2 {
            font-size: 1rem;
            color: ${colors.brand.prim};
        }

        .new-appointment-wrapper {
            margin-top: 1rem;
            .boxes {
                display: flex;
                margin-bottom: 1.5rem;
                align-items: center;

                > * {
                    margin-right: .5rem;
                    margin-bottom: .5rem;
                }
            }
        }
    }

    @media (min-width: ${ variables.commonBreakpoints.md }) {
        display: flex;
        padding: 4rem 0rem;
        font-size: 1rem;
        
        .form-container {
            margin-right: 114px;
            max-width: 300px;
        }
        
        .current-appointment {
            display: flex;    
        }
        
        .appointment-selection-container {
            flex-grow: 1;
            max-width: 600px;
        }

        .new-appointment .new-appointment-wrapper {
            display: flex;

            .boxes {
                flex-grow: 1
            }
        }

    }
`

const SuccessModalContent = styled('div')`
    padding: 2rem;
    max-width: 240px;
    margin: auto;
    font-size: .875rem;
    text-align: center;

    > p { font-size: 1rem; }

    .icon {
        text-align: center;
    }

    .new-date-box {
        margin: 1rem  auto;
        font-weight: 600;
        color: ${ colors.brand.prim };
    }

    .appointment-location {
        margin-bottom: 1rem;

        .location {
            display: flex;
        }

        > p { font-size: 1rem; }

        .icon {
            margin-right: 1rem;
        }

        .location-text {
            margin-top: 0;
            color: ${colors.brand.dimSec};
            text-align: left;
        }
    }
`

export default {
    name: 'AppointmentPage',
    components: {
        AppMain,
        TitleH1,
        TitleH2,
        LandingSection,
        LandingNav,
        BorderedBox,
        ButtonPrimary,
        LandingFooter,
        AppointmentPageContent,
        InputGroup,
        TextInput,
        Box,
        ErrorMessage,
        Modal,
        SuccessModalContent
    },
    mixins: [ appointmentSetupMixin ],
    filters: {
        formatName({name, last_name}) {
            return `${name} ${last_name}`
        }
    },
    provide() {
        return { parentValidator: this.$validator };
    },
    data() {
        return {
            form: {
                keyword: ''
            },
            subscriptionData: null,
            subscriptionDataError: false,
            showSuccessModal: false,
            newAppointment: {}
        }
    },
    computed: {
        isCreating() {
            return this.$route.params.creating;
        }
    },
    methods: {
        async onSubmit() {
            let subscriber_id = this.subscriptionData.id;
            let appointment_hour_id = this.selectedSchedule.id;

            this.state.sending = true;
            
            let p = this.isCreating
                ? services.postAppointment({subscriber_id, appointment_hour_id})
                : services.updateAppointment(subscriber_id, appointment_hour_id)
             
            await p
                .then(r => {
                    this.state.sent = true;
                    this.newAppointment.date = this.selectedDate.date
                    this.newAppointment.hour = this.selectedSchedule.hour
                    this.showSuccessModal = true;
                })
                .catch(e => {
            
                    if (e.response) {
                         alert(e.response.data.message);
                    } else {
                        this.handleException()
                    }
                })
            
            this.state.sending = false;

        },
        handleException() {
            alert("Ocurrió un error. Intente de nuevo más tarde");
        },
        onGetAppointment() {
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.getAppointment()
                }
            });
        },
        getAppointment() {
            services.getAppointment(this.form.keyword)
                .then( r => {
                    this.subscriptionDataError = false
                    if (r.data.success) {
                   
                        if (! r.data.data.subscriber.appointments.length) {
                            this.$router.replace('/citas/crear');
                        } else {
                            this.$router.replace('/citas');
                        }

                        this.availableDates = r.data.data.available_appointments
                        this.subscriptionData = r.data.data.subscriber
                        
                    } else {
                        this.subscriptionDataError = true
                    }
                })
                .catch(e => {
                    this.handleException()
                })
        },
        reset() {
            this.selectedDate = null;
            this.selectedSchedule = null;
            this.subscriptionData = null;
            this.availableDates = [];
            this.state.sent = false;
            this.form.keyword = '';
            this.showSuccessModal = false;
            this.newAppointment = {};
            window.location.reload();
        }
    }

}
</script>