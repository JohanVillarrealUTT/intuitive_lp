<template>
    <modal v-if="showModal" :max-width="maxWidth">
        <modal-overlay></modal-overlay>
        <modal-content-container>
            <modal-content :class="modalContentMaxWidthCss">
                <slot></slot>
            </modal-content>
        </modal-content-container>
    </modal>
</template>

<script>
import styled, { css } from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import { EventBus } from '@/event-bus.js'

const Modal = styled('div')`
    display: block;
    overflow-x: hidden;
    overflow-y: auto;
    z-index: 10;

    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;

    width: 100%;
    height: 100%;
`
const ModalOverlay = styled('div')`
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;

    background-color: ${colors.neutral.Isabelline};
    overflow: hidden;
    width: 100%;
    height: 100%;

    opacity: 0.8;
    visibility: visible;
`
const ModalContentContainer = styled('div')`
    display: flex;
    align-items: center;
    min-height: 100%;

    &::before {
        display: block;
        height: 100vh;
        content: '';
    }
`
const ModalContent = styled('div')`
    opacity: 1;
    visibility: visible;

    display: flex;
    flex-direction: column;
    margin: 0 auto;
    max-height: auto;
    position: relative;

    width: 100%;
    background-color: #fff;
`

export default {
    components: {
        Modal,
        ModalOverlay,
        ModalContentContainer,
        ModalContent
    },
    props: ['show-modal', 'max-width'],
    data() {
        return {
            modalContentMaxWidthCss: css({
                maxWidth: this.maxWidth
            })
        }
    }
}
</script>