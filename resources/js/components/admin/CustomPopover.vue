<template>
    <popover name="custom-popover" :close-on-content-click="false">
        <div slot="face">
            <a class="more" @click.prevent href>
                <svg
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="16px"
                    height="16px"
                    viewBox="0 0 16 16"
                    enable-background="new 0 0 16 16"
                    xml:space="preserve"
                >
                    <g id="Page-1">
                        <g
                            id="toyota-mockup-proposal-menu"
                            transform="translate(-1311.000000, -224.000000)"
                        >
                            <g
                                id="Icon-_x2F_-More-Vert-_x2F_-Filled"
                                transform="translate(1311.000000, 224.000000)"
                            >
                                <g id="Mask"></g>
                                <defs>
                                    <filter
                                        id="Adobe_OpacityMaskFilter"
                                        filterUnits="userSpaceOnUse"
                                        x="2"
                                        y="-4"
                                        width="12"
                                        height="24"
                                    >
                                        <feColorMatrix
                                            type="matrix"
                                            values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0"
                                        ></feColorMatrix>
                                    </filter>
                                </defs>
                                <mask
                                    maskUnits="userSpaceOnUse"
                                    x="2"
                                    y="-4"
                                    width="12"
                                    height="24"
                                    id="mask-2"
                                >
                                    <g filter="url(#Adobe_OpacityMaskFilter)">
                                        <path
                                            id="path-1"
                                            fill="#FFFFFF"
                                            d="M8,4c1.1,0,2-0.9,2-2S9.1,0,8,0S6,0.9,6,2S6.9,4,8,4L8,4z M8,6C6.9,6,6,6.9,6,8
						c0,1.1,0.9,2,2,2s2-0.9,2-2C10,6.9,9.1,6,8,6L8,6z M8,12c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S9.1,12,8,12L8,12z"
                                        ></path>
                                    </g>
                                </mask>
                                <g id="_x21B3_-Icon-Color" mask="url(#mask-2)">
                                    <g id="Rectangle" transform="translate(-4.000000, -4.000000)">
                                        <rect x="6" fill="#999999" width="12" height="24"></rect>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
        <div slot="content">
            <slot></slot>
        </div>
    </popover>
</template>

<script>
import popover from 'vue-popover'
import { injectGlobal } from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import vars from '@/config/admin/AdminVariables.js'

injectGlobal`
    .popover {
        position: relative;

        .more {
            border-radius: 50%;
            display: inline-flex;
            padding: 0.5rem;

            &:hover {
                background-color: ${colors.neutral.Isabelline};
            }
        }

        &.open .more {
            background-color: ${colors.neutral.Isabelline};
        }
    }

    .popover__container {
        background-color: #fff;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.2);
        padding: 0.5rem 0;
        position: absolute;
        right: 0;
        text-align: right;
        z-index: 9;

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        li {
            white-space: nowrap;

            a {
                display: block;
                padding: 0.5rem 1.25rem;
            }

            hr {
                background-color: none;
                border: none;
                border-bottom: 
                    ${vars.border.width} 
                    ${vars.border.style} 
                    ${vars.border.color};
                height: 0.063rem;
                margin: 0;
            }
        }

        .list-label {
            color: ${colors.neutral.SpanishGray};
            display: block;
            padding: 0.5rem 1.25rem;
        }

        .color-tag-radios {
            display: flex;
            padding: 0.75rem 1.25rem;
        }
    }
`

export default {
    components: {
        popover
    }
}
</script>
