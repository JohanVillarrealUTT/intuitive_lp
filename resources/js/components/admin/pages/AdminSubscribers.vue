<template>
    <div class="container">
        <h2>Registros</h2>
        
        <table-container>
            
            <vuetable-nav-bar>
                <filter-tabs></filter-tabs>
                <div class="vuetable-pagination">
                    <vuetable-pagination-info
                        ref="paginationInfoTop"
                        :css="css.paginationInfo"
                        info-class="pagination-info"
                        info-template="{from} – {to} de {total}"
                    ></vuetable-pagination-info>
                    <vuetable-pagination
                        ref="paginationTop"
                        @vuetable-pagination:change-page="onChangePage"
                    ></vuetable-pagination>
                </div>
            </vuetable-nav-bar>
            
            <options-bar :color-tags-totals="colorTagsTotals" :all-labels="allLabels"></options-bar>
            
            <div class="table-responsive">
                <vuetable
                    ref="table"
                    api-url="/api/v1/subscriber"
                    :fields="subscriberFields"
                    pagination-path
                    @vuetable:pagination-data="onPaginationData"
                    @vuetable:row-dblclicked="onShowModal"
                    :sort-order="sortOrder"
                    :multi-sort="true"
                    :css="css.table"
                    :append-params="moreParams"
                    :http-options="customHeaders()"
                >
                    
                    <template slot="color-tag-cell" slot-scope="props">
                        <color-tag-cell
                            v-if="props.rowData.label"
                            v-tooltip="props.rowData.label.name"
                            v-bind="props"
                        ></color-tag-cell>
                    </template>
                    <template slot="subscribers-appointment-field" slot-scope="{ rowData }">
                        
                        <div v-if="rowData.appointments && rowData.appointments.length">
                            <small> {{ formatDate(rowData.appointments[0].date.date) + ' ' + rowData.appointments[0].hour}} </small>
                            <br>
                            <small> {{ rowData.appointments[0].pivot.status }} </small>
                        </div>
                        
                        <div v-else> -- </div>
                    </template>

                    <template slot="custom-actions" slot-scope="props">
                        <custom-actions v-bind="props" :all-labels="allLabels"></custom-actions>
                    </template>
            
                </vuetable>
            </div>

            <vuetable-nav-bar>
                <div class="vuetable-pagination">
                    <vuetable-pagination-info
                        ref="paginationInfoBottom"
                        :css="css.paginationInfo"
                        info-class="pagination-info"
                        info-template="{from} – {to} de {total}"
                    ></vuetable-pagination-info>
                    <vuetable-pagination
                        ref="paginationBottom"
                        @vuetable-pagination:change-page="onChangePage"
                    ></vuetable-pagination>
                </div>
            </vuetable-nav-bar>

        </table-container>
        
        <subscriber-show v-if="showModal" :row-data="rowData" :show-modal="showModal" :all-labels="allLabels"></subscriber-show>
        
        <zoom-center-transition>
            <admin-tutorial v-if="willShowTutorial" :show-modal="willShowTutorial"></admin-tutorial>
        </zoom-center-transition>

        <appointment-form
            v-if="subscriberAppointment.showModal"
            :show-modal="subscriberAppointment.showModal"
            :is-editing="subscriberAppointment.appointment"
            :subscriber="subscriberAppointment.subscriber">
        </appointment-form>

        <subscriber-rejection-modal
            v-if="subscriberRejection.subscriber"
            :showModal="subscriberRejection.subscriber"
            :subscriber="subscriberRejection.subscriber"
        >
        </subscriber-rejection-modal>
    </div>
</template>

<script>
import Vue from "vue";
import Vuetable from "vuetable-2/src/components/Vuetable.vue";
import VuetablePagination from "@/components/admin/VuetablePaginationCustom.vue";
import VuetablePaginationInfo from "@/components/admin/VuetablePaginationInfoCustom.vue";
import moment from "moment";
import "moment/locale/es";
import styled, { css } from "vue-emotion";
import colors from "@/config/admin/AdminColors.js";
import vars from "@/config/admin/AdminVariables.js";
import FilterTabs from "@/components/admin/FilterTabs.vue";
import VueEvents from "vue-events";
import OptionsBar from "@/components/admin/OptionsBar.vue";
import CandidateAction from "@/components/admin/CandidateAction.vue";
import CustomActions from "@/components/admin/CustomActions.vue";
import SubscriberShow from "@/components/admin/SubscriberShow.vue";
import ColorTagCell from "@/components/admin/ColorTagCell.vue";
import { EventBus } from "@/event-bus.js";
import EventService from "@/services/AdminEventService.js";
import NProgress from "nprogress";
import Cookies from "js-cookie";
import AppointmentForm from "@/components/admin/AppointmentForm.vue";
import SubscriberRejectionModal from '@/components/admin/SubscriberRejectionModal.vue'

import AdminTutorial from "@/components/admin/AdminTutorial.vue";

Vue.use(Vuetable);
Vue.use(VueEvents);

Vue.component("candidate-action", CandidateAction);
// Vue.component("custom-actions", CustomActions);
// Vue.component("color-tag-cell", ColorTagCell);

moment.locale("es");

const TableContainer = styled("div")``;
const CustomVuetable = styled(Vuetable)``;
const VuetableNavBar = styled("div")`
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;

    .vuetable-tabs {
        grid-column: 1 / 2;
    }

    .vuetable-pagination {
        grid-column: 2 / -1;
        display: flex;
    }
`;

export default {
    name: "AdminSubscribers",
    components: {
        Vuetable: CustomVuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        TableContainer,
        VuetableNavBar,
        FilterTabs,
        OptionsBar,
        SubscriberShow,
        AdminTutorial,
        AppointmentForm,
        SubscriberRejectionModal,
        CustomActions,
        ColorTagCell
    },
    data() {
        return {
            subscriberFields: [
                {
                    name: "created_at",
                    sortField: "created_at",
                    title: "Fecha",
                    callback: "formatDate|MMM D"
                },
                {
                    name: "__slot:color-tag-cell",
                    title: '<span class="th-color-tag"></span>'
                },
                {
                    name: "folio_number",
                    title: "Folio",
                    callback: val => val || '--'
                },
                {
                    name: "full_name",
                    sortField: "first_name",
                    title: "Nombre"
                },
                {
                    name: "school_degree",
                    sortField: "school_degree",
                    title: "Estudios"
                },
                {
                    name: "__slot:subscribers-appointment-field",
                    title: "Cita",

                },
                {
                    name: "__component:candidate-action",
                    title: "Aceptado"
                },
                {
                    name: "__slot:custom-actions",
                    title: "",
                    dataClass: "custom-actions"
                }
            ],
            sortOrder: [
                {
                    field: "created_at",
                    sortField: "created_at",
                    direction: "desc"
                }
            ],
            css: {
                table: {
                    tableClass: "table"
                },
                paginationInfo: {
                    wrapperClass: "vuetable-pagination-info"
                }
            },
            moreParams: {
                candidate: 0,
                rejected: 0,
                appointment_date: null,
                worked_in_intuitive: null,
                keyword: null,
                rejection_reason: null,
            },
            activeTab: {
                candidate: 0,
                rejected: 0
            },
            rowData: "",
            showModal: false,
            showTutorial: true,
            colorTagsTotals: [],
            willShowTutorial: false,
            storedSettings: [],
            subscriberAppointment: {
                subscriber: null,
                appointment: null,
                showModal: false
            },
            subscriberRejection: {
                subscriber: null,
                selectedRejectedReasion: null,
            },
            allLabels: []
        };
    },
    created() {
        window.setTimeout(function() {
            this.willShowTutorial = this.C_willShowTutorial;
        }, 1000);

        EventBus.$on("finish-tutorial", function() {
            this.C_willShowTutorial = false;
            this.willShowTutorial = false;
        });

        this.getStoredSettings();
        this.moreParams.per_page = this.storedSettings.per_page;
    },
    mounted() {
        this.$events.$on("filter-reset", eventData => {
            this.onFilterReset();
            this.getColorTagsTotals(eventData);
        });
        this.$events.$on("candidate-set", eventData => {
            this.onCandidateSet(eventData);
            this.getColorTagsTotals(eventData);
        });
        this.$events.$on("rejected-set", eventData => {
            this.onRejectedSet(eventData);
            this.getColorTagsTotals(eventData);
        });
        this.$events.$on("color_tag-set", eventData =>
            this.onColorTagSet(eventData)
        );
        this.$events.$on("color_tag-reset", e => this.onColorTagReset());
        this.$events.$on("show-subscriber", eventData =>
            this.onShowModal(eventData)
        );
        this.$events.$on("close-modal", () => this.onCloseModal());
        EventBus.$on("update-color-tags-totals", () =>
            this.getColorTagsTotals(this.activeTab)
        );
        this.getColorTagsTotals(this.activeTab);
        this.$events.$on("show-per-page", eventData =>
            this.onShowPerPage(eventData)
        );
        EventBus.$on("finish-tutorial", function() {
            this.C_willShowTutorial = false;
            this.willShowTutorial = false;
        });
        EventBus.$on("filter-by-appointment-date", (eventData) => {
            this.onAppointmentDateSet(eventData);
            
            this.getColorTagsTotals({
                rejected: 0,
                candidate: 0,
                appointment_date: eventData,
                worked_in_intuitive: this.moreParams.worked_in_intuitive,
                keyword: this.moreParams.keyword,
                rejection_reason: this.moreParams.rejection_reason
            });
        })

        EventBus.$on("filter-by-worked-in-intuitive", (eventData) => {
            this.onWorkedBeforeSet(eventData);
            
            this.getColorTagsTotals({
                rejected: 0,
                candidate: 0,
                appointment_date: this.moreParams.appointment_date,
                worked_in_intuitive: eventData,
                keyword: this.moreParams.keyword,
                rejection_reason: this.moreParams.rejection_reason
            });
        })

        EventBus.$on("filter-by-keyword", (eventData) => {
            this.onKeywordSet(eventData);
            
            this.getColorTagsTotals({
                rejected: 0,
                candidate: 0,
                appointment_date: this.moreParams.appointment_date,
                worked_in_intuitive: this.moreParams.worked_in_intuitive,
                keyword: eventData,
                rejection_reason: this.moreParams.rejection_reason
            });
        })

        EventBus.$on("filter-by-rejection-reason", (eventData) => {
            this.onRejectedReasonSet(eventData);
            
            this.getColorTagsTotals({
                ...this.moreParams,
                rejection_reason: eventData
            });
        })
        EventBus.$on("on-create-appointment", (eventData) => {
            this.onCreateAppointment(eventData)
        });


        // subscriber events
        EventBus.$on('subscriber:update-color-tag', this.onSubscriberUpdateColorTag)
        EventBus.$on('subscriber:accept', this.onSubscriberAccept)
        EventBus.$on('subscriber:reject', this.showSubscriberRejectionModal)
        EventBus.$on('subscriber:candidate', this.onSubscriberCandidate)
        EventBus.$on('subscriber:delete', this.onSubscriberDelete)


        this.loadAllLabels();
    },
    methods: {
        errorHandler(error) {
            alert("Ocurrió un error:" + ' ' + error.message || error.data && error.data.message);
            console.log("Ocurrió un error:", error.message || error.data && error.data.message);
        },
        onPaginationData(paginationData) {
            this.$refs.paginationTop.setPaginationData(paginationData);
            this.$refs.paginationInfoTop.setPaginationData(paginationData);
            this.$refs.paginationBottom.setPaginationData(paginationData);
            this.$refs.paginationInfoBottom.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.table.changePage(page);
        },
        customHeaders() {
            const headers = { headers: { "api-key": process.env.MIX_API_KEY } };
            return headers;
        },
        formatDate(date, fmt = 'ddd DD MMM YYYY') {
            let fdate = this.moment(date).format(fmt);
            return fdate.charAt(0).toUpperCase() + fdate.slice(1)
        },
        formatBooleanField(value) {
            return value ? "Si" : "No";
        },
        onFilterReset() {
            this.activeTab.candidate = 0;
            this.activeTab.rejected = 0;
            this.moreParams = {
                candidate: this.activeTab.candidate,
                rejected: this.activeTab.rejected
            };


            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            EventBus.$emit("hide-color-tags-show-all");
            EventBus.$emit('reset-appointment-date-filter');
            EventBus.$emit('reset-worked-in-intuitive-filter');
            EventBus.$emit('reset-keyword-filter');
            EventBus.$emit('show-appointment-date-filter');
            EventBus.$emit('hide-rejected-reason-filter');

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onCandidateSet(filterText) {
            this.activeTab.candidate = filterText.candidate;
            this.activeTab.rejected = filterText.rejected;
            this.moreParams = {
                candidate: this.activeTab.candidate,
                rejected: this.activeTab.rejected
            };


            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            EventBus.$emit("hide-color-tags-show-all");
            EventBus.$emit('reset-appointment-date-filter');
            EventBus.$emit('reset-worked-in-intuitive-filter');
            EventBus.$emit('reset-keyword-filter');
            EventBus.$emit('show-appointment-date-filter');
            EventBus.$emit('hide-rejected-reason-filter');

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onRejectedSet(filterText) {
            this.activeTab.rejected = filterText.rejected;
            this.moreParams = {
                rejected: this.activeTab.rejected
            };


            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            EventBus.$emit("hide-color-tags-show-all");
            EventBus.$emit('reset-appointment-date-filter');
            EventBus.$emit('reset-worked-in-intuitive-filter');
            EventBus.$emit('reset-keyword-filter');
            EventBus.$emit('hide-appointment-date-filter')
            EventBus.$emit('show-rejected-reason-filter')

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onColorTagSet(filterText) {
            if (this.activeTab.rejected) {
                this.moreParams = {
                    color_tag: filterText,
                    rejected: this.activeTab.rejected,
                    appointment_date: this.moreParams.appointment_date
                };
            } else {
                this.moreParams = {
                    color_tag: filterText,
                    candidate: this.activeTab.candidate,
                    rejected: this.activeTab.rejected,
                    appointment_date: this.moreParams.appointment_date
                };
            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onColorTagReset(filterText) {
            if (this.activeTab.rejected) {
                
                this.moreParams = {
                    rejected: this.activeTab.rejected,
                    appointment_date: this.moreParams.appointment_date
                };

            } else {
                
                this.moreParams = {
                    candidate: this.activeTab.candidate,
                    rejected: this.activeTab.rejected,
                    appointment_date: this.moreParams.appointment_date
                };

            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onAppointmentDateSet(appointment_date) {
            if (appointment_date) {
                this.moreParams.appointment_date = appointment_date
            } else {
                this.moreParams.appointment_date = null
            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onWorkedBeforeSet(val) {
            if (val) {
                this.moreParams.worked_in_intuitive = val
            } else {
                this.moreParams.worked_in_intuitive = null
            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onKeywordSet(val) {
            if (val) {
                this.moreParams.keyword = val
            } else {
                this.moreParams.keyword = null
            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        onRejectedReasonSet(val) {
            if (val) {
                this.moreParams.rejection_reason = val
            } else {
                this.moreParams.rejection_reason = null
            }

            this.getStoredSettings();
            this.moreParams.per_page = this.storedSettings.per_page;

            Vue.nextTick(() => this.$refs.table.refresh());
        },
        getFullNameAndPhoneAndAge(data, index) {
            const phoneCss = css`
                color: ${colors.neutral.SpanishGray};
            `;
            const ageCss = phoneCss;
            const html = `<span>${
                data.full_name
            }</span> <span class="${phoneCss}">${
                data.cell_phone
            }</span> <span class="${ageCss}">– ${data.age} años</span>
            `;

            return html;
        },
        onShowModal(data) {
            this.rowData = data;
            this.showModal = true;
        },
        onCloseModal() {
            this.showModal = false;
            this.rowData = "";
        },
        getColorTagsTotals(filter) {
            if (filter.rejected) delete filter.candidate;
            EventService.getSubscriberColorTagsTotals(filter)
                .then(response => {
                    const pattern = {
                        gray: 1,
                        red: 2,
                        yellow: 3,
                        green: 4,
                        blue: 5,
                        purple: 6
                    };
                    this.colorTagsTotals = response.data.sort((x, y) => {
                        return pattern[x.color_tag] - pattern[y.color_tag];
                    });
                })
                .catch(error => {
                    alert("Ocurrió un error:", error.response);
                });
        },
        onShowPerPage(filterText) {
            this.moreParams.per_page = filterText;
            Vue.nextTick(() => this.$refs.table.refresh());
        },
        getStoredSettings() {
            if (localStorage.getItem("stored-settings")) {
                try {
                    this.storedSettings = JSON.parse(
                        localStorage.getItem("stored-settings")
                    );
                } catch (e) {
                    localStorage.removeItem("stored-settings");
                }
            }
        },
        onCreateAppointment(subscriber) {
            this.subscriberAppointment.subscriber = subscriber;
            this.subscriberAppointment.showModal = true;
        },


        // subscriber
        onSubscriberUpdateColorTag({subscriber, value}) {
            // console.log({subscriber, value})
            EventService.putSubscriberLabelId(subscriber.id, value.color_tag)
                .then(response => {
                    this.$refs.table.reload();
                    subscriber.label = value
                    EventBus.$emit("update-color-tags-totals");
                })
                .catch(this.errorHandler);
        },
        onSubscriberAccept({subscriber, value}) {
            EventService.putSubscriberCandidate(subscriber.id, value)
                .then(response => {
                    this.$refs.table.reload();
                    EventBus.$emit("update-color-tags-totals");
                    this.onCloseModal()
                })
                .catch(this.errorHandler);
        },
        showSubscriberRejectionModal({subscriber}) {
            this.subscriberRejection.subscriber = subscriber;
        },
        hideSubscriberRejectionModal({subscriber}) {
            this.subscriberRejection.subscriber = null;
        },
        onSubscriberReject({subscriber, value}) {
            EventService.putSubscriberRejected(subscriber.id, value)
                .then(response => {
                    this.$refs.table.reload();
                    EventBus.$emit("update-color-tags-totals");
                    this.$events.fire("close-modal");
                })
                .catch(this.errorHandler);
        },
        onSubscriberCandidate({id, candidateValue, rejectedValue}) {
            EventService.putSubscriberCandidate(id, candidateValue)
                .then(response => {
                    EventService.putSubscriberRejected(id, rejectedValue)
                        .then(response => {
                            this.$refs.table.reload();
                            EventBus.$emit("update-color-tags-totals");
                            this.$events.fire("close-modal");
                        })
                        .catch(this.errorHandler);
                })
                .catch(this.errorHandler);
        },
        onSubscriberDelete(subscriber) {
            let c = confirm(`¿Estás seguro que quieres eliminar a ${ subscriber.full_name } de tu base de datos?`);
            if (c) {
                EventService.deleteSubscriber(subscriber.id)
                    .then(response => {
                        this.$refs.table.reload()
                        EventBus.$emit('update-color-tags-totals')
                        EventBus.$emit('deleted-applicant')
                    })
                    .catch(this.errorHandler);
            }
        },
        getSubscriberStatusText({rejected, candidate}) {
            if (rejected) {
                return 'Rechazado'
            }

            if (candidate && !rejected) {
                return 'Aceptado'
            }

            if (!candidate && !rejected) {
                return 'Aceptado'
            }
        },

        loadAllLabels() {
            EventService.loadAllLabels()
                .then(r => {
                    this.allLabels = r.data.data
                })
                .catch(this.errorHandler)
        }

    },
    computed: {
        C_willShowTutorial: {
            get: function() {
                return Cookies.get("t_comp_tut") == "undefined" ||
                    !Cookies.get("t_comp_tut")
                    ? true
                    : false;
            },
            set: function(setter) {
                Cookies.set("t_comp_tut", setter);
            }
        }
    }
};
</script>
