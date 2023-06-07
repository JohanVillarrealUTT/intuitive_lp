<template>
    <div class="container">
        <h2>Etiquetas disponibles</h2>
        <table-container>
            <vuetable-nav-bar>
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
                    ref="table"
                    api-url="/api/v1/label"
                    :fields="tableFields"
                    pagination-path
                    @vuetable:pagination-data="onPaginationData"
                    :sort-order="sortOrder"
                    :multi-sort="true"
                    :css="css.table"
                    :append-params="moreParams"
                    :http-options="customHeaders()"
                >
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

        <label-form v-if="showLabelForm" :show-modal="showLabelForm" :is-editing="formIsEditing"></label-form>
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
import VueEvents from "vue-events";
import OptionsBar from "@/components/admin/AppointmentLabelsOptionsBar.vue";
import LabelsCustomActions from "@/components/admin/LabelsCustomActions.vue";
import ColorTagCell from "@/components/admin/ColorTagCell.vue";
import { EventBus } from "@/event-bus.js";
import EventService from "@/services/AdminEventService.js";
import NProgress from "nprogress";
import Cookies from "js-cookie";
import LabelForm from "@/components/admin/LabelForm.vue";

// import AdminTutorial from "@/components/admin/AdminTutorial.vue";

Vue.use(Vuetable);
Vue.use(VueEvents);

// Vue.component("candidate-action", CandidateAction);
Vue.component("labels-custom-actions", LabelsCustomActions);
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
    name: "AdminLabels",
    components: {
        Vuetable: CustomVuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        TableContainer,
        VuetableNavBar,
        OptionsBar,
        // SubscriberShow,
        // AdminTutorial,
        LabelForm
    },
    data() {
        return {
            tableFields: [
                {
                    name: "created_at",
                    sortField: "created_at",
                    title: "Fecha creacion",
                    dataClass: 'bold capitalize',
                    callback: "formatDate| dddd DD MMM YY",
                },
                {
                    name: "__component:color-tag-cell",
                    sortField: "color",
                    title: "color"
                },
                {
                    name: "name",
                    sortField: "name",
                    title: "Nombre"
                },
                {
                    name: "__component:labels-custom-actions",
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
            showLabelForm: false,
            formIsEditing: null
        };
    },
    mounted() {
        let _this = this;
        EventBus.$on("create-label", function() {
            _this.showLabelForm = true;
        });

        EventBus.$on("edit-label", function(rowData) {
            _this.onEditLabel(rowData)
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
            this.$refs.table.changePage(page);
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
        onEditLabel(rowData) {
            this.formIsEditing = rowData;
            this.showLabelForm = true;
        }
    },
    created() {
        this.getStoredSettings();
        this.moreParams.per_page = this.storedSettings.per_page;
    }
};
</script>
