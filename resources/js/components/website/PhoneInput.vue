<template>
    <div>


        <input-label v-if="label">
            {{ label }} <small class="small">{{processedSmall}}</small>
        </input-label>


        <input
            v-validate="v_validate_rules"
            :data-vv-as="label"
			type="phone"
	    	:value="value"
	        @input="$emit('input', $event.target.value)"
            :class="InputStyle"
	        :name="name" 
            v-mask="processedMask"
		>
        </input>


        <error-message v-if="errors.first(name)">    
            <span>{{errors.first(name)}}</span>
        </error-message>


    </div>
</template>

<script>
import $ from 'jquery'
import variables from '@/config/website/WebsiteVariables.js'
import colors from '@/config/website/WebsiteColors.js'
import {EventBus} from '@/event-bus.js'

import {InputLabel,  ErrorMessage} from '@/config/website/BaseConstants.vue'
import {InputStyle} from '@/config/website/CommonStyles.vue'

export default {

    props: ['label', 'small', 'name', 'error', 'value', 'v_validate_rules', 'mask'],

	name: 'TextInput',

	components: {
		InputLabel,
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

        processedSmall: function () {
            return this.small != undefined ? this.small : ''
        }
    },
}
</script>