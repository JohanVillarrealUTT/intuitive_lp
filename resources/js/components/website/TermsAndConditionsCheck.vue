<template>
    <div>
        <input-group>
            
            <p class="terms-label">
                <label :for="name">
                    <input
                        type="checkbox"
                        v-model="is_checked"
                        :name="name"
                        v-validate="v_validate_rules"
                        :data-vv-as="'Términos y condiciones'"
                        @change="$emit('input', $event.target.value)"
                        @input="$emit('input', $event.target.value)"
                    > 
                    Acepto los <span @click="showTerms = true">términos y condiciones de uso</span>
                </label>
            </p>

            <error-message v-if="errors.first(name)">    
                <span>{{errors.first(name)}}</span>
            </error-message>

        </input-group>

        <terms-modal :show_modal="showTerms"></terms-modal>
    </div>
</template>

<script>
	import styled from 'vue-emotion'
    import variables from '@/config/website/WebsiteVariables.js'
    import colors from '@/config/website/WebsiteColors.js'
    import TermsModal from '@/components/website/TermsAndConditionsModal.vue'
    import { EventBus } from '@/event-bus.js'

    const InputGroup = styled('div')`
    	padding-bottom: 1rem;
        text-align: right;

    	.terms-label {
    		font-weight: 500;
            
            input {
                margin-right: .5rem;
            }

    		span {
                cursor: pointer;
				color: ${colors.brand.prim};
				
				&:hover {
	    			color: ${colors.brand.dimSec};
				}
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

    	name: 'TermsAndConditionsCheck',

        props: ['name', 'v_validate_rules'],

    	components: {
    		InputGroup,
    		ErrorMessage,
            TermsModal,
            EventBus
    	},

        inject: ["parentValidator"],

        data: () => ({
            showTerms: false,

            is_checked: false
        }),

        created() {
            let _this = this

            this.$validator = this.parentValidator

            EventBus.$on('closeAndAcceptTerms', function() {
                _this.$emit('input', 'on')
                _this.is_checked = true
                _this.showTerms = false
            })

            EventBus.$on('closeTerms', function(e) {
                _this.showTerms = false
            })
        }

    }
</script>