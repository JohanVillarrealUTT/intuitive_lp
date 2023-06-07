<template>
    <div>
       

        <input-label
            v-if="label"
        >
            {{ label }} <small class="small">{{processedSmall}}</small>
        </input-label>
         
        <input
            v-validate="v_validate_rules"
            :data-vv-as="label"
			:type="processedType"
	    	:value="value"
	        @input="$emit('input', $event.target.value)"
            @change="$emit('input', $event.target.value)"
	        :class="InputStyle"
	        :name="name" 
            v-mask="processedMask"
		>
        </input>
       
        <slide-x-left-transition>
            <error-message v-if="errors.first(name)">    
                <span>{{errors.first(name)}}</span>
            </error-message>
        </slide-x-left-transition>


    </div>
</template>

<script>
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'
    import {EventBus} from '@/event-bus.js'

    import {InputLabel, MainInput, ErrorMessage} from '@/config/website/BaseConstants.vue'
    import {InputStyle} from '@/config/website/CommonStyles.vue'


    export default {
    	name: 'TextInput',

        props: ['label', 'small', 'name',  'type', 'error', 'value', 'v_validate_rules', 'mask',],

    	components: {
    		InputLabel,
    		MainInput,
    		ErrorMessage,
    	},

        inject: ["parentValidator"],

        data: () => ({
            InputStyle: InputStyle,
        }),

        created() {
            this.$validator = this.parentValidator
        },

        computed: {
            processedMask: function () {
                return this.mask != undefined ? this.mask : ''
            },

            processedType: function () {
                return this.type != undefined ? this.type : 'text'
            },

            processedSmall: function () {
                return this.small != undefined ? this.small : ''
            }
        },
    }
</script>