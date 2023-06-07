<template>
	<radio-input-group>

		<input-label class="input-label">{{ label }}</input-label>

		<div class="wrapper">
			
			<template v-for="option in options">
				
				<label
					:for="`${name}-${option}`"
					:class="['radio-button-label', {checked: modelValue == option}]">
				
					<span>{{option}}</span>
				
					<input
						hidden
						type="radio"
						:id="`${name}-${option}`"
						:name="name"
			            :value="option"
						v-validate="v_validate_rules"
			            :data-vv-as="label"
			            :checked="modelValue == option"
			            @change="modelValue = $event.target.value">
				
				</label>
			
			</template>

		</div>
		
		<slide-x-left-transition>
			<error-message v-if="errors.first(name)">    
	            <span>{{errors.first(name)}}</span>
	        </error-message>
		</slide-x-left-transition>
	</radio-input-group>
</template>

<script>
	import styled from 'vue-emotion'
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'
	import {InputLabel, ErrorMessage} from '@/config/website/BaseConstants.vue'

	const RadioInputGroup = styled('label')`
		.wrapper {
			display: grid;
			grid-gap: 1rem;
			grid-auto-columns: minmax(0, 1fr);
			grid-auto-flow: column;
		}
		.radio-button-label {
			background-color: ${colors.general.white};
			border: solid 1px ${colors.brand.sec};
			border-radius: 10px;
			text-align: center;
			color: ${colors.brand.dimSec};
			padding: .5rem;
			cursor: pointer;

			&:hover,
			&:focus-within,
			&.checked {
				background-color: ${colors.brand.sec};
			}
			&.checked {
				color: inherit;
			}
		}

	`

	export default {

		props: {
			name: {
				type: [String, Number],
				required: true
			},
			label: String,
			value: [String, Number],
			options: Array,
			v_validate_rules: String,
			error: String,
		},

		components: {
			InputLabel,
			ErrorMessage,
			RadioInputGroup
		},

		inject: ["parentValidator"],

		created() {
            this.$validator = this.parentValidator
        },


		computed: {
			modelValue: {
				get() { return this.value },
				set(value) { this.$emit('input', value) },
			}
		}

	}
</script>