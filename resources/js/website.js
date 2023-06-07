import Vue from "vue";
import VueRouter from "vue-router";
import WebsiteApp from "@/components/website/WebsiteApp.vue";
import VeeValidate from "vee-validate";
import messagesES from "vee-validate/dist/locale/es";
import VueMask from "v-mask";
import { injectGlobal } from "vue-emotion";
import colors from "@/config/website/WebsiteColors.js";
import Transitions from "vue2-transitions";
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import { routes } from "@/router/website.js";

Vue.config.devtools = process.env.MIX_APP_ENV == 'local';
Vue.config.debug = process.env.MIX_APP_ENV == 'local';
Vue.config.silent = process.env.MIX_APP_ENV != 'local';

//para mascaras de inputs
Vue.use(VueMask);
Vue.use(VueToast);

//para transiciones
//-- FadeTransition
//-- ZoomCenterTransition
//-- ZoomXTransition
//-- ZoomYTransition
//-- CollapseTransition
//-- ScaleTransition
//-- SlideXLeftTransition
//-- SlideXRightTransition
//-- SlideYUpTransition
//-- SlideYDownTransition
Vue.use(Transitions);

Vue.use(VueRouter);

injectGlobal`

  @import url('https://fonts.googleapis.com/css?family=Roboto:400,700');

  html {
    background: #fff;
    font-family: 'Roboto';
    -webkit-font-smoothing: antialiased;
  }

	.subscription-form--disabled {
		> div:not([max-width]) {
			input,
			select,
			textarea,
			button,
			.ui-slider,
      input + div,
      label[for="cv"] {
				opacity: 0.6;
				pointer-events: none;
			}
		}
  }

  #nprogress {
    .bar {
      background: ${colors.landing.red};
    }

    .peg {
      box-shadow: none;
    }
  }

  a {
    color: ${ colors.brand.prim }
  }

  .v-toast__item--success {
    background-color: ${ colors.brand.tert }
  }
`;

// para validaciónes
Vue.use(VeeValidate, {
    events: "change|input",
    locale: "es",
    dictionary: {
        es: { messages: messagesES.messages }
    }
});

const router = new VueRouter({
    mode: "history",
    routes
});

//permitir registro
const enableRegistration = document.getElementById('enableRegistration').value == 1 ? true : false;

new Vue({
    el: "#landing-app",
    components: { WebsiteApp },
    router,
    data() {
      return {
        enableRegistration
      }
    }
});
