<template>
   <div>
	   	<top-bar>
            <div class="header-menu">
    	   		<a href="/">
                    <img class="header-logo" src="/images/brand-logo.png">
                </a>
                <a href="/admin">Registros</a>
                <a href="/admin/fechas">Fechas</a>
                <a href="/admin/etiquetas">Etiquetas</a>
            </div>
            <a href="/logout">Cerrar sesión</a>
	   	</top-bar>
        <c-top-bar>
            <div class="container">
                <div>
                    Registro {{ enableRegistration ? 'activo' : 'inactivo' }}
                </div>
                <div>
                    <c-switch
                        :data-id="1"
                        id="registration-status"
                        name="registration-status"
                        v-model="enableRegistration"
                        @toggle-switch="onToggleRegistrationActveSwitch"></c-switch>
                </div>
            </div>
        </c-top-bar>
       <router-view></router-view>
   </div>
</template>

<script>
	import TopBar from '@/components/admin/AdminTopBar.vue'
    import CSwitch from '@/components/admin/CustomSwitch.vue'
    import styled from 'vue-emotion';
    import EventService from '@/services/AdminEventService.js'

    const CTopBar = styled('div')`
        border-bottom: solid 1px #eee;
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .2rem 1rem;
        }
    `

    export default {
        name:'AdminApp',
        components: {
        	TopBar,
            CTopBar,
            CSwitch,
        },
        data() {
            return {
                enableRegistration: false
            }
        },
        mounted() {
            this.enableRegistration = this.$root.enableRegistration;
        },
        methods: {
            onToggleRegistrationActveSwitch($event) {
                let confirmation = confirm('¿Desea modificar el estatus del registro?' + '\n El registro se ' + (this.enableRegistration ? 'activará' : 'desactivará'));

                if (!confirmation) {
                    setTimeout(() => {
                        this.enableRegistration = !this.enableRegistration
                    }, 100)
                    return false
                }
                
                EventService.putAppConfig({enable_registration: this.enableRegistration})
                    .then(r => {
                        console.log(r.data.data)
                    })
                    .catch(e => {
                        alert('Ocurrió un error. Intente de nuevo más tarde.')
                            setTimeout(() => {
                                this.enableRegistration = !this.enableRegistration
                            }, 100)
                    })
            }
        }
    }
</script>
