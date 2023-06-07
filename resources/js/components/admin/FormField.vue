<template>
    <div>
        <label v-if="label" :class="labelCss">{{ label }}</label>
        <small :class="smallCss">{{ small }}</small>
        <input
            @input="onInput"
            v-bind="$attrs"
            :class="[inputCss, { 'is-error': error }]"
            :name="name"
            :id="name"
            ref="input"
            v-mask="processedMask"
        >
        <small v-if="error" :class="errorCss">{{ error }}</small>
    </div>
</template>

<script>
import { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables.js'
import colors from '@/config/admin/AdminColors.js'

export default {
    inheritAttrs: false,
    props: ['label', 'name', 'error', 'value', 'mask', 'small'],
    inject: ["parentValidator"],
    data() {
        return {
            labelCss: css({
                color: colors.neutral.SpanishGray,
                fontSize: vars.text.label.fontSize,
                fontWeight: vars.text.label.fontWeight
            }),
            smallCss: css({
                color: colors.neutral.SpanishGray,
            }),
            errorCss: css({
                color: colors.secondary.danger,
            }),
            inputCss: css({
                border: 'none',
                borderBottom: `${vars.border.width} ${vars.border.style} ${
                    vars.border.color
                }`,
                color: colors.neutral.GraniteGray,
                display: 'flex',
                fontFamily: "'Roboto', sans-serif",
                fontSize: vars.text.input.fontSize,
                fontWeight: vars.text.input.fontWeight,
                padding: '0.25rem 0',
                width: '100%',
                '&:focus': {
                    borderBottomColor: colors.primary.UNBlue
                },
                '&[readonly]': {
                    border: 'none'
                }
            })
        }
    },
    mounted() {
        this.$refs.input.value = this.value
    },
    created() {
        if (this.parentValidator) {
            this.$validator = this.parentValidator
        }
    },
    methods: {
        onInput(event) {
            this.$emit('input', event.target.value)
        }
    },
    computed: {
        processedMask: function() {
            return this.mask != undefined ? this.mask : ''
        }
    }
}
</script>