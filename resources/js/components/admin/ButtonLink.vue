<template>
    <button-link @click="$emit('on-click')">
        <slot></slot>
    </button-link>
</template>

<script>
import styled from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import vars from '@/config/admin/AdminVariables.js'

const ButtonLink = styled('button')`
    background-color: transparent;
    border: none;
    color: ${colors.primary.UNBlue};
    cursor: pointer;
    display: inline-block;
    font-size: ${vars.text.button.fontSize};
    font-weight: ${vars.text.button.fontWeight};
    padding: 0.5rem 1rem;
`

export default {
    components: { ButtonLink }
}
</script>
