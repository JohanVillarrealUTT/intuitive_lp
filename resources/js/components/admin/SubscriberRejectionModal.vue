<template>
    <modal-window :show-modal="showModal" max-width="600px">
        <modal-head>
            <modal-title>
                Rechazar candidato
            </modal-title>
        </modal-head>
        <modal-body>
            <modal-data>
                <form @submit.prevent.default>
                    <modal-data-item>
                        <select-input
                            label="Relecciona el motivo de rechazo"
                            v-model="form.rejection_reason"
                            name="rejectionReason"
                            v-validate="'required'"
                            :options="rejectionReasons"
                            :error="errors.first('rejectionReason')">
                        </select-input>
                    </modal-data-item>

                    <modal-buttons>
                        <button-link @on-click="onClickCancel" type="button">Cancelar</button-link>
                        <button-primary
                            :disabled="errors.any()"
                            @on-click="onClickSave"
                            type="submit"
                        >Rechazar candidato</button-primary>
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
import EventService from '@/services/AdminEventService'
import AppointmentSetupMixin from '@/mixins/appointmentSetupMixin.js'
import AppointmentConfig from '@/config/admin/Appointment.json'


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
            rejectionReasons: AppointmentConfig.rejectionReasons,
            form: {
                id: this.subscriber.id,
                rejection_reason: null
            }
        }
    },
    methods: {
        onClickCancel() {
            this.$parent.$data.subscriberRejection.subscriber = null
        },
        onClickSave() {
            this.$validator.validate().then(valid => {
                if (!valid) return
            

                EventService.rejectSubscriber({...this.form})
                    .then(r => {
                        this.$events.fire('close-modal');
                        this.$parent.$data.subscriberRejection.subscriber = null
                        this.$parent.$refs.table.refresh();
                    })
                    .catch(this.$parent.errorHandler)
            });
        }
    }
}
</script>