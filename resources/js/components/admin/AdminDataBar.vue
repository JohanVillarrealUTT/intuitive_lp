<template>
    <wide-section>
        <div class="container">
            <welcome>
                <b>{{ welcomeMsg }}</b>
                <br>Información de
                <b>{{ total }} aspirantes</b> registrados a la campaña.
            </welcome>
        </div>
    </wide-section>
</template>

<script>
import styled from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import EventService from '@/services/AdminEventService.js'
import { EventBus } from '@/event-bus.js'

const Welcome = styled('div')`
    color: #fff;
    grid-column: 1 / -1;
    padding: 2.5rem 0;
`
const WideSection = styled('div')`
    background-color: ${colors.secondary.StPatricksBlue};
`

export default {
    components: {
        Welcome,
        WideSection
    },
    data() {
        return {
            welcomeMsg: '',
            total: ''
        }
    },
    mounted() {
        let _this = this

        const today = new Date()
        const curHr = today.getHours()
        this.welcomeMsg = '¡Hola $w!'

        if (curHr < 12) {
            this.welcomeMsg = this.welcomeMsg.replace('$w', 'buenos días')
        } else if (curHr < 18) {
            this.welcomeMsg = this.welcomeMsg.replace('$w', 'buenas tardes')
        } else {
            this.welcomeMsg = this.welcomeMsg.replace('$w', 'buenas noches')
        }

        this.getTotal()

        EventBus.$on('deleted-applicant', function() {
            _this.getTotal()
        })
    },

    methods: {
        getTotal() {
            let _this = this

            let total = EventService.getTotal().then(r => {
                _this.total = r.data.total
            })
        }
    }
}
</script>