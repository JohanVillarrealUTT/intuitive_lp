import Vue from "vue";
import VueRouter from "vue-router";
import AdminApp from "./components/admin/AdminApp.vue";
import { routes } from "./router/admin.js";
import VeeValidate from 'vee-validate';
import messagesES from "vee-validate/dist/locale/es";
import moment from 'moment';
import { injectGlobal } from "vue-emotion";
import colors from "@/config/admin/AdminColors.js";
import vars from "@/config/admin/AdminVariables.js";
import { darken } from "@/components/helpers/LightenDarkenColor.js";
import Transitions from "vue2-transitions";
// tooltip
import VTooltip from 'v-tooltip'
import 'v-tooltip/dist/v-tooltip.css'

import VueMask from "v-mask";

moment.locale('es')

Vue.use(VueRouter);
Vue.use(VeeValidate, {
  events: "change|input",
  locale: "es",
  dictionary: {
      es: { messages: messagesES.messages }
  },
  fieldsBagName: 'validationFields'
})
Vue.use(VueMask);
Vue.prototype.moment = moment;
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
// tooltip
Vue.use(VTooltip)

Vue.config.devtools = process.env.MIX_APP_ENV == 'local';
Vue.config.debug = process.env.MIX_APP_ENV == 'local';
Vue.config.silent = process.env.MIX_APP_ENV != 'local';

const maxWidth = "81rem";

injectGlobal`
  @import url('https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i');

  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }

  body {
    color: ${colors.neutral.GraniteGray};
    font-family: 'Roboto', sans-serif;
    font-size: 1rem;
    line-height: 1.5;
    margin: 0;
  }

  #app {
    min-height: 100vh;
  }

  .container {
    margin: 0 auto;
    padding: 0 1rem;
    max-width: ${maxWidth};
  }

  a {
    background-color: transparent;
    border: none;
    color: ${colors.primary.UNBlue};
    cursor: pointer;
    display: inline-block;
    font-size: ${vars.text.button.fontSize};
    font-weight: ${vars.text.button.fontWeight};
    text-decoration: none;
    transition: ${vars.transition};

    &:hover {
      color: ${darken(colors.primary.UNBlue, 20)};
    }
  }

  .table {
    border-collapse: collapse;
    text-align: left;
    width: 100%;

    th {
      font-weight: 700;
      padding: 0.75rem 1.25rem;
    }

    th, td {
      border-bottom:
        ${vars.border.width}
        ${vars.border.style}
        ${vars.border.color};
    }

    .th-color-tag {
      border: 0.125rem solid ${colors.neutral.SpanishGray};
      border-radius: 50%;
      display: block;
      width: 16px;
      height: 16px;
    }

    td {
      padding: .5rem 1.25rem;
    }
  }

  .vuetable-pagination {
    padding: 0.5rem 0;
  }

  .custom-actions {
    text-align: right;
  }

  #nprogress {
    .bar {
      background: ${colors.secondary.danger};
    }

    .peg {
      box-shadow: none;
    }
  }

  .color-danger {
    color: ${colors.secondary.danger};
    &:hover {
      color: ${darken(colors.secondary.danger, 20)};
    }
  }

  input,
  textarea {
    outline: none;
  }

  .bold {
    font-weight: 600;
  }

  .capitalize {
    text-transform: capitalize;
  }

  .v-popper{

    &--theme-tooltip {
      font-size: 12px;
    }
  }
`;

const router = new VueRouter({
    mode: "history",
    routes
});

const enableRegistration = document.getElementById('enableRegistration').value == 1 ? true : false;

new Vue({
    el: "#app",
    components: { AdminApp },
    router,
    data() {
      return {
        enableRegistration
      }
    }
});
