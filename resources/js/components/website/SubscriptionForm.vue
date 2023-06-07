<template>
    <div>
        <template>

            <form-header>
                <span v-if="activeStepId == 1">
                    Antes de comenzar tu registro para nosotros es importante conocer si cumples con algunos requisitos, contesta las siguientes preguntas:
                </span>
            </form-header>

            <main-form
                id="subscription-form"
                @submit="validateSubscription2($event)"
                class="subscription-form"
                :class="{ 'subscription-form--disabled': formDisabled }"
            >

                <!-- paso 1 -->
                <card v-if="activeStepId == 1">

                    <input-group>
                        <radio-input-group
                            label="¿Has trabajado en el sector industrial maquilador?"
                            name="worked_before"
                            :value="preFormData.worked_before"
                            v-model="preFormData.worked_before"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                    <input-group>
                        <radio-input-group
                            label="¿Puedes trabajar en turnos de 12 horas? Matutino o Nocturno de 6:00 a 6:00 de 4x3"
                            name="will_work_12_hours"
                            :value="preFormData.will_work_12_hours"
                            v-model="preFormData.will_work_12_hours"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                    <input-group>
                        <radio-input-group
                            label="¿Puedes trabajar en ambas plantas (nelson y carranza)?"
                            name="will_work_multiple_locations"
                            :value="preFormData.will_work_multiple_locations"
                            v-model="preFormData.will_work_multiple_locations"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                </card>

                <!-- paso 2 -->
                <card v-if="activeStepId == 2">

                    <box class="box">Datos personales</box>

                    <input-group>
                        <text-input
                            v-model="formData.name"
                            label="Nombres(s)"
                            name="name"
                            v_validate_rules="required"
                        ></text-input>
                    </input-group>

                    <double-input-group>

                        <text-input
                            v-model="formData.last_name_1"
                            label="Apellido paterno"
                            name="last_name_1"
                            v_validate_rules="required"
                        ></text-input>

                        <text-input
                            v-model="formData.last_name_2"
                            label="Apellido materno"
                            name="last_name_2"
                            v_validate_rules="required"
                        ></text-input>

                    </double-input-group>

                    <input-group>
                        <text-input
                            v-model="formData.nickname"
                            label="Nombre preferido"
                            small="Opcional"
                            name="nickname"
                            v_validate_rules=""
                        ></text-input>
                    </input-group>

                    <input-group>
                        <text-input
                            type="email"
                            v-model="formData.email"
                            label="Correo electrónico"
                            name="email"
                            v_validate_rules="required|email"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <text-input
                            type="date"
                            v-model="formData.birth_date"
                            label="Fecha de nacimiento"
                            name="birth_date"
                            v_validate_rules="required"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <radio-input-group
                            label="Sexo de nacimiento"
                            name="gender"
                            :value="formData.gender"
                            v-model="formData.gender"
                            v_validate_rules=""
                            :options="formOptions.gender"
                        ></radio-input-group>
                    </input-group>

                    <input-group>
                        <select-input
                            v-model="formData.marital_status"
                            label="Estado civil"
                            small="Opcional"
                            name="marital_status"
                            :options="formOptions.marital_status.map(o => ({label: o, value: o}))"
                            v_validate_rules="required"
                        ></select-input>
                    </input-group>

                    <input-group>
                        <phone-input
                            v-model="formData.phone"
                            label="Teléfono personal (10 dígitos)"
                            name="phone"
                            v_validate_rules="required|length:10|numeric"
                        ></phone-input>
                    </input-group>

                    <input-group>
                        <phone-input
                            v-model="formData.home_phone"
                            label="Teléfono casa (10 dígitos)"
                            small="Opcional"
                            name="home_phone"
                            v_validate_rules="length:10|numeric"
                        ></phone-input>
                    </input-group>

                    <input-group>
                        <text-input
                            v-model="formData.zip_code"
                            label="Código postal"
                            name="zip_code"
                            v_validate_rules="required"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <text-input
                            v-model="formData.address"
                            label="Domicilio (Colonia, calle, número)"
                            name="address"
                            v_validate_rules="required"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <select-input
                            v-model="formData.transportation"
                            label="Medio de transporte"
                            name="transportation"
                            :options="formOptions.transportation.map(o => ({label: o, value: o}))"
                            v_validate_rules="required"
                        ></select-input>
                    </input-group>

                    <input-group>
                        <radio-input-group
                            label="¿Tienes pasaporte / Visa vigente?"
                            name="visa"
                            :value="formData.visa"
                            v-model="formData.visa"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                </card>

                <card v-if="activeStepId == 3">

                    <box class="box">Estudios</box>

                    <input-group>
                        <select-input
                            v-model="formData.school_degree"
                            label="Último grado de estudios"
                            name="school_degree"
                            :options="formOptions.school_degree.map(o => ({label: o, value: o}))"
                            v_validate_rules="required"
                        ></select-input>
                    </input-group>

                    <input-group>
                        <text-input
                            v-model="formData.school_name"
                            label="Nombre de la escuela"
                            small="Opcional"
                            name="school_name"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <text-input
                            v-model="formData.school_career"
                            label="Carrera"
                            small="Opcional"
                            name="school_career"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <text-input
                            v-model="formData.school_training"
                            label="CAPACITACIÓN O ENTRENAMIENTO RECIBIDOS"
                            small="Opcional"
                            name="school_training"
                        ></text-input>
                    </input-group>

                    <input-group>
                        <radio-input-group
                            label="¿Estudias actualmente?"
                            name="still_studying"
                            v-model="formData.still_studying"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                    <template v-if="formData.still_studying == 'Si'">

                        <input-group>
                            <text-input
                                v-model="formData.still_studying_name"
                                label="¿Qué estudias?"
                                name="still_studying_name"
                                v_validate_rules="required"
                            ></text-input>
                        </input-group>

                        <input-group>
                            <text-input
                                v-model="formData.still_studying_schedule"
                                label="Horario"
                                name="still_studying_schedule"
                                v_validate_rules="required"
                            ></text-input>
                        </input-group>

                        <input-group>
                            <text-input
                                v-model="formData.still_studying_school"
                                label="Escuela"
                                name="still_studying_school"
                                v_validate_rules="required"
                            ></text-input>
                        </input-group>

                    </template>

                    <input-group>
                        <radio-input-group
                            label="¿Hablas inglés?"
                            name="english"
                            v-model="formData.english"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                </card>

                <card v-if="activeStepId == 4">

                    <box class="box">Contacto de emergencia</box>

                     <input-group>
                        <text-input
                            v-model="formData.emergency_contact_name"
                            label="Nombre del contacto"
                            name="emergency_contact_name"
                            v_validate_rules="required"
                        ></text-input>
                    </input-group>

                     <input-group>
                        <phone-input
                            v-model="formData.emergency_contact_phone"
                            label="Teléfono del contacto"
                            name="emergency_contact_phone"
                            v_validate_rules="required|length:10|numeric"
                        ></phone-input>
                    </input-group>



                    <box class="box">Últimos empleos</box>

                    <div v-for="(job, index) in formData.jobs" :key="index">
                        <div>

                            <input-group>
                                <text-input
                                    v-model="job.company"
                                    label="Empresa"
                                    :name="`job[${index}][company]`"
                                    :key="`job[${index}][company]`"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                            <input-group>
                                <text-input
                                    v-model="job.position"
                                    label="Puesto"
                                    :name="`job[${index}][position]`"
                                    :key="`job[${index}][position]`"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                            <input-group>
                                <text-input
                                    v-model="job.duration"
                                    label="Duración"
                                    :name="`job[${index}][duration]`"
                                    :key="`job[${index}][duration]`"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                            <input-group>
                                <text-input
                                    v-model="job.breakup_reason"
                                    label="Motivo de separación"
                                    :name="`job[${index}][breakup_reason]`"
                                    :key="`job[${index}][breakup_reason]`"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                        </div>

                        <options-row>
                            <div></div>
                            <button
                                tabindex="0"
                                class="delete"
                                type="button"
                                v-if="formData.jobs.length > 1"
                                @click="deleteJob(index)">eliminar</button>
                        </options-row>

                    </div>

                    <options-row>
                        <div></div>
                        <link-button-primary
                            v-if="formData.jobs.length < 2"
                            @click="pushJob"> AGREGAR EMPLEO </link-button-primary>
                    </options-row>

                    <box class="box">General</box>

                    <input-group>
                        <select-input
                            v-model="formData.vacancy_found_by"
                            label="¿Cómo te enteraste de la vacante?"
                            name="vacancy_found_by"
                            :options="formOptions.vacancy_found_by.map(o => ({label: o, value: o}))"
                            v_validate_rules="required"
                        ></select-input>
                    </input-group>

                    <template v-if="formData.vacancy_found_by == 'Recomendación'">
                        <input-group>
                            <text-input
                                v-model="formData.referenced_by"
                                label="Nombre y número de empleado que te recomendó"
                                name="referenced_by"
                                v_validate_rules="required"
                            ></text-input>
                        </input-group>

                    </template>

                    <input-group>
                        <radio-input-group
                            label="¿Has trabajado anteriormente en intuitive?"
                            name="ex_worker"
                            v-model="formData.ex_worker"
                            v_validate_rules="required"
                            :options="formOptions.boolean"
                        ></radio-input-group>
                    </input-group>

                    <terms-check
                        v-model="terms_and_conditions"
                        :name="'terms_and_conditions'"
                        v_validate_rules="required"
                        :value="terms_and_conditions"
                    ></terms-check>

                </card>

                <buttons-wrapper>

                    <button-secundary
                        v-if="activeStepId > 2"
                        type="button"
                        @click="onPrevStep"> ANTERIOR
                    </button-secundary>

                    <button-primary
                        type="button"
                        @click="onNextStep"> SIGUIENTE
                    </button-primary>

                </buttons-wrapper>


            </main-form>

        </template>


        <response-modal
            @close="subscriptionResponseModal.show = false"
            :show_modal="subscriptionResponseModal.show"
            :message="subscriptionResponseModal.message"
            :modal_title="subscriptionResponseModal.title"
        ></response-modal>

        <response-modal
            @close="already_subscribed = false"
            :show_modal="already_subscribed"
            :message="`
                Lo sentimos, pero no podemos dejar que te registres de nuevo en esta campaña.
                <br>
                <br>
                Si fuiste aceptado, nosotros te contactaremos.
            `"
            modal_title="¡Atención!"
        ></response-modal>

        <appointment-modal
            :show-modal="selectAppointment.show_modal"
            :subscription-data="selectAppointment.subscriptionData"
            @close="selectAppointment.show_modal = false"
        ></appointment-modal>

        <validation-errors-modal
            :show_modal="show_validation_errors_modal"
            :error_list="validation_error_list"
        ></validation-errors-modal>

        <registration-rejected-modal v-model="showNoProfileModal" max-width="600px"></registration-rejected-modal>
    </div>
</template>

<script>
import $ from "jquery";
import Cookies from "vue-cookie";
import styled, { css } from "vue-emotion";

import {
    Box,
    InputGroup,
    DoubleInputGroup,
    ButtonPrimary,
    ButtonSecundary,
    TitleH2,
    ErrorMessage,
    Card,
    LinkButtonPrimary
} from "@/config/website/BaseConstants.vue";

import TextInput from "@/components/website/TextInput.vue";
import PhoneInput from "@/components/website/PhoneInput.vue";
import SelectInput from "@/components/website/SelectInput.vue";
import FileInput from "@/components/website/FileInput.vue";
import variables from "@/config/website/WebsiteVariables.js";
import colors from "@/config/website/WebsiteColors.js";
import SliderSelectInput from "@/components/website/SliderSelectInput.vue";
import MapSelectInput from "@/components/website/MapSelectInput.vue";
import RadioInputGroup from "@/components/website/RadioInputGroup.vue";
import TermsCheck from "@/components/website/TermsAndConditionsCheck.vue";
import ResponseModal from "@/components/website/SubscriptionGeneralResponse.vue";
import AppointmentModal from "@/components/website/SubscriptionAppointmentModal.vue";
import ValidationErrorsModal from "@/components/website/ValidationErrorsModal.vue";
import RegistrationRejectedModal from "@/components/website/RegistrationRejectedModal.vue";
import FormHeader from '@/components/website/FormHeader.vue'

import { EventBus } from "@/event-bus";
import services from "@/services/WebsiteServices.js";

const preRegistrationRejectedCookieName = 'pre_registration_rejected'
const subscribedCookieName = 'subscribed'

const MainForm = styled("form")`
    margin: 0 auto 3rem;
    max-width: ${variables.sections.subscription.formMaxWidth};
    padding: 2rem;

    label[for="cv"] {
        color: ${colors.brand.dimSec};
        cursor: pointer;
        display: block;
        padding-top: 1rem;

        &:hover {
            color: ${colors.brand.sec};
        }
    }

    .box {
        font-size: .75em;
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        text-transform: uppercase;
    }
`;

const JobsExplanation = styled("p")`
    color: ${colors.brand.dark};

    b {
        text-transform: uppercase;
        margin-bottom: 1rem;
        display: block;
    }

    span {
        color: ${colors.brand.dimSec};
    }
`;

const JobInputGroup = styled(InputGroup)`
    position: relative;
    padding-bottom: 0;

    .inputs-cont {
        margin-bottom: 1.5rem;

        /*&:before {
            content: "";
            position: absolute;
            top: 0;
            left: -1.5rem;
            width: 0.25rem;
            height: 100%;
            background-color: ${colors.brand.sec};
        }*/

        div:nth-of-type(2) {
            padding-bottom: 0;
        }
    }
`;

const OptionsRow = styled("div")`
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;

    * {
        cursor: pointer;
    }

    button {
        appearance: none;
        border: none;
        background: none;
    }

    .delete {
        text-align: right;
        color: ${colors.brand.negative};
        grid-column-start: 2;
        grid-column-end: 3;
    }

    .new {
        text-transform: uppercase;
        font-weight: 600;
        text-align: left;
        color: ${colors.brand.prim};
        grid-column-start: 1;
        grid-column-end: 3;
    }
`;

const STitleH2 = styled(TitleH2)`
    margin-bottom: 1rem;
`

const StyledButton = styled(ButtonPrimary)`
    width: 100%;
    max-width: 440px;
`;

const ButtonsWrapper = styled('div')`
    padding: 1rem 0;
    text-align: right;
`

export default {
    name: "SubscriptionForm",

    components: {
        MainForm,
        InputGroup,
        DoubleInputGroup,
        JobInputGroup,
        JobsExplanation,
        TextInput,
        PhoneInput,
        SelectInput,
        FileInput,
        SliderSelectInput,
        MapSelectInput,
        RadioInputGroup,
        TermsCheck,
        StyledButton,
        ResponseModal,
        AppointmentModal,
        ValidationErrorsModal,
        OptionsRow,
        Box,
        STitleH2,
        ErrorMessage,
        RegistrationRejectedModal,
        FormHeader,
        ButtonPrimary,
        ButtonSecundary,
        Card,
        ButtonsWrapper,
        LinkButtonPrimary
    },

    provide() {
        return { parentValidator: this.$validator };
    },

    data() {
        return {

            terms_and_conditions: "",

            subscriptionResponseModal: {
                show: false,
                title: '',
                message: '',
            },

            selectAppointment: {
                show_modal: false,
                subscriptionData: {}
            },

            validation_error_list: [],
            show_validation_errors_modal: false,

            formDisabled: false,

            already_subscribed: false,

            windowWidth: "",

            jobsRequiredError: false,

            showNoProfileModal: false,

            steps: {
                1: {
                    fields: []
                },
                2: {
                    fields: [
                        'name',
                        'last_name_1',
                        'last_name_2',
                        'nickname',
                        'email',
                        'birth_date',
                        'gender',
                        'marital_status',
                        'phone',
                        'home_phone',
                        'zip_code',
                        'address',
                        'transportation',
                        'visa',
                    ]
                },
                3: {
                    fields: [
                        'school_degree',
                        'school_name',
                        'school_career',
                        'school_training',
                        'still_studying',
                        'still_studying_name',
                        'still_studying_schedule',
                        'still_studying_school',
                        'english',
                    ]
                },
                4: {
                    fields: [
                        'emergency_contact_name',
                        'emergency_contact_phone',
                        'jobs',
                        'vacancy_found_by',
                        'referenced_by',
                        'ex_worker',
                    ]
                },
            },

            activeStepId: 1,

            preFormData: {
                worked_before: null,
                will_work_12_hours: null,
                will_work_multiple_locations: null,
            },

            formData: {
                name: null,
                last_name_1: null,
                last_name_2: null,
                nickname: null,
                email: null,
                birth_date: null,
                gender: null,
                marital_status: null,
                phone: null,
                home_phone: null,
                zip_code: null,
                address: null,
                transportation: null,
                visa: null,
                school_degree: null,
                school_name: null,
                school_career: null,
                school_training: null,
                still_studying: null,
                still_studying_name: null,
                still_studying_schedule: null,
                still_studying_school: null,
                english: null,
                emergency_contact_name: null,
                emergency_contact_phone: null,
                jobs: [{
                    company: null,
                    position: null,
                    duration: null,
                    breakup_reason: null
                }],
                vacancy_found_by: null,
                referenced_by: null,
                ex_worker: null,
            },

            formOptions: options
        }
    },

    mounted() {
        let _this = this;

        window.addEventListener("resize", this.handleResize);
        this.handleResize();

        EventBus.$on("closeAndAcceptTerms", function() {
            _this.terms_and_conditions = "on";
        });

        EventBus.$on("returnError", function(e) {
            _this.errors.add(e);
        });

        EventBus.$on("closeValidationErrors", function() {
            _this.show_validation_errors_modal = false;
        });

        EventBus.$on("closeAlreadySubscribedModal", function() {
            _this.already_subscribed = false;
        });

        this.subscriptionCookieCheck();
        this.checkRegistrationRejectedCookie();
    },

    methods: {
        onNextStep() {
            if (this.activeStepId == 1) {
                this.handleFirstStep()
            } else {
                this.$validator.validate()
                    .then(valid => {
                        if (valid) {
                            if (this.activeStepId < Object.keys(this.steps).length) {
                                ++this.activeStepId
                            } else {
                                this.submit()
                            }
                        }
                    })
            }

        },
        onPrevStep() {
            if (this.activeStepId == 1) return
            --this.activeStepId
        },
        handleFirstStep() {
            let validateKeys = Object.keys(this.preFormData);
            this.$validator.validateAll(validateKeys)
                .then(valid => {
                    if (valid) {
                        let registrationBlocked = !!validateKeys.find(keyname => {
                                return this.preFormData[keyname] == 'No'
                            })

                        if (registrationBlocked) {
                            this.handleRegistrationRejected()
                        } else {
                            ++this.activeStepId
                        }
                    }
                })
        },
        handleRegistrationRejected() {
            Cookies.set(preRegistrationRejectedCookieName, 1, {
                expires: '1d'
            })
            this.checkRegistrationRejectedCookie()
        },
        checkRegistrationRejectedCookie() {
            if (Cookies.get(preRegistrationRejectedCookieName)) {
                this.showNoProfileModal = true
                this.formDisabled = true;
            }
        },
        subscriptionCookieCheck() {
            let cookie = Cookies.get(subscribedCookieName);

            if (cookie) {
                this.formDisabled = true;
                this.already_subscribed = true;
                let oldData = JSON.parse(localStorage.getItem("formData"));

                if (oldData !== null) {
                    this.formData = oldData;
                }
            }
        },
        handleResize() {
            this.windowWidth = window.innerWidth;
        },

        validateSubscription2(event) {
            if (event)
                event.preventDefault();

            let {jobs} = this.formData;

            if (!jobs.length) {
                this.jobsRequiredError = true;
            }

            this.$validator.validate().then(valid => {
                if (valid && jobs.length) {
                    this.submit();
                }
            });
        },

        submit() {services.postSubscription(this.formData)
                .then(res => {
                    this.handleFormSuccess(res.data);
                })
                .catch(err => {
                    if (err.response && err.response.status == 422) {
                        this.handleFormErrors(err.response.data.errors);
                    } else {
                        this.handleException();
                    }
                });
        },

        handleFormErrors(errors) {
            this.validation_error_list = errors;
            this.show_validation_errors_modal = true;
        },

        handleFormSuccess(data) {
            this.formDisabled = true;
            Cookies.set(subscribedCookieName, true);

            localStorage.setItem(
                "formData",
                JSON.stringify(this.formData)
            );

            switch (data.status) {
                case 'Aceptado':
                    this.handleAccepted(data)
                    break;
                case 'Rechazado':
                    this.handleRejected(data)
                    break;
                default:
                this.handleException();
                    break;
            }
        },
        handleAccepted(data) {
            this.selectAppointment.subscriptionData = data;
            this.selectAppointment.show_modal = true;
        },
        handleRejected(data) {
            if (this.formData.school_degree == 'Universidad') {
                this.subscriptionResponseModal.title = 'Gracias por tu interés en Intuitive';
                this.subscriptionResponseModal.message = `
                    Te invitamos a postularte a alguna de nuestras vacantes como profesionista.
                    <br>
                    <br>
                    Haz clic y encuentra la vacante ideal para ti:
                    <a href="https://careers.intuitive.com/us/en">
                        https://careers.intuitive.com/us/en
                    </a>
                `;
            } else {
                this.subscriptionResponseModal.title = 'Gracias por compartir tus datos';
                this.subscriptionResponseModal.message = `
                    Gracias por tu interés y por el tiempo y dedicación que nos brindaste en el proceso de selección para el puesto Técnico de Ensamble Especializado.
                    <br>
                    <br>
                    Ya no continuaremos con éste proceso, debido a que existen otros perfiles que se adecúan más con lo que producción está buscando.
                    <br>
                    <br>
                    Ahora que tuvimos la oportunidad de saber más de ti vamos a conservar tu información para futuras oportunidades acordes a tu perfil.
                `;
            }
            this.subscriptionResponseModal.show = true;
        },
        handleException() {
            alert("Ocurrió un error. Intente de nuevo más tarde");
        },

        pushJob() {
            this.formData.jobs.push({
                company: null,
                position: null,
                duration: null,
                breakup_reason: null
            });
        },

        deleteJob(i) {
            this.formData.jobs.splice(i, 1);
        },

        randomNumber() {
            return Math.round(Math.random() * 10000000000)
        }
    },

    computed: {
        preRegistrationRejectedCookie() {
            return Cookies.get(preRegistrationRejectedCookieName)
        },
        subscribedCookie() {
            return Cookies.get(subscribedCookieName)
        },
        activeStep() {
            return this.steps[this.activeStepId]
        },
    }
};
</script>
