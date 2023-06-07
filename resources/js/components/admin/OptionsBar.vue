<template>
    <options-bar>
        <options-bar-item>
            
            <options-bar-filter v-show="showAppointmentDateFilter">
                <filter-select
                    @change="emitFilterByAppointmentDateId"
                    ref="filterSelect">
                    <option :value="null"> Todas las fechas </option>
                    <option v-for="a_date in loadedAppointmentDates" :value="a_date.id">
                        {{ moment(a_date.date).format('dddd DD MMM YY') }}
                    </option>
                </filter-select>
            </options-bar-filter>
            
            <options-bar-filter v-show="showRejectionReasonFilter">
                <filter-select
                    @change="emitFilterByRejectionReason"
                    ref="rejectionReasonSelect">
                    <option :value="null"> Todo </option>
                    <option v-for="r in rejectedReasonOptions" :value="r.value">
                        {{ r.label }}
                    </option>
                </filter-select>
            </options-bar-filter>
            
            <options-bar-filter>
                <filter-select
                    @change="emitFilterByWorkedBefore"
                    ref="workedBeforefilterSelect">
                    <option :value="null"> Todo </option>
                    <option :value="1"> Trabajó en intuitive </option>
                    <option :value="0"> No trabajó en intuitive </option>
                </filter-select>
            </options-bar-filter>
            
            <options-bar-filter>
                <filter-text-field
                    @change="emitFilterByKeyword"
                    type="text"
                    ref="keywordFilter"
                    placeholder="Palabra clave">
                </filter-text-field>
            </options-bar-filter>
            
            <color-tag-radio
                v-for="(value, key) in colorTagsTotals"
                @selected-color-tag="doFilterColorTag"
                :checked="value.color_tag === selected"
                :id="`nav-color-tag-${value.color}`"
                :key="value.label_id"
                :color="value.color"
                :name="'nav-color-tags'"
                :value="value.label_id"
                v-tooltip="value.color_tag"
            >
                <color-tag-total>{{ value.color_tag_total }}</color-tag-total>
            </color-tag-radio>
            
            <a href="#" v-if="colorTagReset" @click.prevent="resetColorTag">Todos</a>
        </options-bar-item>
        <options-bar-item>
            <a @click.prevent="downloadExcell" href="#">Descargar base de datos</a>
        </options-bar-item>
    </options-bar>
</template>

<script>
import styled from 'vue-emotion'
import colors from '@/config/admin/AdminColors'
import vars from '@/config/admin/AdminVariables'
import ColorTagRadio from '@/components/admin/ColorTagRadio.vue'
import ButtonLink from '@/components/admin/ButtonLink.vue'
import NProgress from 'nprogress'
import axios from 'axios'
import EventService from '@/services/AdminEventService.js'
import services from '@/services/AdminEventService.js'
import { EventBus } from '@/event-bus'
import websiteServices from '@/services/WebsiteServices.js'
import AppointmentConfig from '@/config/admin/Appointment.json'

export const OptionsBar = styled('div')`
    border-top: ${vars.border.width} ${vars.border.style}
        ${colors.neutral.Isabelline};
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${colors.neutral.Isabelline};
    display: flex;
    align-items: center;
    justify-content: space-between;
`
export const OptionsBarItem = styled('div')`
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
`
export const ColorTagTotal = styled('span')`
    color: ${colors.neutral.SpanishGray};
`

export const OptionsBarFilter = styled('div')`
    margin-right: 1rem;
`

export const FilterSelect = styled('select')`
    padding: .5rem;
    border: ${colors.neutral.Isabelline} 1px solid;
    background-color: transparent;
`

export const FilterTextField = styled('input')`
    padding: .5rem;
    border: ${colors.neutral.Isabelline} 1px solid;
    background-color: transparent;
`

export default {
    components: {
        OptionsBar,
        OptionsBarItem,
        ColorTagRadio,
        ColorTagTotal,
        OptionsBarFilter,
        ButtonLink,
        FilterSelect,
        FilterTextField
    },
    props: ['color-tags-totals', 'allLabels'],
    data() {
        return {
            colorTags: colors.tags,
            colorTagReset: false,
            selected: false,
            loadedAppointmentDates: [],
            rejectedReasonOptions: AppointmentConfig.rejectionReasons,
            showAppointmentDateFilter: true,
            showRejectionReasonFilter: false,
        }
    },
    mounted() {
        EventBus.$on(
            'hide-color-tags-show-all',
            e => (this.colorTagReset = false)
        )

        EventBus.$on('reset-appointment-date-filter', () => {
            this.$refs.filterSelect.value = ''
        })

        EventBus.$on('reset-worked-in-intuitive-filter', () => {
            this.$refs.workedBeforefilterSelect.value = ''
        })

        EventBus.$on('reset-keyword-filter', () => {
            this.$refs.keywordFilter.value = ''
        })

        EventBus.$on('show-appointment-date-filter', () => {
            this.showAppointmentDateFilter = true
        })
        EventBus.$on('hide-appointment-date-filter', () => {
            this.showAppointmentDateFilter = false
        })

        EventBus.$on('show-rejected-reason-filter', () => {
            this.showRejectionReasonFilter = true
        })
        EventBus.$on('hide-rejected-reason-filter', () => {
            this.showRejectionReasonFilter = false
        })


        this.loadAppointmentDates();
    },
    methods: {
        resetColorTag() {
            this.$events.fire('color_tag-reset')
            this.colorTagReset = false
            this.selected = false
        },
        doFilterColorTag(value) {
            this.$events.fire('color_tag-set', value.color_tag)
            this.colorTagReset = true
            this.selected = value.color_tag
        },
        downloadExcell() {
            window.location.href = 'descargar-excell'
        },
        loadAppointmentDates() {
            websiteServices.loadSelectAppointments()
                .then(r => {
                    console.log(r.data.data);
                    this.loadedAppointmentDates = r.data.data
                })
                .catch(e => {
                    alert('Ocurrió un error: ' + e.message)
                })
        },
        emitFilterByAppointmentDateId($event) {
            EventBus.$emit('filter-by-appointment-date', $event.target.value)
        },
        emitFilterByRejectionReason($event) {
            EventBus.$emit('filter-by-rejection-reason', $event.target.value)
        },
        emitFilterByWorkedBefore($event) {
            EventBus.$emit('filter-by-worked-in-intuitive', $event.target.value)
        },
        emitFilterByKeyword($event) {
            EventBus.$emit('filter-by-keyword', $event.target.value)
        },
        onResetFilters() {
            this.$refs.filterSelect.attrs.value = ''
            this.$refs.workedBeforefilterSelect.attrs.value = ''
        }
    }
}
</script>