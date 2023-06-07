<template>
    <landing-modal-window :show-modal="show" max-width="572px">
        <modal-content>
            <h5>GRACIAS POR TU INTERÉS</h5>
            <p>
                Por el momento buscamos candidatos con un perfil distinto. Puedes intentar registrarte nuevamente en <b>24 hrs</b>.
            </p>
            <p>
                Para otras posiciones, consulta las vacantes en: <a href="https://careers.intuitive.com/us/en">careers.intuitive.com/us/en</a>
            </p>
            <br>
            <link-button-primary type="button" @click="$emit('input', false)">CERRAR</link-button-primary>
        </modal-content>
    </landing-modal-window>
</template>

<script>
    import styled from 'vue-emotion'
    import colors from '@/config/website/WebsiteColors.js'
    import LandingModalWindow from '@/components/website/LandingModalWindow.vue'
    import { LinkButtonPrimary } from '@/config/website/BaseConstants.vue'

    const ModalContent = styled('div')`
        padding: 2rem;
        color: ${colors.landing.black};
        text-align: center;
        max-width: 426px;
        margin: 0 auto;

        a {
            text-decoration: none;
        }
    `
    
    export default {
        
        props: ['show'],

        model: {
            prop: 'show'
        },

        components: {
            LandingModalWindow,
            LinkButtonPrimary,
            ModalContent
        }

    }
</script>