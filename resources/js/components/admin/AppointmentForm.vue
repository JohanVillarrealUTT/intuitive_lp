<template>
    <modal-window :show-modal="showModal" max-width="600px">
        <modal-head>
            <modal-title>
                {{ isEditing ? 'Editar' : 'Crear' }} cita
            </modal-title>
        </modal-head>
        <modal-body>
            <modal-data>
                <form @submit.prevent.default>
                    <modal-data-item>
                        <select-input
                            label="Fecha de la cita"
                            v-model="form.appointment_date_id"
                            @change="onChangeDate"
                            name="appointment_date_id"
                            v-validate="'required'"
                            :options="computedDates"
                            :error="errors.first('appointment_date_id')">
                        </select-input>
                    </modal-data-item>

                    <modal-data-item v-if="form.appointment_date_id">
                        <select-input
                            label="Hora de la cita"
                            v-model="form.appointment_hour_id"
                            name="appointment_hour_id"
                            v-validate="'required'"
                            :options="computedHours"
                            :error="errors.first('appointment_hour_id')">
                        </select-input>
                    </modal-data-item>

                    <modal-data-item>
                        <select-input
                            label="Enviar correo electrónico al aspirante"
                            v-model="form.send_mail"
                            name="send_mail"
                            v-validate="'required'"
                            :options="[{label: 'Si', value: 1}, {label: 'No', value: 0}]"
                            :error="errors.first('send_mail')">
                        </select-input>
                    </modal-data-item>

                    <modal-buttons>
                        <button-link @on-click="onClickCancel" type="button">Cancelar</button-link>
                        <button-primary
                            :disabled="errors.any()"
                            @on-click="onClickSave"
                            type="submit"
                        >Guardar</button-primary>
                    </modal-buttons>
                </form>
            </modal-data>
        </modal-body>
    </modal-window>
</template>

<script>
import ModalWindow from '@/components/admin/ModalWindow.vue'
import styled, { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables'
// import FormField from '@/components/admin/FormField.vue'
import SelectInput from '@/components/admin/SelectInput.vue'
import ButtonLink from '@/components/admin/ButtonLink.vue'
import ButtonPrimary from '@/components/admin/ButtonPrimary.vue'
import EventService from '@/services/WebsiteServices'
import AppointmentSetupMixin from '@/mixins/appointmentSetupMixin.js'

const ModalHead = styled('div')`
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${vars.border.color};
    font-size: ${vars.text.h1.fontSize};
    font-weight: ${vars.text.h1.fontWeight};
    height: 120px;
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
`
const ModalTitle = styled('span')`
    padding-left: 0.5rem;
`
const ModalBody = styled('div')`
    display: grid;
    grid-template-columns: 1fr;
    padding: 1.5rem 0 2rem;
`
const ModalData = styled('div')`
    grid-column: 1/2;
    display: grid;
    grid-template-columns: 1fr;
`
const ModalDataItem = styled('div')`
    padding: 1rem 1.25rem;
    .px-0 {
        padding-left: 0;
        padding-right: 0;
    }

    .p0 {
        padding: 0;
    }
`
const ModalButtons = styled(ModalDataItem)`
    text-align: right;

    &.p0 {
        padding: 0;
    }
`


const ModalDobleDataItem = styled(ModalDataItem)`
    display: flex;
    justify-content: space-between;
`

export default {
    components: {
        ButtonLink,
        ButtonPrimary,
        // FormField,
        SelectInput,
        ModalBody,
        ModalButtons,
        ModalData,
        ModalDataItem,
        ModalDobleDataItem,
        ModalHead,
        ModalTitle,
        ModalWindow,
    },
    mixins: [
        AppointmentSetupMixin
    ],
    props: ['show-modal', 'isEditing', 'subscriber'],
    provide() {
        return { parentValidator: this.$validator };
    },
    data() {
        return {
            datesOptions: [],
            hoursOptions: [],
            form: {
                from_admin: true,
                subscriber_id: this.subscriber.id,
                appointment_date_id: null,
                appointment_hour_id: null,
                send_mail: 1
            }
        }
    },
    mounted() {
        this.loadAdminDates();
        if (this.isEditing) {}
    },
    computed: {
        computedDates() {
            return this.availableDates.map(d => ({
                value: d.id,
                label: this.moment(d.date).format('ddd DD MMM YYYY')
            }))
        },
        computedHours() {
            let a = [];
            if (this.form.appointment_date_id) {
                a = this.availableDates
                    .find(ad => ad.id == this.form.appointment_date_id).hours
                    .map(h => ({
                        label: h.hour,
                        value: h.id,
                    }));
            }
            return a;
        },
    },
    methods: {
        onClickCancel() {
            this.$parent.$data.subscriberAppointment.showModal = false
            this.$parent.$data.subscriberAppointment.appointment = null
        },
        onClickSave() {
            this.$validator.validate().then(valid => {
                if (!valid) return
            
                const payload = {...this.form};

                let p = this.isEditing
                    ? EventService.updateAppointment(payload.subscriber_id, payload.appointment_hour_id)
                    : EventService.postAppointment(payload)
                    
                    p.then(r => {
                        console.log(r)
                        this.$parent.$data.subscriberAppointment.showModal = false
                        this.$parent.$data.subscriberAppointment.appointment = null
                        this.$parent.$data.rowData.appointments.push(r.data.appointment)
                    })
                    .catch(error => {
                        alert('Ocurrió un error:' + ' ' + error.response.data.message)
                    })
            });
        },
        onChangeDate() {
            this.form.appointment_hour_id = null;
        }
    }
}
</script>