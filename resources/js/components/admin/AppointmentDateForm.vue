<template>
    <modal-window :show-modal="showModal" max-width="600px">
        <modal-head>
            <modal-title>
                {{ isEditing ? 'Editar' : 'Agregar' }} fecha
            </modal-title>
        </modal-head>
        <modal-body>
            <modal-data>
                <form @submit.prevent.default>
                    <modal-data-item v-if="isEditing">
                        <select-input
                            v-model="status"
                            :label="'Estatus'"
                            :name="'status'"
                            :options="statusOptions"
                            :v_validate_rules="'required'"
                            :error="errors.first('status')"
                        ></select-input>
                    </modal-data-item>
                    <modal-data-item>
                        <form-field
                            label="Fecha"
                            small="(mm/dd/aaaa)"
                            v-model="date"
                            type="date"
                            name="date"
                            v-validate="'required'"
                            :error="errors.first('date')"
                        ></form-field>
                    </modal-data-item>
                    
                    <modal-data-item class="px-0">
                        <h3>Horarios</h3>
                        <p v-if="!hours.length">
                            Sin horarios
                        </p>
                        <modal-data-item v-for="(h, i) in hours" :key="h.id" class="px-0">
                            <modal-data-item class="px-0">
                                <select-input
                                    v-model="h.type"
                                    :label="'Visibilidad'"
                                    :name="'type'"
                                    :options="typeOptions"
                                    :v_validate_rules="'required'"
                                    :error="errors.first('type')"
                                ></select-input>
                            </modal-data-item>
                            <modal-between-data-item class="p0">
                                <form-field
                                    label="Hora"
                                    small="(Ejemplos: 09:30 AM, 03:00 PM)"
                                    v-model="h.hour"
                                    type="text"
                                    :name="`hour_[${i}]_hour`"
                                    :data-vv-as="`Hora`"
                                    v-validate="{
                                        required: true,
                                        regex: /^[0-9]{2}:[0-9]{2} (AM|PM)/
                                    }"
                                    :error="errors.first(`hour_[${i}]_hour`)"
                                ></form-field>
                                <form-field
                                    label="Espacios en este horario"
                                    v-model="h.max_capacity"
                                    type="number"
                                    :name="`hour_[${i}]_max_capacity`"
                                    :data-vv-as="`Espacios disponibles`"
                                    v-validate="'required|max:35|integer'"
                                    :error="errors.first(`hour_[${i}]_max_capacity`)"
                                ></form-field>
                            </modal-between-data-item>
                            <small v-if="h.subcribers_count">
                                {{ h.subcribers_count }} aspirantes en este horario.
                            </small>
                            <modal-buttons class="p0">
                                <button-link @on-click="onDeleteSchedule(i)">Eliminar</button-link>
                            </modal-buttons>
                        </modal-data-item>

                        <modal-buttons class="p0">
                            <button-primary @on-click="onAddSchedule()">Agregar Horario</button-primary>
                        </modal-buttons>
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
import FormField from '@/components/admin/FormField.vue'
import SelectInput from '@/components/admin/SelectInput.vue'
import ButtonLink from '@/components/admin/ButtonLink.vue'
import ButtonPrimary from '@/components/admin/ButtonPrimary.vue'
import EventService from '@/services/AdminEventService'

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


const ModalBetweenDataItem = styled(ModalDataItem)`
    display: flex;
    justify-content: space-between;
`

export default {
    components: {
        ButtonLink,
        ButtonPrimary,
        FormField,
        SelectInput,
        ModalBody,
        ModalButtons,
        ModalData,
        ModalDataItem,
        ModalBetweenDataItem,
        ModalHead,
        ModalTitle,
        ModalWindow,
    },
    props: ['show-modal', 'isEditing'],
    provide() {
        return { parentValidator: this.$validator };
    },
    data() {
        return {
            id: '',
            date: '',
            hours: [],
            status: '',
            statusOptions: [
                { value: 'available', label: "Disponible" },
                { value: 'full', label: "No disponible" }
            ],
            typeOptions: [
                { value: 'admin', label: "Solo para administrador" },
                { value: 'public', label: "Pública" }
            ],
        }
    },
    created() {
        if (this.isEditing) {
            this.id = this.isEditing.id;
            this.date = this.moment(this.isEditing.date).format('YYYY-MM-DD');
            this.hours = this.isEditing.hours.map(h => ({
                id: h.id,
                hour: h.hour,
                max_capacity: h.max_capacity,
                type: h.type,
                subcribers_count: h.subcribers_count
            }));
            this.status = this.isEditing.status;
        }
    },
    methods: {
        onClickCancel() {
            this.$parent.$data.showAppointmentDateForm = false
            this.$parent.$data.formIsEditing = null
        },
        onClickSave() {
            this.$validator.validate().then(valid => {
                if (valid) {
                    if (!valid) return
                
                    const AppointmentDate = {
                        date: this.moment(this.date).format('YYYY-MM-DD'),
                        hours: this.hours,
                        user_id: authUserId,
                        status: this.status,
                    }

                    let p = this.isEditing
                        ? EventService.updateAppointmentDate(this.id, AppointmentDate)
                        : EventService.postAppointmentDate(AppointmentDate)
                        
                        p
                            .then(response => {
                                this.$parent.$refs.vuetableAppointmentDate.refresh();
                                this.$parent.$data.showAppointmentDateForm = false;
                            })
                            .catch(error => {
                                alert('Ocurrió un error:', error.response)
                                console.log('Ocurrió un error:', error.response)
                            })
                }
            });
        },
        onAddSchedule() {
            this.hours.push({
                hour: '',
                max_capacity: 35,
                type: 'public'
            })
        },
        onDeleteSchedule(i) {
            let h = this.hours[i];
            if (h.subcribers_count && !confirm(`Hay ${ h.subcribers_count } aspirantes en este horario. \nAl eliminarlo, los aspirantes recibiran una notificación en su correo`)) return false;
            this.hours.splice(i, 1)
        }
    }
}
</script>