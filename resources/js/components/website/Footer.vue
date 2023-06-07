<template>
    <div :class="greenBg">
        <footer-container>
            <landing-section>
                
                <div class="footer-grid">
                    
                    <div class="footer-brand">
                        <img src="/images/landing-page/brand-logo-white.svg">
                    </div>   
                    
                    <div class="footer-info-slot">
                        <div class="info-slot-icon">
                            <img src="/images/landing-page/icons/ionic-pin.png">
                        </div>
                        <div>
                            <span class="info-slot-title"> PLANTA </span>
                            <br>
                            <p>Blvd. Carranza 1745, Col. Calles, 21226, Mexicali, Baja California</p>
                        </div>
                    </div>
                    
                    <div class="footer-info-slot">
                        <div class="info-slot-icon">
                            <img src="/images/landing-page/icons/simple-whatsapp.png">
                        </div>
                        <div>
                            <p>
                            <span class="info-slot-title"> Contacto </span>
                            <br>
                            reclutamiento@intusurg.com
                            </p>
                        </div>
                    </div>
                    
                    <div class="copy">
                        <p>&copy; {{new Date().getFullYear()}} <a href="https://atraetalento.com" target="_blank">atraetalento.com</a> </p>
                    </div> 

                </div>
            </landing-section>
            

        </footer-container>
    </div>
</template>

<script>
	import styled from 'vue-emotion'
    import {css} from 'vue-emotion'
    import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'
    import {LandingSection} from '@/config/website/BaseConstants.vue'

	const FooterContainer = styled('footer')`
        color: white;
        font-size: .75rem;
        padding: 1.5rem 2rem;
        background: ${colors.brand.dark};
        color: white;
        text-decoration: none;

        .footer-info-slot {
            display: flex;
            max-width: 270px;

            .info-slot-icon {
                margin-right: .5rem;
                
                img {
                    width: 1rem;
                }
            }

            .info-slot-title {
                text-transform: uppercase;
                color: ${colors.brand.sec}
            }
            
            p {
                margin: 0;
            }

        }

        .copy {
            * {
                color: ${ colors.brand.sec }!important;
                text-decoration: none;
            }
        }

        .footer-brand img {
            width: 65px;
        }

        .footer-grid {
            display: grid;
            grid-gap: 1rem;
            align-items: center;

            & :nth-child(1) {
                grid-row: 3/4;
                grid-column: 1/2;
            }

            & :nth-child(2) {
                grid-row: 1/2;
                grid-column: 1/4;
            }

            & :nth-child(3) {
                grid-row: 2/3;
                grid-column: 1/4;
            }


            & :nth-child(4) {
                grid-row: 3/4;
                grid-column: 2/4;
                text-align: right;
            }
        }

        @media (min-width: ${variables.commonBreakpoints.md}) {
            .footer-grid {
                
                & :nth-child(1) {
                    grid-row: 1/2;
                    grid-column: 1/2;
                }

                & :nth-child(2) {
                    grid-row: 1/2;
                    grid-column: 2/3;
                }

                & :nth-child(3) {
                    grid-row: 1/2;
                    grid-column: 3/4;
                }


                & :nth-child(4) {
                    grid-row: 2/3;
                    grid-column: 1/4;
                    text-align: left;
                }
            }
        }

    ` 
	export default {
		name: 'Footer',

        data: () => ({
            greenBg: css({
                background: `${colors.brand.sec}`
            })
        }),

		components: {
            FooterContainer,
            LandingSection
		},
	}
</script>