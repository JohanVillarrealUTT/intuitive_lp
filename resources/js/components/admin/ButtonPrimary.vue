<template>
    <button-primary @click="$emit('on-click')">
        <slot></slot>
    </button-primary>
</template>

<script>
import styled from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import vars from '@/config/admin/AdminVariables.js'

const ButtonPrimary = styled('button')`
    background-color: ${colors.primary.UNBlue};
    border: none;
    border-radius: 0.25rem;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-size: ${vars.text.button.fontSize};
    font-weight: ${vars.text.button.fontWeight};
    padding: 0.5rem 1rem;
    &[disabled] {
        opacity: 0.6;
    }
`

export default {
    components: { ButtonPrimary }
}
</script>
