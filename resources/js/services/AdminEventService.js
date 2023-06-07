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
    },
    data: {}
});

apiClient.interceptors.request.use(config => {
    NProgress.start();
    return config;
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
    // Subscriber

    getSubscriber(id) {
        return apiClient.get(`/api/v1/subscriber/${id}`);
    },
    getTotal() {
        return apiClient.get(`/api/v1/subscriber/get-total`);
    },
    putSubscriberRejected(id, rejected) {
        return apiClient.put(`/api/v1/subscriber/${id}`, {
            rejected: rejected
        });
    },
    putSubscriberLabelId(id, label_id) {
        return apiClient.put(`/api/v1/subscriber/${id}`, {
            label_id
        });
    },
    putSubscriberCandidate(id, candidate) {
        return apiClient.put(`/api/v1/subscriber/${id}`, {
            candidate: candidate
        });
    },
    getSubscriberColorTagsTotals(params) {
        return apiClient.get("/api/v1/subscriber/get-color-tags-totals", {
            params: params
        });
    },
    deleteSubscriber(id) {
        return apiClient.delete(`/api/v1/subscriber/${id}`);
    },
    getSubscriberByPhone(phone) {
        return apiClient.get(`/api/v1/subscriber/get-by-phone`, {
            params: {
                cell_phone: phone
            }
        });
    },
    rejectSubscriber({id, rejection_reason}) {
        return apiClient.put(`/api/v1/subscriber/${id}`, {
            rejected: true,
            rejection_reason
        });
    },

    // Comment

    postComment(comment) {
        return apiClient.post("/api/v1/comment", comment);
    },
    putComment(commentId, comment) {
        return apiClient.put(`/api/v1/comment/${commentId}`, comment);
    },

    // User
    getUser(id) {
        return apiClient.get(`/api/v1/user/${id}`);
    },
    postUser(user) {
        return apiClient.post("/api/v1/user/", user);
    },
    putUser(id, user) {
        return apiClient.put(`/api/v1/user/${id}`, user);
    },
    deleteUser(id) {
        return apiClient.delete(`/api/v1/user/${id}`);
    },

    // AppointmentDate
    loadAppointments() {
        return apiClient.get(`api/v1/admin/available-appointments`);
    },
    postAppointmentDate(data) {
        return apiClient.post("/api/v1/appointment-dates", data);
    },
    updateAppointmentDate(id, data) {
        return apiClient.put(`/api/v1/appointment-dates/${id}`, data);
    },
    deleteAppointment(id) {
        return apiClient.delete(`api/v1/appointment-dates/${id}`);
    },


     // Labels
    loadAllLabels() {
        return apiClient.get("/api/v1/label");
    },
    postLabel(data) {
        return apiClient.post("/api/v1/label", data);
    },
    updateLabel(id, data) {
        return apiClient.put(`/api/v1/label/${id}`, data);
    },
    deleteLabel(id) {
        return apiClient.delete(`api/v1/label/${id}`);
    },

    //LandingPage
    postSubscription(subscriptionData) {
        return apiClient.post(`/api/v1/subscribe`, subscriptionData);
    },

    //app config
    putAppConfig(data) {
        return apiClient.put(`/api/v1/admin/configs`, data);
    },

    putAppointment(id, data) {
        return apiClient.put(`/api/v1/admin/appointment/${id}`, data);
    }
};
