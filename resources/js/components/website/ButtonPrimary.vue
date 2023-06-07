<template>
    <button-primary type="button" @click="$emit('on-click')" :style="{width: getWidth()}">
        <slot></slot>
    </button-primary>
</template>

<script>
import styled, {css} from 'vue-emotion'
import colors from '@/config/website/WebsiteColors.js'
import vars from '@/config/website/WebsiteVariables.js'

const ButtonPrimary = styled('button')`
    background-color: ${colors.landing.red};
    font-weight: ${vars.text.h2.fontWeight};
    border: none;
    border-radius: 50px;
    color: ${colors.landing.white};
    cursor: pointer;
    display: inline-block;
    font-size: 20px;
    padding: 0.8rem 5rem;
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
 
    components: { ButtonPrimary },

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
