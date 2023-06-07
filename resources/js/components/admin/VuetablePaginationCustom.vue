<template>
    <ul class="pagination" :class="paginationCss">
        <li :class="{ 'disabled': isOnFirstPage }" class="page-item">
            <a href @click.prevent="loadPage('prev')" class="page-link">
                <svg
                    width="6px"
                    height="10px"
                    viewBox="0 0 6 10"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g
                            id="toyota-mockup-proposal"
                            transform="translate(-1219.000000, -1035.000000)"
                            fill="#666666"
                            fill-rule="nonzero"
                        >
                            <polygon
                                id="‹"
                                points="1221.08594 1039.67578 1224.10938 1044.32812 1222.45703 1044.32812 1219 1039.78125 1219 1039.55859 1222.45703 1035 1224.10938 1035"
                            ></polygon>
                        </g>
                    </g>
                </svg>
            </a>
        </li>
        <li :class="{ 'disabled': isOnLastPage }" class="page-item">
            <a href @click.prevent="loadPage('next')" class="page-link">
                <svg
                    width="6px"
                    height="10px"
                    viewBox="0 0 6 10"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g
                            id="toyota-mockup-proposal"
                            transform="translate(-1265.000000, -1035.000000)"
                            fill="#666666"
                            fill-rule="nonzero"
                        >
                            <polygon
                                id="›"
                                points="1266.66406 1035 1270.12109 1039.55859 1270.12109 1039.78125 1266.66406 1044.33984 1265 1044.33984 1268.02344 1039.67578 1265 1035"
                            ></polygon>
                        </g>
                    </g>
                </svg>
            </a>
        </li>
        <li class="page-item">
            <custom-popover>
                <ul>
                    <li>
                        <span class="list-label">Mostrar página de:</span>
                    </li>
                    <li>
                        <a href="#" v-on:click.prevent="onClickShowPerPage(25)">25 aspirantes</a>
                    </li>
                    <li>
                        <a href="#" v-on:click.prevent="onClickShowPerPage(50)">50 aspirantes</a>
                    </li>
                    <li>
                        <a href="#" v-on:click.prevent="onClickShowPerPage(100)">100 aspirantes</a>
                    </li>
                </ul>
            </custom-popover>
        </li>
    </ul>
</template>

<script>
import VuetablePaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'
import { css } from 'vue-emotion'
import colors from '@/config/admin/AdminColors'
import CustomPopover from '@/components/admin/CustomPopover.vue'
import VueEvents from 'vue-events'

const paginationCss = css`
    display: flex;
    list-style: none;
    margin: 0;
    padding-left: 1rem;

    .page-item {
        &:hover .page-link {
            background-color: ${colors.neutral.Isabelline};
        }

        &.disabled {
            opacity: 0.6;

            &:hover a {
                background-color: transparent;
            }
        }

        .page-link,
        .popover .more {
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 2.875em;
            height: 2.875em;
        }
    }
`

export default {
    components: {
        CustomPopover
    },
    data: () => ({ paginationCss: paginationCss }),
    mixins: [VuetablePaginationMixin],
    methods: {
        onClickShowPerPage(data) {
            this.$events.fire('show-per-page', data)

            const settings = { per_page: data }
            const parsed = JSON.stringify(settings)
            localStorage.setItem('stored-settings', parsed)
        }
    }
}
</script>