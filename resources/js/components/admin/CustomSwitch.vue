<template>
    <div style="height: 20px;">
        <input
            @change="onClickSwitch($event)"
            type="checkbox"
            v-bind="$attrs"
            :class="inputCss"
            :checked="checked"
            :data-id="dataId"
            :id="id"
            :name="name"
        >
        <label :class="labelCss" :for="id">
            <slot></slot>
        </label>
    </div>
</template>

<script>
import { css } from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'

export default {
    inheritAttrs: false,
    model: {
        prop: 'checked',
        event: 'toggle-switch'
    },
    props: {
        checked: Boolean,
        dataId: Number,
        id: String,
        name: String
    },
    data() {
        return {
            labelCss: css({
                backgroundColor: '#b2b2b2',
                border: 'none',
                borderRadius: 'calc(20px / 2)',
                boxShadow: 'none',
                display: 'inline-block',
                position: 'relative',
                userSelect: 'none',

                overflow: 'hidden',

                width: '45px',
                height: '20px',

                '&:before': {
                    backgroundColor: 'transparent',
                    borderRadius: 'calc(20px / 2)',
                    content: "''",
                    display: 'block',

                    position: 'absolute',
                    top: 0,
                    left: 0,

                    width: '45px',
                    height: '20px'
                },

                // Toggle.

                '&:after': {
                    backgroundColor: '#fff',
                    boxShadow: 'none',
                    borderRadius: 'calc(20px / 2)',
                    content: "''",
                    display: 'block',

                    position: 'absolute',
                    top: '1px',
                    left: '1px',

                    width: '18px',
                    height: '18px'
                }
            }),
            inputCss: css({
                opacity: 0,
                position: 'absolute',
                zIndex: '-1',
                '&:checked': {
                    '& + label': {
                        '&:before': {
                            backgroundColor: colors.secondary.success,
                            boxShadow: 'none'
                        },
                        '&:after': {
                            left: '26px'
                        }
                    }
                },
                '&:disabled + label': {
                    opacity: '0.6',
                    '&:before': {
                        backgroundColor: 'transparent'
                    },
                    '&:after': {
                        left: '1px'
                    }
                }
            })
        }
    },
    methods: {
        onClickSwitch(event) {
            this.$emit('toggle-switch', event.target.checked, this.dataId)
        }
    }
}
</script>