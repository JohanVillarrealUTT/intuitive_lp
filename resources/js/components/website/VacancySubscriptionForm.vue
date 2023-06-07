<template>
    <div>
        <template>

            <form-header>
                <span v-if="activeStepId == 1">
                    Antes de comenzar tu registro para nosotros es importante conocer si cumples con algunos requisitos, contesta las siguientes preguntas:
                </span>
            </form-header>

            <main-form
                id="vacancy-subscription-form"
                @submit="validateSubscription2($event)"
                class="subscription-form"
                :class="{ 'subscription-form--disabled': formDisabled }"
            >

                <!-- paso 1 -->
                <card v-if="activeStepId == 1">
                    <input-group>
                        <select-input
                            v-model="formData.job_interest"
                            label="Selecciona la vacante de interés"
                            name="job_interest"
                            :options="formOptions.job_interest.map(o => ({label: o, value: o}))"
                            v_validate_rules="required"
                        ></select-input>
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
                            type="email"
                            v-model="formData.email"
                            label="Correo electrónico"
                            name="email"
                            v_validate_rules="required|email"
                        ></text-input>
                    </input-group>

                </card>

                <card v-if="activeStepId == 3">
                    <template v-if="formData.job_interest == 'Material y logística'">
                        <box class="box">Material y logística</box>
                        <input-group>
                            <select-input
                                v-model="formData.work_experience"
                                label="¿Tienes experiencia en almacén y/o control de inventarios?"
                                name="work_experience"
                                :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                v_validate_rules="required"
                            ></select-input>
                        </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.equipment_handling"
                                    label="¿Manejas algún equipo de carga? "
                                    name="equipment_handling"
                                    :options="formOptions.load_equipment.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <text-input v-if="formData.equipment_handling == 'Otro'"
                                    v-model="formData.other"
                                    label="¿Cuál?"
                                    name="other"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.material_control"
                                    label="¿Has utilizado algún sistema para control de material?"
                                    name="material_control"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <text-input v-if="formData.material_control == 'Si'"
                                    v-model="formData.other_material_control"
                                    label="¿Cuál?"
                                    name="other_material_control"
                                    v_validate_rules="required"
                                ></text-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.schedule_availability"
                                    label="¿Tienes disponibilidad de horario?"
                                    name="schedule_availability"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.certificate"
                                    label="¿Cuentas con Certificado de preparatoria o Carrera Técnica ?"
                                    name="certificate"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>
                    </template>

                    <template v-if="formData.job_interest == 'Técnico de calidad'">
                        <box class="box">Técnico de calidad</box>
                        <input-group>
                            <select-input
                                v-model="formData.work_experience"
                                label="¿Has laborado en áreas de calidad? "
                                name="work_experience"
                                :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                v_validate_rules="required"
                            ></select-input>
                        </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.equipment_handling"
                                    label="¿Has utilizado herramientas de medición?"
                                    name="equipment_handling"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.certificate"
                                    label="¿Cuentas con Certificado de preparatoria o Carrera Técnica?"
                                    name="certificate"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.schedule_availability"
                                    label="¿Tienes disponibilidad de horario?"
                                    name="schedule_availability"
                                    :options="formOptions.boolean.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>

                            <input-group>
                                <select-input
                                    v-model="formData.english_level"
                                    label="¿Qué nivel de inglés manejas?"
                                    name="english_level"
                                    :options="formOptions.english_level.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></select-input>
                            </input-group>
                            <!-- <input-group>
                                <file-input
                                    v-model="formData.cv_path"
                                    label="Agrega tu CV"
                                    name="schedule_availability"
                                    :options="formOptions.english_level.map(o => ({label: o, value: o}))"
                                    v_validate_rules="required"
                                ></file-input>
                            </input-group> -->
                    </template>
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
                    <button-primary
                        v-if="activeStepId === 3 && isSection3Complete"
                        type="button"
                        @click="guardarDatos"
                        >
                        Guardar datos
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
    // name: "SubscriptionForm",

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
~
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
                        'phone',
                        'email',

                    ]
                },
                3: {
                    fields: [
                        'work_experience',
                        'equipment_handling',
                        'material_control',
                        'schedule_available',
                        'certificate',
                        'english_level',
                        'cv_path',
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
                phone: null,
                email: null,

                work_experience: null,
                equipment_handling: null,
                availability_schedule: null,
                certificate: null,

                english_level: null,
                cv_path: null,
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

        submit() {services.postVacancySubscription(this.formData)
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
