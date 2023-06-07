<template>
    <div>
       


        <input-label v-if="label">
            {{ label }} <small class="small">{{processedSmall}}</small>
        </input-label>
       
       

        <select
            v-validate="v_validate_rules"
            :data-vv-as="label"
	    	:value="value"
	        @input="$emit('input', $event.target.value)"
	        :class="InputStyle"
	        :name="name" 
            v-mask="processedMask"
		>
            <option :value="null">Selecciona...</option>
            <option v-for="inputOption in options" :value="inputOption.value">{{inputOption.label}}</option>
        </select>
       
       

        <error-message v-if="errors.first(name)">    
            <span>{{errors.first(name)}}</span>
        </error-message>



    </div>
</template>

<script>
    import {css} from 'vue-emotion'
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'
    import {EventBus} from '@/event-bus.js'

    import {InputLabel, ErrorMessage} from '@/config/website/BaseConstants.vue'
    import {InputStyle} from '@/config/website/CommonStyles.vue'


    const SelectInputStyle = css`
        ${InputStyle}
        -moz-appearance:none;
        -webkit-appearance:none;
        appearance:none;
        background-position: calc(100% - 1rem);
        background-size: 15px;
        background-image: url('/images/landing-page/icons/select-arrow.png');
        background-repeat: no-repeat;
    `

    export default {
    	name: 'SelectInput',

    	components: {
    		InputLabel,
            InputStyle,
    		ErrorMessage,
    	},

        inject: ["parentValidator"],

        props: ['label', 'small', 'name', 'error', 'value', 'v_validate_rules', 'options'],
        
        data: () => ({
            InputStyle: SelectInputStyle,
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
            },
        },

    }
</script>