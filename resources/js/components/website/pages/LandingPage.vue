<template>
    <div>
        <landing-nav></landing-nav>
        <main>
            <hero>
                <landing-section>
                    <div class="wrap">
                        <hero-copy>
                            <div class="hero-text">
                                <h2>
                                    REGISTRO DE TÉCNICO DE ENSAMBLE
                                </h2>
                                <h3>
                                    ¡SÉ PARTE DE LA <b>INNOVACIÓN</b>!
                                </h3>
                                <div>
                                    <button-primary @click="scrollTo('registro')" :disabled="!$root.enableRegistration"> Quiero registrarme </button-primary>
                                </div>
                            </div>
                            <div class="float-img">
                                <img src="/images/landing-page/icons/section-decor.svg" alt="">
                            </div>
                        </hero-copy>

                    </div>
                </landing-section>
            </hero>

            <s-landing-section>
                <div class="flex-wrap">
                    <div class="left">
                        <div class="text">
                            <h4>LLENA TU SOLICITUD PARA TÉCNICO DE ENSAMBLE</h4>
                            <p>y <b>programa tu cita</b> para proceso de reclutamiento</p>
                        </div>
                        <div class="float-img">
                            <img src="/images/landing-page/icons/section-decor.svg" alt="">
                        </div>
                    </div>
                    <div class="right">
                        <h5>
                            Requisitos
                        </h5>
                        <ul>
                            <li>Certificado de preparatoria o Carrera Técnica</li>
                            <li>Disponibilidad de horario</li>
                            <li>Mayor de 18 años</li>
                            <li>Experiencia en la industria</li>
                            <li>Estabilidad laboral</li>
                        </ul>
                    </div>
                </div>

            </s-landing-section>

            <benefits-section>
                <b-landing-section>
                    <h3>
                        TE OFRECEMOS
                    </h3>

                    <VueSlickCarousel v-bind="slickSettings" class="benefits-slick">
                        <div v-for="(b, i) in benefits1">
                            <div class="benefit-block">
                                <img :src="`/images/landing-page/benefits-1/${b.img}`">
                                <p v-html="b.label"></p>
                            </div>
                        </div>

                        <template #prevArrow>
                            <div class="benefits-arrow">
                                <img src="/images/landing-page/icons/triangle-bullet-light.svg" alt="">
                            </div>
                        </template>
                        <template #nextArrow>
                            <div class="benefits-arrow">
                                <img src="/images/landing-page/icons/triangle-bullet-light.svg" alt="">
                            </div>
                        </template>
                    </VueSlickCarousel>

                </b-landing-section>
            </benefits-section>

            <s-landing-section class="hook">
                <salary-block>
                    <div class="badge"> Nuevo salario </div>
                    <div class="salary">
                        <span> $430 </span> pesos diarios
                    </div>
                    <div class="text">
                        ¡Contratación directa!
                    </div>
                </salary-block>
            </s-landing-section>



            <landing-section v-if="$root.enableRegistration">
                <form-wrapper>
                    <subscription-form id="registro"></subscription-form>
                </form-wrapper>
            </landing-section>

            <landing-section v-else>
                <blocked-registration-advice>
                    Por el momento no contamos con vacantes disponibles.
                </blocked-registration-advice>
            </landing-section>


            <landing-g-map>
                <iframe
                    src="https://www.google.com/maps/d/embed?mid=1XFNCathHJCZ8XMq5E4N7hvlmTkPAp7Yv"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </landing-g-map>


        </main>

        <landing-footer></landing-footer>
    </div>
</template>

<script>
import TRY from '@/config/website/BaseConstants.vue'
import variables from '@/config/website/WebsiteVariables.js'
import colors from '@/config/website/WebsiteColors.js'
import styled, { css } from 'vue-emotion'
import {
    LandingSection,
    BorderedBox,
    ImageAndTextBullet,
    LinkButton,
    ButtonPrimary
} from '@/config/website/BaseConstants.vue'
import LandingNav from '@/components/website/LandingNav.vue'
import DialogueSlider from '@/components/website/DialogueSlideComponent.vue'
import SubscriptionForm from '@/components/website/SubscriptionForm.vue'
import VideoCard from '@/components/website/VideoCard.vue'
import LandingFooter from '@/components/website/Footer.vue'
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
// import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'


const Hero = styled(BorderedBox)`
    background-image: url('/images/landing-page/hero-bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-color: ${colors.brand.prim};
    border: none;
    padding: 7rem 2rem;
    overflow: hidden;

    @media (min-width: ${variables.commonBreakpoints.sm}) {
        padding: 7rem 2rem;
    }

    @media (min-width: ${variables.commonBreakpoints.lg}) {
        padding: 7rem 0;
    }
`

const HeroCopy = styled('div')`
    padding-bottom: 1rem;
    word-wrap: break-word;
    text-align: left;
    position: relative;

    h2 {
        color: ${colors.brand.light};
        font-size: 1.125rem;
        margin: 0;
        margin-bottom: 5rem;

        @media (min-width: ${variables.sections.hero.fontBreakPoint}) {
            font-size: 1.25rem;
        }
    }

    h3 {
        color: ${colors.landing.white};
        margin: 4rem 0 0 0;
        font-weight: 400;
        font-size: 22px;
        max-width: 250px;

        b {
            font-size: 1.5em;
        }

    }

    .float-img {
        left: -150px;
        top: -10px;
        position: absolute;
        width: 300px;

        img {
            min-width: 100%;
        }
    }

    .hero-text {
        z-index: 10;
        position: relative;
    }

    @media (min-width: ${variables.sections.hero.fontBreakPoint}) {
        h2 {
            margin-bottom: 1rem;
        }

        h3 {
            margin-top: 0;
            max-width: 400px;
            font-size: 3rem;

            b {
                font-size: 1.125em;
            }
        }
    }


`

const LandingGMap = styled('div')`
    height: 500px;
    overflow: hidden;

    iframe {
        margin-top: -100px;
        height: calc(100% + 100px);
        width: 100%;
    }

`

const SLandingSection = styled(LandingSection)`
    padding: 3rem 2rem;

    @media (min-width: ${variables.commonBreakpoints.sm}) {
        padding: 4rem 1rem;
    }

    @media (min-width: ${variables.commonBreakpoints.lg}) {
        .flex-wrap {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: space-between;

            > * {
                // flex: 1;
            }
        }

        .left {
            max-width: 375px;
            font-size: 20px;

            h4 {
                font-size: 28px;
                max-width: 376px;
                margin-top: 1.5rem;
            }
        }

    }

    h4 {
        font-size: 18px;
        color: ${colors.brand.prim};
        text-transform: uppercase;
        max-width: 280px;
    }

    h5 {
        font-size: 1rem;
        color: ${colors.brand.prim};
        text-transform: uppercase;
    }

    .left {
        margin-bottom: 4rem;
        position: relative;
        .text {
            z-index: 10;
        }

        .float-img {
            right: 10px;
            top: 20px;
        }

    }

    ul {
        padding-left: 1rem;
        li {
            margin-bottom: 1rem;
            list-style-image: url('/images/landing-page/icons/triangle-bullet-dark.svg');
        }
    }

    .float-img {
        position: absolute;
        img {
            min-width: 100%;
        }
    }



    &.hook {
        padding-bottom: 0;
        .hook-item {
            padding: 1.5rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;

            > * {
                display: inline-block;
            }

            .img {
                max-width: 80px;
            }

            .text {
                margin-left: -1.5rem;
                align-items: center;
                max-width: 220px;
            }
        }
    }


    @media (min-width: ${variables.commonBreakpoints.sm}) {
        &.hook {
            .flex-wrap {
                display: flex;
                flex-direction: row-reverse;
                align-items: center;
                justify-content: space-between;

                > * {
                    // flex: 1;
                }
            }
        }

        .hook-item .text {
            font-size: 1.5rem;
        }

        .hook-item .text {
            max-width: 240px;
        }
    }
`

const BLandingSection = styled(LandingSection)`
    padding: 3rem 1rem;

    @media (min-width: ${variables.commonBreakpoints.sm}) {
        padding: 4rem 3rem;
    }
`

const BenefitsSection = styled('div')`
    background-image: url('/images/landing-page/benefits-bg.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    text-align: center;
    color: ${colors.brand.light};

    .benefits-slick {
        margin-bottom: 2rem;
    }

    .slick-slide > div {
        display: flex;
    }

    .slick-arrow {
        position: absolute;
        bottom: -3rem;

        img {
            width: 1rem;
        }
    }


    .slick-prev {
        left: .5rem;
        img {
            transform: rotate(180deg);
        }
    }

    .slick-next {
        left: 3rem;
    }

    .benefit-block {
        padding: 0 .5rem 1rem;
        margin: 0 .5rem;
        text-align: center;
        border-radius: 10px;
        height: 192px;
        background-color: #FFFFFF10;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        img {
            display: inline-block!important;
            width: 70px;
        }
    }


    .show-all-button {
        color: ${colors.brand.sec};
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;

        .triangle-down {
            display: block;
            margin: 1rem auto;
        }
    }

    .triangle-down {
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid ${colors.brand.sec};
    }


    @media (min-width: ${variables.commonBreakpoints.md}) {
        .benefit-block img {
            width: 90px;
        }

        .slick-arrow {
            bottom: 86px;
        }


        .slick-prev {
            left: -1.5rem;
        }

        .slick-next {
            left: 100%;
        }
    }
`

const SalaryBlock = styled('div')`
    background-color: ${colors.brand.extraDimPrim};
    background-image: url('/images/landing-page/salary-block-decor.svg');
    background-repeat: no-repeat;
    background-position: 50% 100%;
    background-size: 200px;
    text-align: center;
    padding: 2rem;
    border-radius: 10px;

    .badge {
        display: inline-block;
        padding: .25rem 1rem;
        text-transform: uppercase;
        color: ${colors.landing.white};
        background-color: ${colors.landing.black};
        border-radius: 50px;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    .salary {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 2rem;

        span {
            font-size: 35px;
            color: ${colors.brand.prim};
            display: block;
        }
    }

    .text {
        font-weight: bold;
        margin-bottom: 170px;
    }

    @media (min-width: ${variables.commonBreakpoints.sm}) {
        padding: 80px;
        text-align: left;
        background-position: 95% 100%;
        background-size: 350px;

        .salary {
            font-size: 48px;

            span {
                font-size: inherit;
                display: inline;
            }
        }

        .text {
            font-size: 28px;
            margin-bottom: 0;
        }

    }
`

const BlockedRegistrationAdvice = styled('div')`
    font-size: 2rem;
    padding: 3rem 0;
    text-align: center;
    color: ${colors.brand.dimSec};
`

const FormWrapper = styled('div')`
    max-width: 706px;
    margin: 0 auto;
`

export default {
    name: 'LandingPage',

    components: {
        LandingSection,
        SLandingSection,
        BLandingSection,
        LandingNav,
        BorderedBox,
        Hero,
        HeroCopy,
        LinkButton,
        ButtonPrimary,
        VideoCard,
        DialogueSlider,
        SubscriptionForm,
        LandingFooter,
        LandingGMap,
        BenefitsSection,
        SalaryBlock,
        BlockedRegistrationAdvice,
        VueSlickCarousel,
        FormWrapper
    },

    data() {
        return {
            benefits1: [
                { img: 'medicos-menores.svg', label: 'Seguro de <b>gastos médicos menores</b>'},
                { img: 'vale-desp.svg', label: '<b>Vales</b> de despensa'},
                { img: 'comedor.svg', label: 'Subsidio de servicio <b>comedor</b>'},
                { img: 'medicos-mayores.svg', label: 'Seguro de <b>gastos médicos mayores</b>'},
                { img: 'acciones-comp.svg', label: '<b>Acciones</b> en la compañía'},
                { img: 'gastos-funerarios.svg', label: 'Seguro de <b>gastos funerarios</b> familiar'},
                { img: 'seguro-vida.svg', label: '<b>Seguro</b> de vida'},
                { img: 'reconocimiento.svg', label: 'Programas de <b>reconocimiento</b>'},
                { img: 'vacaciones.svg', label: '<b>Vacaciones y prima vacacional</b> superiores a las de la ley'},
                { img: 'caja-ahorro.svg', label: '<b>Caja</b> de ahorro'},
                { img: 'carpool.svg', label: 'Programa <b>carpool</b>'},
                { img: 'descanso-adic.svg', label: 'Días de <b>descanso adicionales</b> a los señalados por ley'},
                { img: 'fondo-ahorro.svg', label: '<b>Fondo</b> de ahorro'},
                { img: 'becas.svg', label: '<b>Becas</b> educativas'},
                { img: 'orienta-pae.svg', label: 'Programa <b>Orienta PAE</b>'},
                { img: 'bono-asist.svg', label: '<b>Bono</b> de puntualidad y asistencia'},
                { img: 'bono-desemp.svg', label: '<b>Bono anual</b> por desempeño'},
                { img: 'seguro-dental.svg', label: 'Seguro <b>dental</b>'},
                { img: 'transporte.svg', label: 'Servicio de <b>Transporte</b>'},
            ],
            benefits: [{
                img: '/images/landing-page/benefits/seguro-vida.png',
                label: '<b>Seguro</b> de vida',
            },{
                img: '/images/landing-page/benefits/seguro-gastos.png',
                label: '<b>Seguro de gastos médicos</b> mayores y menores',
            },{
                img: '/images/landing-page/benefits/crecimiento.png',
                label: 'Oportunidad de <b>crecimiento</b>',
            },{
                img: '/images/landing-page/benefits/acciones.png',
                label: '<b>Acciones</b> en la compañía',
            },{
                img: '/images/landing-page/benefits/bono.png',
                label: '<b>Bono anual</b> por desempeño',
            },{
                img: '/images/landing-page/benefits/carpool.png',
                label: 'Programa <b>carpool</b>',
            },{
                img: '/images/landing-page/benefits/vacaciones.png',
                label: '<b>Vacaciones y aguinaldo</b> superiores a las de la ley',
            },{
                img: '/images/landing-page/benefits/subsidio.png',
                label: 'Subsidio de <b>comedor</b>',
            },{
                img: '/images/landing-page/benefits/aprendizaje.png',
                label: 'Aprendizaje continuo',
            },{
                img: '/images/landing-page/benefits/puntualidad.png',
                label: 'Premio de puntualidad y asistencia',
            },{
                img: '/images/landing-page/benefits/fondo.png',
                label: 'Fondo y caja de ahorro',
            },{
                img: '/images/landing-page/benefits/despensa.png',
                label: 'Vales de despensa',
            },],
            showAllBenefits: true,
            slickSettings: {
                dots: false,
                // arrows: false,
                infinite: true,
                autoplay: false,
                slidesPerRow: 2,
                slidesToScroll: 1,
            }
        }
    },

    created() {
        this.setResponsiveSlickSettings()
        window.addEventListener('resize', () => this.setResponsiveSlickSettings())
    },

    methods: {
        setResponsiveSlickSettings() {
            let md = parseInt(variables.commonBreakpoints.md.replace('px', ''));
            let lg = parseInt(variables.commonBreakpoints.lg.replace('px', ''));

            if (window.innerWidth < md) {
                this.slickSettings.slidesPerRow = 2
            } else if (window.innerWidth < lg) {
                this.slickSettings.slidesPerRow = 4
            } else {
                this.slickSettings.slidesPerRow = 5
            }
        },
        scrollTo(anchor) {
            const element = document.getElementById(anchor)
            const top = element.offsetTop - 210

            window.scrollTo(0, top)
        }
    }

}
</script>
