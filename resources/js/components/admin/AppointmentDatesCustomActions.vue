<template>
    <custom-popover>
        <ul>
            <li>
                <a
                    href="#"
                    v-on:click.prevent="onClickDownloadDocument(rowData)"
                >Descargar aspirantes</a>
            </li>
            <li>
                <a
                    v-if="rowData.status != 'closed'"
                    href="#"
                    v-on:click.prevent="onClickEdit(rowData)"
                >Editar</a>
            </li>
            <li>
                <a
                    href="#"
                    v-on:click.prevent="onClickDelete(rowData)"
                >Eliminar</a>
            </li>
        </ul>
    </custom-popover>
</template>

<script>
import colors from '@/config/admin/AdminColors.js'
import { EventBus } from '@/event-bus.js'
import CustomPopover from '@/components/admin/CustomPopover.vue'
import EventService from '@/services/AdminEventService.js'

export default {
    name: 'AppointmentDatesCustomActions',
    components: {
        CustomPopover
    },
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        }
    },
    data() {
        return {
            colorTags: colors.tags
        }
    },
    methods: {
        onClickEdit(rowData) {
            EventBus.$emit('on-edit-appointment-date', rowData)
        },
        onClickDownloadDocument(rowData) {
            console.log(rowData)
            window.location = `/citas/${rowData.id}/descargar-excell`
        },
        onClickDelete(rowData) {
            let c = confirm('Se eliminará esta fecha y los aspirantes que la seleccionaron recibirán una notificación para que regresen al portal a seleccionar otra fecha. \n ¿Eliminar?');
            
            if (c) {
                EventService.deleteAppointment(rowData.id)
                    .then(function() {
                        window.location.reload()
                    })
                    .catch(e => {
                        alert(e.message)
                    })
            }
        }
    }
}
</script>
