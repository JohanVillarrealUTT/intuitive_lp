<template>
    <custom-popover>
        <ul>
            <li>
                <a
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
    name: 'LabelsCustomActions',
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
    methods: {
        onClickEdit(rowData) {
            EventBus.$emit('edit-label', rowData)
        },
        // onClickDownloadDocument(rowData) {
        //     console.log(rowData)
        //     window.location = `/citas/${rowData.id}/descargar-excell`
        // },
        onClickDelete(rowData) {
            let c = confirm('Se eliminará esta eliqueta y los aspirantes asignados a esta quedarán sin una etiqueta asignada. \n ¿Eliminar?');
            
            if (c) {
                EventService.deleteLabel(rowData.id)
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
