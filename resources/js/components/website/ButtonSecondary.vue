<template>
    <button-secondary @click="$emit('on-click')"  :style="{width: getWidth()}">
        <slot></slot>
    </button-secondary>
</template>

<script>
import styled, { css } from 'vue-emotion'
import landingColors from '@/config/website/WebsiteColors.js'
import variables from '@/config/website/WebsiteVariables.js'

const ButtonSecondary = styled('button')`
    background-color: transparent;
    border: 1px solid ${landingColors.landing.red};
    border-radius: 50px;
    color: ${landingColors.landing.red};
    cursor: pointer;
    display: inline-block;
    padding: ${variables.buttons.secondary.padding};
    font-weight: ${variables.buttons.secondary.fontWeight};
    font-size: ${variables.buttons.secondary.fontSize};
    &[disabled] {
        opacity: 0.6;
    }
`

export default {
    props: {
        full_width: {
            type: Boolean,
            default: false
        }
    },
 
    components: { ButtonSecondary },

    methods: {
        getWidth() {
            return this.full_width ? '100%' : 'auto'
        }
    }
    // data: () => ({
    //     isFullWidth: '',
    // })    

    // created() {
    //     this.isFullWidth = this.css({

    //     }) 
    // }
}
</script>
