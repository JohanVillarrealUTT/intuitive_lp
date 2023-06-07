<template>
    <div>
        <label v-if="label" :class="labelCss">{{ label }}</label>
        <textarea @input="onInputTextarea" v-bind="$attrs" :class="textareaCss" row="3"></textarea>
    </div>
</template>

<script>
import { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables.js'
import colors from '@/config/admin/AdminColors.js'

export default {
    inheritAttrs: false,
    props: ['label'],
    data() {
        return {
            labelCss: css({
                color: colors.neutral.SpanishGray,
                display: 'flex',
                fontSize: vars.text.label.fontSize,
                fontWeight: vars.text.label.fontWeight
            }),
            textareaCss: css({
                border: 'none',
                borderBottom: `${vars.border.width} ${vars.border.style} ${
                    colors.primary.UNBlue
                }`,
                color: colors.neutral.GraniteGray,
                display: 'flex',
                fontFamily: "'Roboto', sans-serif",
                fontSize: vars.text.input.fontSize,
                fontWeight: vars.text.input.fontWeight,
                marginBottom: '1rem',
                padding: '0.25rem 0',
                width: '100%'
            })
        }
    },
    methods: {
        onInputTextarea(event) {
            this.$emit('input', event.target.value)
        }
    }
}
</script>