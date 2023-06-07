<template>
	<div>
       


        <input-label
            v-if="label"
        >
            {{ label }}
        </input-label>
       

        <input
        	ref="HiddenInput"
            v-validate="v_validate_rules"
            :data-vv-as="label"
			:type="processedType"
	    	:value="value"
	        :class="{ 'is-error': error }"
	        :name="name" 
	        :id="name" 
            v-mask="processedMask"
            hidden="hidden"
		>
        <main-slider id="slider">        	
        </main-slider>
            

        <error-message v-if="errors.first(name)">    
            <span>{{errors.first(name)}}</span>
        </error-message>



    </div>
</template>

<script>
	import $ from 'jquery';
	import 'jquery-ui'
    import styled from 'vue-emotion'
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'

    const InputLabel = styled('label')`
    	color: ${colors.landing.white};
        display: block;
        font-family: Raleway;
        font-size: 1rem;
        font-weight: 500;
        padding-bottom: .5rem;
    `

    const MainSlider = styled('div')`
			&.ui-widget.ui-widget-content {
	    		background: #313237;
		        border: 1px solid #878EAA;
		        border-radius: 4px;
		        color: #fff;
	    	}
	    	
	    	& .ui-slider-handle{
	    		background-color: #878EAA;
	    		border: none;
	    	}
	    	
    	}
    `

    const ErrorMessage = styled('div')`
        display: block;
        margin-top: 1rem;
        color: ${colors.landing.red};
        font-size: .875rem;
    `

	export default {
		name: 'SliderSelectInput',

    	components: {
    		InputLabel,
    		MainSlider,
    		ErrorMessage,
    	},
        
        props: ['label', 'name',  'type', 'error', 'value', 'v_validate_rules', 'mask',],

        computed: {
            processedMask: function () {
                return this.mask != undefined ? this.mask : ''
            },

            processedType: function () {
                return this.type != undefined ? this.type : 'text'
            }
        },

		created() {
			let _this = this;

			$( function() {
			    $( "#slider" ).slider({
			      value:0,
			      min: 0,
			      max: 100,
			      step: 10,
			      slide: function( event, ui ) {
					$( "#"+_this.name+"" ).val(ui.value);
					// _this.$refs.HiddenInput.trigger(''input'')
					_this.$emit('input', ui.value)
			      }
			    });
			    $( "#"+_this.name+"" ).val( $( "#slider" ).slider( "value") );
			  } );
		}
	}
</script>