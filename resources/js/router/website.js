import Index from '@/components/website/pages/IndexPage.vue';
import Landing from '@/components/website/pages/LandingPage.vue';
import LandingTechnicians from '@/components/website/pages/LandingPageTechnicians.vue';
import Appointment from '@/components/website/pages/AppointmentPage.vue';
// import AdminDashPage from '@/components/admin/pages/AdminDashPage.vue';


export const routes = [
    {
    	path: '/',
    	component: Index,
    	name: 'index'
    },
    {
    	path: '/tecnico-ensamble-especializado',
    	component: Landing,
    	name: 'tecnico-ensamble-especializado'
    },
    {
    	path: '/vacantes-indirectas',
    	component: LandingTechnicians,
    	name: 'vacantes-indirectas'
    },
    {
    	path: '/citas/:creating?',
    	component: Appointment,
    	name: 'update-appointment'
    }
];
