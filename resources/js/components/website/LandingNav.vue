<template>
	<s-nav>
		<nav-wrap class="ptb0">
			<div class="nav-container">
				<a href="/" :class="['nav-brand', {expanded: hideLinks}]">
					<img src="/images/brand-logo.png">
				</a>
				<div class="nav-links-container" v-if="!hideLinks">
					<link-button href="https://careers.intuitive.com/us/en" target="_blank"> VACANTES ADMINISTRATIVAS </link-button>
					<link-button :class="{active: $route.path == '/tecnico-ensamble-especializado'}" href="/tecnico-ensamble-especializado"> TÉCNICO DE ENSAMBLE ESPECIALIZADO </link-button>
                    <link-button :class="{active: $route.path == '/vacantes-indirectas'}" href="/vacantes-indirectas"> VACANTES INDIRECTAS </link-button>
				</div>
                <div v-if="!hideLinks">
                    <nav-button-primary :class="{active: $route.path == '/citas'}" href="/citas">CAMBIAR CITA</nav-button-primary>
                </div>
			</div>
		</nav-wrap>
	</s-nav>
</template>

<script>
	import styled from 'vue-emotion'
	import variables from '@/config/website/WebsiteVariables.js'
	import colors from '@/config/website/WebsiteColors.js'
    import { LandingSection, LinkButton } from '@/config/website/BaseConstants.vue'



	const sNav = styled('nav')`
		display: block;
		padding: ${variables.nav.paddingAll};
		background-color: ${variables.nav.bgColor};
		position: relative;

		img {
			display: block;
			max-width: 80px;

			@media (min-width: 500px) {
				max-width: ${variables.nav.logoMaxWidth};
			}
		}
	`

	const NavWrap = styled(LandingSection)`
		.nav-container {
			position: relative;
			display: flex;
			align-items: center;
			flex-direction: column;
			justify-content: center;

			@media (min-width: ${variables.commonBreakpoints.sm}) {
				flex-direction: row;
			}
		}

		.nav-brand {

			&.expanded {
				padding: 0;

				@media (min-width: ${variables.commonBreakpoints.md}) {
					padding: 4rem 0;
				}
			}
		}

		.nav-links-container {
			width: 100%;
			flex-grow: 1;
			text-align: right;
			padding: 1.5rem 0 1rem;
			display: flex;
			justify-content: center;

			a {
				text-transform: uppercase;
				margin: 0 1rem;
				font-size: .75rem;
			}

			@media (min-width: ${variables.commonBreakpoints.sm}) {
				flex-direction: row;
				justify-content: flex-end;
			}
		}
	`
    export const NavButtonPrimary = styled(LinkButton)`
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        font-size: 0.75em;
        font-weight: ${variables.text.h2.fontWeight};
        background-color: ${colors.brand.prim};
        color: ${colors.landing.white};
        padding: 0.5rem 1rem;
        white-space: nowrap;
        min-width: 100px;

        &:hover,
        &:focus,
        &:active {
            background-color: ${colors.brand.tert};
            color: ${colors.landing.white};
        }

        &:visited {
            color: ${colors.landing.white};
        }

        &.block {
            width: 100%;
        }
    `

	export default {
		name: 'Nav',
		props: ['hideLinks'],
		components: {
			sNav,
			NavWrap,
            LinkButton,
            NavButtonPrimary
		},


		methods: {
	        scrollTo(anchor) {
	            const element = document.getElementById(anchor)
	            const top = element.offsetTop - 210

	            window.scrollTo(0, top)
	        }
	    }
	}
</script>
