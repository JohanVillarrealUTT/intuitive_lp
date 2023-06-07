<template>
    <div class="container">
        <h2>Fechas disponibles</h2>
        <table-container>
            <vuetable-nav-bar>
                <!-- <filter-tabs></filter-tabs> -->
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
            <options-bar :color-tags-totals="colorTagsTotals"></options-bar>
            <div class="table-responsive">
                <vuetable
                    ref="vuetableAppointmentDate"
                    api-url="/api/v1/appointment-dates"
                    :fields="subscriberFields"
                    pagination-path
                    @vuetable:pagination-data="onPaginationData"
                    :sort-order="sortOrder"
                    :multi-sort="true"
                    :css="css.table"
                    :append-params="moreParams"
                    :http-options="customHeaders()"
                >
                    <template slot="appointment-date-hours-field" slot-scope="props">
                        <div v-for="h in props.rowData.hours">
                            <small>
                                <b>
                                    {{ h.hour }} /
                                </b>
                                <span>{{ h.space_available }} de {{ h.max_capacity }} lugares disponibles</span>
                            </small>
                        </div>
                    </template>

                    <!-- <template slot="appointment-date-edit-field" slot-scope="props">
                        <a href="#" title="editar" @click="onEditAppointmentDate(props.rowData)"> Editar </a>
                    </template> -->
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
        <!-- <subscriber-show v-if="showModal" :row-data="rowData" :show-modal="showModal"></subscriber-show> -->
        <!-- <zoom-center-transition>
            <admin-tutorial v-if="willShowTutorial" :show-modal="willShowTutorial"></admin-tutorial>
        </zoom-center-transition> -->

        <appointment-date-form v-if="showAppointmentDateForm" :show-modal="showAppointmentDateForm" :is-editing="formIsEditing"></appointment-date-form>
    </div>
</template>

<script>
import Vue from "vue";
import Vuetable from "vuetable-2/src/components/Vuetable.vue";
import VuetablePagination from "@/components/admin/VuetablePaginationCustom.vue";
import VuetablePaginationInfo from "@/components/admin/VuetablePaginationInfoCustom.vue";
import styled, { css } from "vue-emotion";
import colors from "@/config/admin/AdminColors.js";
import vars from "@/config/admin/AdminVariables.js";
import FilterTabs from "@/components/admin/FilterTabs.vue";
import VueEvents from "vue-events";
import OptionsBar from "@/components/admin/AppointmentDatesOptionsBar.vue";
import CandidateAction from "@/components/admin/CandidateAction.vue";
import AppointmentDatesCustomActions from "@/components/admin/AppointmentDatesCustomActions.vue";
import SubscriberShow from "@/components/admin/SubscriberShow.vue";
import ColorTagCell from "@/components/admin/ColorTagCell.vue";
import { EventBus } from "@/event-bus.js";
import EventService from "@/services/AdminEventService.js";
import NProgress from "nprogress";
import Cookies from "js-cookie";
import AppointmentDateForm from "@/components/admin/AppointmentDateForm.vue";

import AdminTutorial from "@/components/admin/AdminTutorial.vue";

Vue.use(Vuetable);
Vue.use(VueEvents);

Vue.component("candidate-action", CandidateAction);
Vue.component("appointment-custom-actions", AppointmentDatesCustomActions);
Vue.component("color-tag-cell", ColorTagCell);

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
    name: "AdminAppointmentDate",
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
        AppointmentDateForm
    },
    data() {
        return {
            subscriberFields: [
                {
                    name: "date",
                    sortField: "date",
                    title: "Fecha",
                    dataClass: 'bold capitalize',
                    callback: "formatDate| dddd DD MMM YY",
                },
                {
                    name: "__slot:appointment-date-hours-field",
                    title: "Horarios",
                },
                {
                    name: "created_at",
                    sortField: "created_at",
                    title: "Creada",
                    callback: "formatDate|MMM D"
                },
                {
                    name: "updated_at",
                    sortField: "updated_at",
                    title: "Actualizada",
                    callback: "formatDate|MMM D"
                },
                {
                    name: "status",
                    sortField: "status",
                    title: "Estatus",
                    callback: 'formatStatus'
                },
                {
                    name: "__component:appointment-custom-actions",
                    title: "",
                },
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
                rejected: 0
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
            showAppointmentDateForm: false,
            formIsEditing: null
        };
    },
    mounted() {
        let _this = this;
        this.$events.$on("show-subscriber", eventData =>
            this.onShowModal(eventData)
        );
        this.$events.$on("show-per-page", eventData =>
            this.onShowPerPage(eventData)
        );
        EventBus.$on("create-appointment-date", function() {
            _this.showAppointmentDateForm = true;
        });
        EventBus.$on("on-edit-appointment-date", function(rowData) {
            _this.onEditAppointmentDate(rowData);
        });
    },
    methods: {
        onPaginationData(paginationData) {
            this.$refs.paginationTop.setPaginationData(paginationData);
            this.$refs.paginationInfoTop.setPaginationData(paginationData);
            this.$refs.paginationBottom.setPaginationData(paginationData);
            this.$refs.paginationInfoBottom.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetableAppointmentDate.changePage(page);
        },
        customHeaders() {
            const headers = { headers: { "api-key": process.env.MIX_API_KEY } };
            return headers;
        },
        formatDate(value, fmt = "YYYY MM DD") {
            return value == null
                ? "--"
                : this.moment(value, "YYYY-MM-DD HH:mm:ss").format(fmt);
        },
        formatStatus(status) {
            switch (status) {
                case 'available':
                    return 'Disponible';
                    break;
                case 'full':
                    return 'Llena';
                    break;
                default:
                    return 'Cerrada';
                    break;
            }
        },
        formatBooleanField(value) {
            return value ? "Si" : "No";
        },
        onShowModal(data) {
            this.rowData = data;
            this.showModal = true;
        },
        onCloseModal() {
            this.showModal = false;
            this.rowData = "";
        },
        onShowPerPage(filterText) {
            this.moreParams.per_page = filterText;
            Vue.nextTick(() => this.$refs.vuetableAppointmentDate.refresh());
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
        onEditAppointmentDate(rowData) {
            this.formIsEditing = rowData;
            this.showAppointmentDateForm = true;
        }
    },
    created() {
        let _this = this;
        window.setTimeout(function() {
            _this.willShowTutorial = _this.C_willShowTutorial;
        }, 1000);

        EventBus.$on("finish-tutorial", function() {
            _this.C_willShowTutorial = false;
            _this.willShowTutorial = false;
        });

        this.getStoredSettings();
        this.moreParams.per_page = this.storedSettings.per_page;
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
