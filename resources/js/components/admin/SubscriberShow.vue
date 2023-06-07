<template>
    <modal-window :show-modal="showModal" max-width="1250px">
        <modal-head>
            <color-tag
                v-if="rowData.label"
                :color="rowData.label.color"></color-tag>
            <modal-title>
                {{ rowData.full_name }} {{ rowData.nickname && `(${rowData.nickname})` }}
                <modal-subtitle>{{ $parent.getSubscriberStatusText(rowData) }} <span v-if="rowData.rejection_reason">({{ rowData.rejection_reason }})</span></modal-subtitle>
            </modal-title>
        </modal-head>
        <modal-body>
            <modal-options>
                <modal-options-item>
                    <color-tag-radios>
                        <color-tag-radio
                            v-for="(label, index) in allLabels"
                            @selected-color-tag="onClickColorTag"
                            :checked="rowData.label && rowData.label.id === label.id"
                            :color="label.color"
                            :data-id="rowData.id"
                            :id="`modal-color-tag-${index}`"
                            :key="index"
                            :name="'modal-color-tags'"
                            :value="label.id"
                        ></color-tag-radio>
                    </color-tag-radios>
                    <a
                        :href="`/uploads/cvs/rowDatas_${rowData.id}/${rowData.file.fileurl}`"
                        download
                        v-if="rowData.file"
                    >Descargar CV</a>
                    <a
                        href="#"
                        v-if="!rowData.rejected && !rowData.candidate"
                        v-on:click.prevent="onClickAceptar(true, rowData.id)"
                    >Aceptar</a>
                    <a
                        href="#"
                        v-else
                        v-on:click.prevent="onClickMoveToCandidatos(false, false, rowData.id)"
                    >Mover a Candidatos</a>
                    <a
                        href="#"
                        v-if="!rowData.rejected"
                        v-on:click.prevent="onClickRejected(true, rowData.id)"
                    >Rechazar</a>
                    <a
                        class="color-danger"
                        href="#"
                        v-on:click.prevent="onClickDelete(rowData)"
                    >Eliminar</a>
                </modal-options-item>
                <modal-options-item>
                    <a href="#" v-on:click.prevent="onClickClose">Cerrar</a>
                </modal-options-item>
            </modal-options>
            <modal-data>
                <template>
                    <modal-appointments-section-title>
                        <h3>Historial de citas</h3>
                        <div>
                            <a href="#" @click.prevent="onClickCreateAppointment">Crear cita</a>
                        </div>
                    </modal-appointments-section-title>
                    
                    <modal-data-item-h-span-2 v-if="!rowData[appointmentsBag] || !rowData[appointmentsBag].length">
                        Sin citas
                    </modal-data-item-h-span-2>

                    <modal-data-item-h-span-2
                        v-else
                        v-for="ap in rowData[appointmentsBag]"
                        :key="ap.id"
                    >
                        <form @submit.prevent="onSubmitUpdateAppointment(ap)">
                            <modal-appointment-row>
                                <div class="top">
                                    <div class="data">
                                        <form-field 
                                            label="Fecha y hora" :value="formatDate(ap.date.date) + ' ' + ap.hour" readonly>
                                        </form-field>
                                    </div>
                                    <div class="actions">
                                        <select-input
                                            label="Estatus de la cita"
                                            v-model="ap.pivot.status"
                                            :value="ap.pivot.status"
                                            :options="appointmentStatusesOptions"
                                            :disabled="!['programada', null].includes(ap.pivot.status)">
                                        </select-input>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div>
                                        <form-field-textarea v-model="ap.pivot.comment" label="Comentario sobre esta cita"></form-field-textarea>
                                        <div style="text-align: right;">
                                            <button-primary type="submit">Guardar cambios</button-primary>
                                        </div>
                                    </div>
                                </div>
                            </modal-appointment-row>
                        </form>
                    </modal-data-item-h-span-2>
                    
                </template>
                <!-- <template v-if="rowData.appointment_hour != null">
                    
                    <modal-data-item>
                        <form-field 
                            label="Fecha y hora de cita" :value="formatDate(rowData.appointment_hour.date.date) + ' ' + rowData.appointment_hour.hour" readonly>
                        </form-field>
                    </modal-data-item>
                    
                    <modal-data-item>
                    </modal-data-item>
                </template> -->

                
                <modal-data-item-h-span-2>
                    <h3>Datos personales</h3>
                </modal-data-item-h-span-2>
                    

            
                <modal-data-item v-if="rowData.phone">
                    <form-field
                        label="Teléfono"
                        :value="rowData.phone"
                        readonly
                    ></form-field>
                </modal-data-item>
                

                <modal-data-item v-if="rowData.home_phone">
                    <form-field
                        label="Teléfono casa"
                        :value="rowData.home_phone"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.birth_date">
                    <form-field
                        label="Fecha de nacimiento"
                        :value="formatDate(rowData.birth_date)"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.email != null">
                    <form-field
                        label="Correo electrónico"
                        :value="rowData.email"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.address != null">
                    <form-field
                        label="Dirección"
                        :value="rowData.address + ', CP ' + rowData.zip_code"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.gender != null">
                    <form-field
                        label="Género de nacimiento"
                        :value="rowData.gender"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.marital_status != null">
                    <form-field
                        label="Estado civil"
                        :value="rowData.marital_status"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.transportation != null">
                    <form-field
                        label="Medio de trasporte"
                        :value="rowData.transportation"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.visa != null">
                    <form-field
                        label="Visa / Pasaporte vigente"
                        :value="rowData.visa"
                        readonly
                    ></form-field>
                </modal-data-item>

                
                <modal-data-item-h-span-2>
                    <h3>Estudios</h3>
                </modal-data-item-h-span-2>

                
                <modal-data-item v-if="rowData.school_degree">
                    <form-field
                        label="Grado de estudios (con certificado)"
                        :value="rowData.school_degree"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.school_name">
                    <form-field
                        label="Nombre de la escuela"
                        :value="rowData.school_name"
                        readonly
                    ></form-field>
                </modal-data-item>

                <modal-data-item v-if="rowData.school_career">
                    <form-field
                        label="Carrera"
                        :value="rowData.school_career"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.school_training">
                    <form-field
                        label="Capacitación / Entrenamiento"
                        :value="rowData.school_training"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.still_studying">
                    <form-field
                        label="¿Estás estudiando actualmente?"
                        :value="rowData.still_studying"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.still_studying_name">
                    <form-field
                        label="¿Qué estudias?"
                        :value="rowData.still_studying_name"
                        readonly
                    ></form-field>
                </modal-data-item>
                
                <modal-data-item v-if="rowData.still_studying_school">
                    <form-field
                        label="Escuela"
                        :value="rowData.still_studying_school"
                        readonly
                    ></form-field>
                </modal-data-item>

                <modal-data-item v-if="rowData.still_studying_name">
                    <form-field
                        label="Horario"
                        :value="rowData.still_studying_name"
                        readonly
                    ></form-field>
                </modal-data-item>

                <modal-data-item v-if="rowData.english">
                    <form-field
                        label="Habla inglés"
                        :value="rowData.english"
                        readonly
                    ></form-field>
                </modal-data-item>

                
                <modal-data-item-h-span-2>
                    <h3>Contacto de emergencia</h3>
                </modal-data-item-h-span-2>


                <modal-data-item v-if="rowData.emergency_contact_name">
                    <form-field
                        label="Nombre del contacto"
                        :value="rowData.emergency_contact_name"
                        readonly
                    ></form-field>
                </modal-data-item>

                <modal-data-item v-if="rowData.emergency_contact_phone">
                    <form-field
                        label="Teléfono del contacto"
                        :value="rowData.emergency_contact_phone"
                        readonly
                    ></form-field>
                </modal-data-item>

            
                
                <modal-data-item-h-span-2>
                    <h3>Últimos empleos</h3>
                </modal-data-item-h-span-2>

                <template v-if="JSON.parse(rowData.jobs).length">
                    
                    <template v-for="(job, index) in JSON.parse(rowData.jobs)">
                        
                        <modal-data-item
                            v-for="(value, key) in parseJob(job)"
                            :key="index+key"
                        >
                            <form-field :label="key" :value="value" readonly></form-field>
                        </modal-data-item>
                    </template>

                </template>

                <template v-else>
                    Sin empleos
                </template>
                
                <modal-data-item-h-span-2>
                    <h3>General</h3>
                </modal-data-item-h-span-2>

                <modal-data-item v-if="rowData.vacancy_found_by">
                    <form-field
                        label="¿Cómo te enteraste de la vacante?"
                        :value="rowData.vacancy_found_by + (rowData.referenced_by ? ` - ${rowData.referenced_by}` : '')"
                        readonly
                    ></form-field>
                </modal-data-item>

                <modal-data-item v-if="rowData.ex_worker">
                    <form-field
                        label="¿Has trabajado en Intuitive?"
                        :value="rowData.ex_worker"
                        readonly
                    ></form-field>
                </modal-data-item>

            </modal-data>

                

            <modal-comments>
                <form-field-textarea v-model="newComment.comment" label="Agregar comentario"></form-field-textarea>
                <div style="text-align: right">
                    <button-primary
                        @on-click="onClickAddComment(rowData.id)"
                        :disabled="!newComment.comment"
                    >Agregar</button-primary>
                </div>
                <div>
                    <comments-container>
                        <comment v-for="(comment, key) in rowData.comments" :key="key" :comment="comment"></comment>
                    </comments-container>
                </div>
            </modal-comments>
        </modal-body>
    </modal-window>
</template>

<script>
import styled, { css } from "vue-emotion";
import colors from "@/config/admin/AdminColors.js";
import vars from "@/config/admin/AdminVariables.js";
import AppointmentConfig from '@/config/admin/Appointment.json'
import ModalWindow from "@/components/admin/ModalWindow.vue";
import ButtonLink from "@/components/admin/ButtonLink.vue";
import ButtonPrimary from "@/components/admin/ButtonPrimary.vue";
import ColorTag from "@/components/admin/ColorTag.vue";
import ColorTagRadio from "@/components/admin/ColorTagRadio.vue";
import FormField from "@/components/admin/FormField.vue";
import FormFieldTextarea from "@/components/admin/FormFieldTextarea.vue";
import Comment from "@/components/admin/Comment.vue";
import EventService from "@/services/AdminEventService.js";
import { EventBus } from "@/event-bus.js";
import SelectInput from '@/components/admin/SelectInput.vue'

const appointmentsBag = 'appointments';

const ModalHead = styled("div")`
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${vars.border.color};
    font-size: ${vars.text.h1.fontSize};
    font-weight: ${vars.text.h1.fontWeight};
    height: 120px;
    display: flex;
    align-items: center;
    padding: 0 1.25rem 1rem;
`;
const ModalTitle = styled("span")`
    padding-left: 0.5rem;
    position: relative;
`;
const ModalSubtitle = styled(ModalTitle)`
    font-size: 1rem;
    bottom: -1rem;
    position: absolute;
    left: 0;
`;
const ModalBody = styled("div")`
    display: grid;
    grid-template-columns: 70% 30%;
`;
const ModalOptions = styled("div")`
    grid-column: 1/3;
    background-color: #fafafa;
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${vars.border.color};
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1.25rem;
`;
const ModalOptionsItem = styled("div")`
    display: flex;
    > :not(last-child) {
        margin-right: 1.5rem;
    }
`;
const ColorTagRadios = styled("div")`
    display: flex;
`;
const ModalData = styled("div")`
    grid-column: 1/2;
    display: grid;
    grid-template-columns: 1fr 1fr;
`;
const ModalDataItem = styled("div")`
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${vars.border.color};
    padding: 1rem 1.25rem;
`;
const ModalDataItemHSpan2 = styled(ModalDataItem)`
    grid-column: 1/3;

    border-top: ${vars.border.width} ${vars.border.style} ${vars.border.color};
    margin-top: -${vars.border.width};

    > * {
        margin: 0;
    }
`;
const ModalDataItemSep = styled(ModalDataItemHSpan2)`
    padding: 0.063rem 0;
`;
const ModalComments = styled("div")`
    grid-column: 2/3;
    border-left: ${vars.border.width} ${vars.border.style} ${vars.border.color};
    padding: 1rem 1.25rem;
`;
const CommentsContainer = styled("ul")`
    list-style: none;
    margin: 0;
    padding: 0;
`;

const ModalAppointmentRow = styled('div')`

    .top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 1rem;
    }

   
    .data {
        flex-grow: 1;
        margin-right: 1rem;
    }
`

const ModalAppointmentsSectionTitle = styled(ModalDataItemHSpan2)`
    display: flex;
    align-items: center;
    justify-content: space-between;
`

export default {
    components: {
        ModalWindow,
        ModalHead,
        ModalTitle,
        ModalSubtitle,
        ModalBody,
        ModalOptions,
        ModalOptionsItem,
        ColorTagRadios,
        ModalData,
        ModalDataItem,
        ModalDataItemHSpan2,
        ModalDataItemSep,
        ModalComments,
        ModalAppointmentRow,
        ButtonLink,
        ButtonPrimary,
        ColorTag,
        ColorTagRadio,
        FormField,
        FormFieldTextarea,
        SelectInput,
        Comment,
        CommentsContainer,
        ModalAppointmentsSectionTitle
    },
    props: ["row-data", "show-modal", "all-labels"],
    provide() {
        return { parentValidator: this.$validator };
    },
    data() {
        return {
            appointmentsBag,
            subscriber: {},
            colorTags: colors.tags,
            newComments: [],
            newComment: {
                comment: "",
                subscriber_id: null
            },
            appointmentStatusesOptions: AppointmentConfig.statuses,
        };
    },
    methods: {
        onClickColorTag(value) {
            EventBus.$emit('subscriber:update-color-tag', {
                subscriber: this.rowData,
                value
            });
        },
        onClickAceptar(value, id) {
            EventBus.$emit('subscriber:accept', {
                subscriber: this.rowData,
                value
            });
        },
        onClickRejected(value, id) {
            EventBus.$emit('subscriber:reject', {
                subscriber: this.rowData,
                value
            });
        },
        onClickMoveToCandidatos(candidateValue, rejectedValue, id) {
            EventBus.$emit('subscriber:candidate', {
                id,
                candidateValue,
                rejectedValue,
            });
        },
        onClickDelete(subscriber) {
            EventBus.$emit('subscriber:delete', subscriber);
        },
        formatDate(date, fmt = 'ddd DD MMM YYYY') {
            let fdate = this.moment(date).format(fmt);
            return fdate.charAt(0).toUpperCase() + fdate.slice(1)
        },
        formatBoolean(value) {
            return value ? "Si" : "No";
        },
        onClickAddComment(id) {
            this.newComment.subscriber_id = id;
            
            const comment = {
                comment: this.newComment.comment,
                subscriber_id: this.newComment.subscriber_id,
                user_id: authUserId,
                created_at: new Date()
            };

            EventService.postComment(comment)
                .then(response => {
                    this.newComment.comment = "";
                    this.rowData.comments.push(response.data.comment);
                })
                .catch(this.$parent.errorHandler);
        },
        onClickClose() {
            this.$events.fire("close-modal");
        },
        parseJob(job) {
            return {
                "Empresa": job.company,
                "Puesto": job.position,
                "Duración": job.duration,
                "Motivo de separación": job.breakup_reason
            };
        },
        onSubmitUpdateAppointment(appointmentData) {
            let payload = {
                subscriber_id: appointmentData.pivot.subscriber_id,
                comment: appointmentData.pivot.comment,
                status: appointmentData.pivot.status,
            };
            
            EventService.putAppointment(appointmentData.id, payload)
                .then(r => {})
                .catch(this.$parent.errorHandler);
        },
        onClickCreateAppointment() {
            EventBus.$emit("on-create-appointment", this.rowData);
        }
    }
};
</script>
