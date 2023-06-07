<template>
    <title-wrap>
        <form-title>
            <span>REGÍSTRATE PARA TÉCNICO DE ENSAMBLE</span>
            <slot>
                <span>Compártenos tu información y nos pondremos en contacto contigo lo más pronto posible.</span>
                <span>¡Buena suerte!</span>
            </slot>
        </form-title>
    </title-wrap>
</template>

<script>
	import styled from 'vue-emotion'
    import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'

    const TitleWrap = styled('div')`
        padding: 2rem;
    `

	const FormTitle = styled('h4')`
        max-width: 700px;
		color: white;
        text-align: center;
        margin: 3rem auto 2rem auto;
        color: ${colors.brand.dark};

        * {
            margin-bottom: 1rem;
        }

		& > :first-of-type {
            text-transform: uppercase;
            color: ${colors.brand.prim};
            font-weight: ${variables.text.h2.fontWeight};
            font-size: 1em;
        }
        
        & > :nth-of-type(2) {
            font-weight: ${variables.dialogueModalVideo.mutedText.fontWeight};
            font-size: 1em;
        }
        & > :nth-of-type(3) {
            text-transform: uppercase;
            font-weight: 600;
            font-size: .875em;
        }

		span {
			display: block;
		}
    ` 

	export default {
		name: 'FormHeader',
		components: {
            FormTitle,
            TitleWrap
		},
	}
</script>