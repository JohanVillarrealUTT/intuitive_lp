<template>
    <custom-switch
        type="checkbox"
        @toggle-switch="onClickCandidate"
        :data-id="rowData.id"
        :disabled="rowData.rejected == true"
        :id="`candidate-${rowData.id}`"
        :name="`candidate-${rowData.id}`"
        v-model="modCandidate"
    ></custom-switch>
</template>

<script>
import CustomSwitch from '@/components/admin/CustomSwitch.vue'
import { EventBus } from '@/event-bus.js'
import EventService from '@/services/AdminEventService.js'

export default {
    name: 'CandidateAction',
    components: { CustomSwitch },
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        }
    },
    computed: {
        modCandidate: {
            get() {
                return !!this.rowData.candidate
            },
            set(candidate) {
                this.rowData.candidate = candidate
            }
        }
    },
    methods: {
        onClickCandidate(value, id) {
            EventService.putSubscriberCandidate(id, value)
                .then(response => {
                    this.$parent.$parent.$refs.table.reload()
                    EventBus.$emit('update-color-tags-totals')
                })
                .catch(error => {
                    alert('Ocurrió un error:', error.response)
                    console.log('Ocurrió un error:', error.response)
                })
        }
    }
}
</script>