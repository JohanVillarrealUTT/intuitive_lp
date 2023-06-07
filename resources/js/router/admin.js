import AdminSubscribers from "@/components/admin/pages/AdminSubscribers.vue";
import AdminAppointmentDates from "@/components/admin/pages/AdminAppointmentDates.vue";
import AdminLabels from "@/components/admin/pages/AdminLabels.vue";

export const routes = [
    {
        path: "/admin",
        component: AdminSubscribers,
        name: "admin"
    },
    {
        path: "/admin/fechas",
        component: AdminAppointmentDates,
        name: "fechas"
    },
    {
        path: "/admin/etiquetas",
        component: AdminLabels,
        name: "etiquetas"
    }
];
