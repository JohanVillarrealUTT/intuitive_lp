<template>
    <div>
        <landing-nav
            :hide-links="true"
        >
        </landing-nav>
        <app-main>
            <s-landing-section>
                <index-cards-section>
                    <card-link
                        v-for="link in links"
                        :key="link.label"
                        :href="link.url"
                        :disabled="link.disabled"
                    >
                        <div class="bg-image" :style="getCardBgStyle(link.imgSrc)"></div>
                        <span class="text"> {{ link.label }} </span>
                    </card-link>
                </index-cards-section>
            </s-landing-section>
        </app-main>

        <landing-footer></landing-footer>
    </div>
</template>

<script>
import TRY from '@/config/website/BaseConstants.vue'
import variables from '@/config/website/WebsiteVariables.js'
import colors from '@/config/website/WebsiteColors.js'
import styled, { css } from 'vue-emotion'
import {
    AppMain,
    LandingSection,
    BorderedBox,
    ImageAndTextBullet,
    ButtonPrimary,
    LinkButton
} from '@/config/website/BaseConstants.vue'
import LandingNav from '@/components/website/LandingNav.vue'
import LandingFooter from '@/components/website/Footer.vue'

const SLandingSection = styled(`LandingSection`)`
    max-width: 1280px;
`

const IndexCardsSection = styled('div')`
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;

    @media (min-width: ${ variables.commonBreakpoints.md }) {
        flex-direction: row;
        padding: 0;
    }
`

const CardLink = styled('a')`
    display: block;
    max-width: 286px;
    padding: 8px;
    width: 100%;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    text-decoration: none;
    color: white;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;

    .bg-image {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: ${ colors.brand.prim };
        transition: all .2s linear;
    }

    .text {
        z-index: 10;
        text-align: center;
    }


    &:hover .bg-image {
        transform: scale(1.1);
    }

    &[disabled] {
        opacity: .5;
        pointer-events: none;
    }

    @media (min-width: ${ variables.commonBreakpoints.md }) {
        max-width: 370px;
        height: 300px;
        margin: 0 1rem;
    }
`

export default {
    name: 'IndexPage',
    components: {
        AppMain,
        LandingSection,
        SLandingSection,
        LandingNav,
        BorderedBox,
        ButtonPrimary,
        LinkButton,
        LandingFooter,
        IndexCardsSection,
        CardLink,
    },
    data() {
        return {
            links: [{
                label: 'Vacantes Administrativas',
                imgSrc: '/images/landing-page/card-1-bg.png',
                url: 'https://careers.intuitive.com/us/en',
                disabled: false
            },{
                label: 'Técnicos de ensamble especializado',
                imgSrc: '/images/landing-page/card-2-bg.png',
                url: '/tecnico-ensamble-especializado',
                disabled: !this.$root.enableRegistration
            },{
                label: 'Vacantes Indirectas',
                imgSrc: '/images/landing-page/card-3-bg.png',
                url: '/vacantes-indirectas',
                disabled: false
            }]
        }
    },
    methods: {
        getCardBgStyle(imgSrc) {
            return `
                background-image: url('${imgSrc}');
                background-position: center;
                background-size: cover;
                background-blend-mode: multiply;
            `
        }
    }

}
</script>
