<template>
    <modal :show-modal="show_modal" :max-width="'500px'">
        <modal-wrap>
            <div class="close-button-wrap" >
                <grey-link @click="emitcloseModal">Cerrar</grey-link>
            </div>
            <modal-title>
                <p>Error de validación</p>
                <span>Rectifique que su información sea válida.</span>
            </modal-title>
            <messages>
                <li v-for="error in errorMessages">{{ error[0] }}</li>
            </messages>
        </modal-wrap>
    </modal>
</template>

<script>
    import styled from 'vue-emotion'
    import colors from '@/config/website/WebsiteColors.js'
    import modal from '@/components/website/LandingModalWindow.vue'
    import {GreyLink} from '@/config/website/BaseConstants.vue'

    import CloseBtn from '@/components/website/ButtonPrimary.vue'
    import { EventBus } from '@/event-bus.js'

    const ModalWrap = styled('div')`
        padding: 1rem;

        @media (min-width: 600px) {
            padding: 1rem;
        }

        .close-button-wrap {
            text-align: right;
        }
    `

    const ModalTitle = styled('div')`
        text-align: center;

        p {
            font-size: 1.5rem;
            font-weight: 600;
            color: ${colors.landing.orange};
            margin: 0.5rem 0;
        }

        span {
            font-size: 0.875rem;
            font-weight: 400;
            display: block;
            margin-top: 0.5rem;
            color: ${colors.landing.clearGray};
        }
    `

    const Messages = styled('ul')`
        list-style: none;
        padding: 0;
        margin-top: 2rem;

        & li {
            display: block;
            margin-bottom: 1rem;
            text-align: center;
        }
    `

    export default {
        name: 'ValidarionErrors',

        props: ['show_modal', 'error_list'],

        components: {
            modal,
            ModalWrap,
            GreyLink,
            Messages,
            ModalTitle,
            CloseBtn
        },

        computed: {
            errorMessages() {
                return this.error_list
            }
        },

        methods: {
            emitcloseModal() {
                EventBus.$emit('closeValidationErrors')
            }
        }
    }
</script>