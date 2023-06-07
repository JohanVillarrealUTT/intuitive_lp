<template>
	

	<div>
	
        <input-label
            v-if="label"
        >
            {{ label }}
        </input-label>

		<input
			type="hidden"
			v-model="inputValue"
			v-validate="v_validate_rules"
			:data-vv-as="label"
			:name="name" >

		<halfs-double-button>
			<div @click="inputValue = 1" :class="{activeHalf: inputValue == 1}">
				Si
			</div>
			<div @click="inputValue = 0" :class="{activeHalf: inputValue == 0}">
				No
			</div>
		</halfs-double-button>

		<error-message v-if="errors.first(name)">
            <span>{{errors.first(name)}}</span>
        </error-message>

	</div>
		

</template>

<script>

	    import styled from 'vue-emotion'
	    import variables from '@/config/website/WebsiteVariables.js'
	    import colors from '@/config/website/WebsiteColors.js'

	    const HalfsDoubleButton = styled('div')`

	    	display: flex;

			& div:first-of-type,
			& div:last-of-type {
				background: #313237;
		        border: 1px solid #878EAA;
		        border-radius: 4px;
		        color: #fff;
		        font-size: 1rem;
		        padding: 1rem;
		        width: 50%;
		        text-align: center;
			}

			& div:first-of-type {
				border-top-right-radius: 0;
				border-bottom-right-radius: 0;
			}

			& div:last-of-type {
				border-top-left-radius: 0;
				border-bottom-left-radius: 0;
			}

			& div:first-of-type.activeHalf,
			& div:last-of-type.activeHalf {
	    		background-color: ${colors.landing.clearGray};
	    	}

	    `

	    const InputLabel = styled('label')`
	    	color: ${colors.landing.white};
	        display: block;
	        font-family: Raleway;
	        font-size: 1rem;
	        font-weight: 500;
	        padding-bottom: .5rem;
	    `

	    export default {
	    	props: ['label', 'name', 'error', 'value', 'v_validate_rules'],

	    	name: 'YesNoInput',

	    	data: () => ({
	    		inputValue: 0
	    	}),

	    	components: {
	    		InputLabel,
	    		HalfsDoubleButton,
	    	},

	    	watch: {
	    		inputValue: function (val) {
	    			console.log('watch')
	    			this.$emit('input', val)
	    		}
	    	}
	    }
	
</script>