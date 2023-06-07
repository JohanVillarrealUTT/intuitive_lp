<template>
    <div :class="filterTabsCss">
        <filter-tab @on-click="resetFilter" :class="{ active: activeTab === 'candidatos' }">
            <svg
                width="16px"
                height="22px"
                viewBox="0 0 16 22"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <!-- Generator: Sketch 53.2 (72643) - https://sketchapp.com -->
                <title>Icon / Whatshot / Filled</title>
                <desc>Created with Sketch.</desc>
                <defs>
                    <path
                        d="M9.5,0.67 C9.5,0.67 10.24,3.32 10.24,5.47 C10.24,7.53 8.89,9.2 6.83,9.2 C4.76,9.2 3.2,7.53 3.2,5.47 L3.23,5.11 C1.21,7.51 0,10.62 0,14 C0,18.42 3.58,22 8,22 C12.42,22 16,18.42 16,14 C16,8.61 13.41,3.8 9.5,0.67 Z M7.71,19 C5.93,19 4.49,17.6 4.49,15.86 C4.49,14.24 5.54,13.1 7.3,12.74 C9.07,12.38 10.9,11.53 11.92,10.16 C12.31,11.45 12.51,12.81 12.51,14.2 C12.51,16.85 10.36,19 7.71,19 Z"
                        id="path-1-Whatshot"
                    ></path>
                </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="toyota-mockup-proposal" transform="translate(-108.000000, -219.000000)">
                        <g
                            id="Icon-/-Whatshot-/-Filled"
                            transform="translate(108.000000, 219.000000)"
                        >
                            <mask id="mask-2-Whatshot" fill="white">
                                <use xlink:href="#path-1-Whatshot"></use>
                            </mask>
                            <g id="icon/social/whatshot_24px" fill-rule="nonzero"></g>
                            <g
                                id="✱-/-Color-/-Icons-/-Selected-/-On-Surface-/-Inactive"
                                mask="url(#mask-2-Whatshot)"
                                fill="#CF232C"
                            >
                                <g transform="translate(-4.000000, 0.000000)" id="Rectangle">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            Candidatos
        </filter-tab>
        <filter-tab @on-click="doFilterRechazados" :class="{ active: activeTab === 'rechazados' }">
            <svg
                width="22px"
                height="22px"
                viewBox="0 0 22 22"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <!-- Generator: Sketch 53.2 (72643) - https://sketchapp.com -->
                <title>Icon / Cancel / Filled</title>
                <desc>Created with Sketch.</desc>
                <defs>
                    <path
                        d="M16.3333333,14.8266667 L14.8266667,16.3333333 L11,12.5066667 L7.17333333,16.3333333 L5.66666667,14.8266667 L9.49333333,11 L5.66666667,7.17333333 L7.17333333,5.66666667 L11,9.49333333 L14.8266667,5.66666667 L16.3333333,7.17333333 L12.5066667,11 L16.3333333,14.8266667 Z M11,0.333333333 C5.10666667,0.333333333 0.333333333,5.10666667 0.333333333,11 C0.333333333,16.8933333 5.10666667,21.6666667 11,21.6666667 C16.8933333,21.6666667 21.6666667,16.8933333 21.6666667,11 C21.6666667,5.10666667 16.8933333,0.333333333 11,0.333333333 L11,0.333333333 Z"
                        id="path-1-Cancel"
                    ></path>
                </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="toyota-mockup-proposal" transform="translate(-413.000000, -221.000000)">
                        <g
                            id="Icon-/-Cancel-/-Filled"
                            transform="translate(413.000000, 221.000000)"
                        >
                            <mask id="mask-2-Cancel" fill="white">
                                <use xlink:href="#path-1-Cancel"></use>
                            </mask>
                            <g id="Mask"></g>
                            <g
                                id="✱-/-Color-/-Icons-/-Selected-/-On-Surface-/-Inactive"
                                mask="url(#mask-2-Cancel)"
                                fill="#666666"
                            >
                                <g transform="translate(-1.000000, -1.000000)" id="Rectangle">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            Rechazados
        </filter-tab>
        <filter-tab
            @on-click="doFilterAceptados"
            :class="{ 'active filter-tab-aceptados': activeTab === 'aceptados' }"
        >
            <svg
                width="22px"
                height="22px"
                viewBox="0 0 22 22"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <!-- Generator: Sketch 53.2 (72643) - https://sketchapp.com -->
                <title>Icon / Check Circle / Filled</title>
                <desc>Created with Sketch.</desc>
                <defs>
                    <path
                        d="M11,0 C4.928,0 0,4.928 0,11 C0,17.072 4.928,22 11,22 C17.072,22 22,17.072 22,11 C22,4.928 17.072,0 11,0 Z M8.8,16.5 L3.3,11 L4.851,9.449 L8.8,13.387 L17.149,5.038 L18.7,6.6 L8.8,16.5 Z"
                        id="path-1-Check-Circle"
                    ></path>
                </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="toyota-mockup-proposal" transform="translate(-722.000000, -223.000000)">
                        <g
                            id="Icon-/-Check-Circle-/-Filled"
                            transform="translate(722.000000, 223.000000)"
                        >
                            <mask id="mask-2-Check-Circle" fill="white">
                                <use xlink:href="#path-1-Check-Circle"></use>
                            </mask>
                            <g id="Mask" fill-rule="nonzero"></g>
                            <g
                                id="✱-/-Color-/-Icons-/-Selected-/-On-Surface-/-Inactive"
                                mask="url(#mask-2-Check-Circle)"
                                fill="#666666"
                            >
                                <g transform="translate(-2.200000, -2.200000)" id="Rectangle">
                                    <rect x="0" y="0" width="26" height="26"></rect>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            Aceptados
        </filter-tab>
    </div>
</template>

<script>
import FilterTab from '@/components/admin/FilterTab.vue'
import { css } from 'vue-emotion'

export default {
    components: {
        FilterTab
    },
    data() {
        return {
            filterTabsCss: css({
                display: 'flex',
                '> button': {
                    width: '33.333%'
                }
            }),
            activeTab: 'candidatos'
        }
    },
    methods: {
        resetFilter() {
            this.$events.fire('filter-reset', { candidate: 0, rejected: 0 })
            this.activeTab = 'candidatos'
        },
        doFilterRechazados() {
            this.$events.fire('rejected-set', { rejected: 1 })
            this.activeTab = 'rechazados'
        },
        doFilterAceptados() {
            this.$events.fire('candidate-set', { candidate: 1, rejected: 0 })
            this.activeTab = 'aceptados'
        }
    }
}
</script>
