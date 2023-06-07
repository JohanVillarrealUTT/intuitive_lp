<template>
    <custom-popover>
        <ul>
            <li class="color-tag-radios">
                <color-tag-radio
                    v-for="(label, key) in allLabels"
                    @selected-color-tag="onClickColorTag"
                    :checked="rowData.label && rowData.label.color === label.color"
                    :data-id="rowData.id"
                    :color="label.color"
                    :id="`row-color-tag-${label.color}-${rowData.id}`"
                    :key="label.id"
                    :name="`row-color-tag-${rowData.id}`"
                    :value="label.id"
                ></color-tag-radio>
            </li>
            <li>
                <hr>
            </li>
            <li>
                <a href="#" v-on:click.prevent="onClickShow(rowData)">Ver</a>
            </li>
            <li v-if="!rowData.rejected">
                <a href="#" v-on:click.prevent="onClickCreateAppointment(rowData)">Crear cita</a>
            </li>
            <li v-if="rowData.rejected">
                <a
                    href="#"
                    v-on:click.prevent="onClickMoveToCandidatos(false, false, rowData.id)"
                >Mover a Candidatos</a>
            </li>
            <li>
                <a
                    href="#"
                    v-if="!rowData.rejected"
                    v-on:click.prevent="onClickRejected(1, rowData.id)"
                >Rechazar</a>
            </li>
            <li>
                <hr>
            </li>
            <li>
                <a
                    class="color-danger"
                    href="#"
                    v-on:click.prevent="onClickDelete(rowData)"
                >Eliminar</a>
            </li>
        </ul>
    </custom-popover>
</template>

<script>
import ColorTagRadio from '@/components/admin/ColorTagRadio.vue'
import colors from '@/config/admin/AdminColors.js'
import { EventBus } from '@/event-bus.js'
import CustomPopover from '@/components/admin/CustomPopover.vue'
import EventService from '@/services/AdminEventService.js'
import AppointmentConfig from '@/config/admin/Appointment.json'

export default {
    name: 'CustomActions',
    components: {
        ColorTagRadio,
        CustomPopover
    },
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        },
        allLabels: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            colorTags: colors.tags,
        }
    },
    methods: {
        onClickColorTag(value) {
            EventBus.$emit('subscriber:update-color-tag', {
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
        onClickShow(data) {
            EventService.getSubscriber(data.id)
                .then(response => {
                    this.$events.fire('show-subscriber', data)
                })
                .catch(error => {
                    alert('Ocurrió un error:', error.response)
                    console.log('Ocurrió un error:', error.response)
                })
        },
        onClickCreateAppointment(subscriber) {
            EventBus.$emit("on-create-appointment", subscriber);
        }
    }
}
</script>
