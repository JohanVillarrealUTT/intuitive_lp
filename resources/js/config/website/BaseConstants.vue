<script>
	import styled from 'vue-emotion'
	import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'

	export const AppMain = styled('main')`
		min-height: calc(100vh - 100px);
	`;

	export const Box = styled('div')`
	    color: ${colors.brand.dark};
	    font-size: 1em;
	    padding: .875rem 1rem;
	    border-radius: 10px;
	    background-color: ${colors.brand.extraDimPrim};

	    &.active {
	        color: ${colors.general.white};
	        background-color: ${colors.brand.dark};
	    }

	    &.outlined {
	    	background-color: transparent;
	    	border: ${colors.brand.prim} 1px solid;
	    	color: ${colors.brand.mid};

	    	b {
	    		color: ${colors.brand.dark}
	    	}
	    }

	    &.sm {
	    	font-size: .75rem;
	    	padding: .5rem;
	    }
	`

	export const Card = styled('div')`
		border: solid 1px ${ colors.general.stainedGray };
		padding: 2rem;
		border-radius: 10px;
	`

	export const TitleH1 = styled('h1')`
		font-size: 1.125em;
		color: ${colors.brand.prim};
		text-transform: uppercase;
		margin: 0;

		@media (min-width: ${variables.commonBreakpoints.md}) {
	        font-size: 1.5em;
	    }
	`

	export const TitleH2 = styled('h2')`
		font-size: .875rem;
		color: ${colors.brand.prim};
		text-transform: uppercase;
		margin: 0;
	`

	export const LandingSection = styled('section')`
	    padding: ${variables.sections.landingSection.padding};
	    margin: auto;
	    max-width: 964px;

	    &.pt0 {
	        padding-top: 0px;
	    }

	    &.ptb0 {
	        padding-top: 0px;
	        padding-bottom: 0px;
	    }

	    &.ptb8 {
	        padding-top: 8rem;
	        padding-bottom: 8rem;
	    }

	    @media (min-width: ${variables.commonBreakpoints.sm}) {
	        padding: 0rem;
	    }

	    @media (min-width: ${variables.commonBreakpoints.lg}) {
	        padding: 0rem 0rem;
	    }
	`

	export const BorderedBox = styled('div')`
	    border: none;
	`

	export const LandingHalfs = styled('div')`
	    display: flex;
	    flex-direction: column;

	    & > :first-of-type {
	        margin-right: 0;
	        margin-bottom: 2rem;
	    }
	    & > :last-of-type {
	        margin-left: 0;
	    }

	    @media (min-width: ${variables.sections.halfs.breakPoint}) {
	        flex-direction: row;

	        & > :first-of-type {
	            margin-right: ${variables.sections.halfs.marginBetween};
	            margin-bottom: 0rem;
	        }
	        & > :last-of-type {
	            margin-left: ${variables.sections.halfs.marginBetween};
	        }

	        & > :first-of-type,
	        & > :last-of-type {
	            width: 50%;
	        }
	    }
	`

	export const ImageAndTextBullet = styled('div')`
		display: flex
	`


	export const LandingHalfsSection = styled('div')`
	    display: flex;
	    flex-direction: column;

	    & > :first-of-type {
	        margin-right: 0;
	        margin-bottom: 2rem;
	    }
	    & > :last-of-type {
	        margin-left: 0;
	    }

	    @media (min-width: ${variables.sections.halfs.breakPoint}) {
	        flex-direction: row;

	        & > :first-of-type {
	            margin-right: ${variables.sections.halfs.marginBetween};
	            margin-bottom: 0rem;
	        }
	        & > :last-of-type {
	            margin-left: ${variables.sections.halfs.marginBetween};
	        }

	        & > :first-of-type,
	        & > :last-of-type {
	            width: 50%;
	        }
	    }
	`


	//input styled components

	export const InputGroup = styled('div')`
	    margin-bottom: 1rem;

	    &.p0 {
	    	padding: 0;
	    }

	    &.centered {
	    	text-align: center;
	    }
	`

	export const DoubleInputGroup = styled('div')`
	    display: grid;
	    grid-gap: 1rem;
	    grid-template-columns: 1fr;

	    > * {
	    	margin-bottom: 1rem;
	    }

    	@media (min-width: ${variables.commonBreakpoints.sm}) {
    		grid-template-columns: 1fr 1fr;
    	}

	`

	export const InputLabel = styled('label')`
		text-transform: uppercase;
    	color: ${colors.brand.dimSec};
        display: block;
        font-size: .875em;
        font-weight: 600;
        padding-bottom: .5rem;

        small {
        	color: ${colors.brand.tert};
        	font-weight: 400;
        }
    `

    export const MainInput = styled('input')`
    	background: transparent;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid ${colors.brand.mid};
        color: ${colors.brand.dark};
        font-size: 1rem;
        padding: .5rem 1rem;
        width: 100%;
    `

    export const ErrorMessage = styled('div')`
        display: block;
        margin-top: 1rem;
        color: ${colors.landing.red};
        font-size: .875rem;

        &.mt0 {
	        margin-top: 0;
        }
    `


    //buttons
    export const ButtonPrimary = styled('button')`
	    background-color: ${colors.brand.prim};
	    font-weight: ${variables.text.h2.fontWeight};
	    border: none;
	    border-radius: 10px;
	    color: ${colors.landing.white};
	    cursor: pointer;
	    display: inline-block;
	    font-size: .875em;
	    padding: 1rem 2rem;
	    transition: all .3s ease;
	    text-transform: uppercase;
	    &[disabled] {
		    background-color: ${colors.brand.sec};
	    	cursor: not-allowed;
	        pointer-events: none;
	    }
	    &:hover,
	    &:focus-within,
	    &:active {
	    	background-color: ${colors.brand.tert}
	    }
	    &.block {
	    	width: 100%;
	    }
	`
	export const ButtonSecundary = styled(ButtonPrimary)`
		background-color: transparent;
	    color: ${colors.brand.prim};
	    &[disabled] {
		    color: ${colors.brand.sec};
	    	cursor: not-allowed;
	        pointer-events: none;
	    }
	    &:hover,
	    &:focus-within,
	    &:active {
	    	background-color: transparent;
		    color: ${colors.brand.sec};
	    }
	`

	export const GreyLink = styled('div')`
		display: inline-block;
        cursor: pointer;
        color: ${colors.brand.dimSec};

        &:hover {
            color: ${colors.brand.sec};
        }
	`

	export const LinkButton = styled('a')`
		color: ${colors.brand.dimSec};
	    border: none;
	    cursor: pointer;
	    text-decoration: none;
	    font-weight: 600;

	    &.active,
	    &:hover {
	    	color: ${ colors.brand.prim };
	    }
	`
	export const LinkButtonPrimary = styled(LinkButton)`
		color: ${colors.brand.prim};
	    &.active,
	    &:hover {
	    	color: ${ colors.brand.dimSec };
	    }
	`
    export const NavButtonPrimary = styled('button')`
	border-radius: 20px;
    border: none;
	cursor: pointer;
	text-decoration: none;
	font-weight: 600;
    background-color: ${colors.brand.prim};

	&.active,
	&:hover {
		color: ${colors.brand.dimSec};
	}
`


	export const ModalContent = styled('div')`
		padding: 2rem;
        background-color: white;
        text-align: center;
		color: ${colors.brand.dimSec};

		> h, p, ul, li {
			margin-bottom: 2rem;
		}

		hr {
    		border: none;
    		border-bottom: ${ colors.general.dimGrey } 1px solid;
    		margin: 2rem 0;

    		&.sm {
	    		margin: 1rem 0;
    		}
    	}

    	h2 {
    		font-size: .875rem;
    		color: ${ colors.brand.dark };
    		text-transform: uppercase;
    	}
	`

	export const ModalContentWrap = styled('div')`
		padding: 1rem;

		@media (min-width: ${variables.commonBreakpoints.sm}) {
			padding: 2rem;
		}
	`

	export default {}
</script>
