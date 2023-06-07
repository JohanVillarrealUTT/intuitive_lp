import axios from "axios";
import NProgress from "nprogress";

NProgress.configure({ showSpinner: false });

const apiClient = axios.create({
    baseURL: "/",
    withCredentials: false, // This is the default
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "api-key": process.env.MIX_API_KEY
    }
});

apiClient.interceptors.request.use(config => {
    NProgress.start();
    return config;
});
apiClient.interceptors.response.use(response => {
    NProgress.done();
    return response;
});

apiClient.interceptors.response.use(response => {
    NProgress.done();
    return response;
}, error => {
    // Do something with response error
    NProgress.done();
    return Promise.reject(error);
});

export default {
    // Subscribe
    postSubscription(data) {
        return apiClient.post(`api/v1/subscribe`, data);
    },
    // Vacancy Subscribe
    postVacancySubscription(data) {
        return apiClient.post(`api/v1/vacancy-subscribe`, data);
    },
    postAppointment(data) {
        return apiClient.post(`api/v1/store-appointment`, data);
    },
    loadAppointments() {
        return apiClient.get(`api/v1/available-appointments`);
    },
    loadSelectAppointments() {
        return apiClient.get(`api/v1/available-appointments-list`);
    },
    getAppointment(keyword) {
        return apiClient.get(`api/v1/search-appointments/${keyword}`);
    },
    updateAppointment(subscriber_id, appointment_hour_id) {
        return apiClient.post(`api/v1/change-appointment`, {
            subscriber_id,
            appointment_hour_id
        });
    }
};
