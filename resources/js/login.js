import Vue from 'vue'
import VeeValidate from 'vee-validate'
import { injectGlobal } from 'vue-emotion'
import TopBar from '@/components/admin/AdminTopBar.vue'
import AdminFooter from '@/components/admin/AdminFooter.vue'
import colors from '@/config/admin/AdminColors.js'
import vars from '@/config/admin/AdminVariables.js'
import { darken } from '@/components/helpers/LightenDarkenColor'
import VueMask from 'v-mask'
import VInput from '@/components/admin/FormField.vue'
import VButton from '@/components/admin/ButtonPrimary.vue'


Vue.use(VeeValidate, { fieldsBagName: 'veeFields' })
Vue.use(VueMask)

Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true


const maxWidth = '81rem'

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
      padding: 0.25rem 1.25rem;
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
`

const app = new Vue({
  el: '#app',
  components: {
    TopBar,
    AdminFooter,
    VInput,
    VButton    
  }
}).$mount('#app')
