<template>
    <div>
        <label v-if="label" :class="labelCss">{{ label }}</label>
        <input
            @input="onInput"
            v-bind="$attrs"
            :class="[inputCss, { 'is-error': error }]"
            :name="name"
            ref="input"
        >
        <small v-if="error">{{ error }}</small>
    </div>
</template>

<script>
import { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables.js'
import colors from '@/config/admin/AdminColors'

export default {
    $_veeValidate: {
        value() {
            return this.$el.value
        },
        name() {
            return this.name
        }
    },
    inheritAttrs: false,
    props: ['label', 'name', 'error', 'value'],
    data() {
        return {
            labelCss: css({
                color: colors.neutral.GraniteGray,
                display: 'flex',
                fontFamily: "Raleway",
                fontSize: '16px',
                fontWeight: "500",
                padding: '4px 4px 4px 0px'
            }),
            inputCss: css({
                background: '#313237',
                border: '1px solid #878EAA',
                borderRadius: '4px',
                color: '#fff',
                display: 'flex',
                fontFamily: "Raleway",
                fontWeight: "500",
                fontSize: '16px',
                padding: '1rem',
                width: '524px',
                height: '48px',
                marginBottom: '24px'
            })
        }
    },
    mounted() {
        this.$refs.input.value = this.value
    },
    methods: {
        onInput(event) {
            this.$emit('input', event.target.value)
        }
    }
}
</script>