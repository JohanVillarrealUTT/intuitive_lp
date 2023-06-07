import moment from 'moment';
import services from '@/services/WebsiteServices.js';
import AdminService from '@/services/AdminEventService.js';

moment.locale("es");

export default {
	data() {
		return {
			state: {
				sending: false,
				sent: false,
				datesLodaded: false,
			},
			availableDates: [],
			selectedDate: null,
			selectedSchedule: null,
		}
	},
	filters: {
		formatDate(date, fmt = 'ddd DD MMM YYYY') {
			let fdate = moment(date).format(fmt);
			return fdate.charAt(0).toUpperCase() + fdate.slice(1)
		}
	},
	methods: {
		onSelectDate(date) {
			this.selectedDate = date;
			this.selectedSchedule = null;
		},
		loadAppointments() {
			return services.loadAppointments()
		},
		loadAdminAppointments() {
			return AdminService.loadAppointments()
		},
		loadDates() {
			this.state.datesLodaded = false;
			this.loadAppointments()
				.then(r => {
					this.availableDates = r.data.data;
					this.state.datesLodaded = true;
				})
				.catch(e => {
					alert('Ocurrió un error: ' + e.message)
				})
		},
		loadAdminDates() {
			this.state.datesLodaded = false;
			this.loadAdminAppointments()
				.then(r => {
					this.availableDates = r.data.data;
					this.state.datesLodaded = true;
				})
				.catch(e => {
					alert('Ocurrió un error: ' + e.message)
				})
		},
	}
}