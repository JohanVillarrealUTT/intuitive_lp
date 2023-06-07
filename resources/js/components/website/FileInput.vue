<template>
    <div>
       

        <input-label
            v-if="label"
        >
            {{ label }} <small class="small">{{small}}</small>
        </input-label>
         

        <input
            v-validate="v_validate_rules"
            :data-vv-as="label"
            type="file"
            @change="$emit('input', $event.target.files[0])"
            :class="InputStyle"
            :name="name" 
            v-bind="$attrs"
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

    import {InputLabel, ErrorMessage} from '@/config/website/BaseConstants.vue'
    import {InputStyle} from '@/config/website/CommonStyles.vue'


    export default {
        name: 'FileInput',

        props: ['label', 'small', 'name',  'type', 'error', 'value', 'v_validate_rules', 'mask',],

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
    }
</script>