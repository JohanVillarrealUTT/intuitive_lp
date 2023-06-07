<template>
	<div>
		<text-link> Si ya aplicaste con nosotros, <a href="/consultar#/resultados">consulta los resultados de tu evaluación.</a></text-link>
	</div>
</template>

<script>
	import styled, { css } from 'vue-emotion'
	import variables from '@/config/website/WebsiteVariables.js'
	import colors from '@/config/website/WebsiteColors.js'

	const textLink = styled('p')`
		color: white;
		text-align: center;
		font-size: ${variables.text.p.fontSize};
		padding: 11px;
		margin: 0px;
		background: ${colors.landing.red};
		a{
			text-decoration: underline;
			color: #fff;
		}
		a:hover { 
			color: ${colors.landing.orange};
		}
	`


	export default {
		name: 'ConsultResultLink',

		components: {
			textLink
		}
	}
</script>