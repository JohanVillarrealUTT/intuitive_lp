<template>
	<small v-if="show">{{ error_message }}</small>
</template>

<script>
	import styled from 'vue-emotion'
	
	export default {
		name: 'ErrorMessage',

		props: ['show', 'error_message']
	}

</script>