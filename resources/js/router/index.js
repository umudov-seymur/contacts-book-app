import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const home = () => import("../components/ExampleComponent.vue");
const NotFound = () => import("../views/NotFound.vue");

const ContactsIndex = () => import("../views/contacts/ContactsIndex.vue");
const ContactsDetail = () => import("../views/contacts/ContactsShow.vue");
const ContactsCreate = () => import("../views/contacts/ContactsCreate.vue");
const ContactsEdit = () => import("../views/contacts/ContactsEdit.vue");

const BirthdaysIndex = () => import("../views/BirthdaysIndex");

export const router = new VueRouter({
    base: "/",
    mode: "history",
    routes: [
        {
            path: "/",
            component: home,
            name: "home",
            meta: { title: "Welcome" }
        },
        {
            path: "/contacts",
            name: "contacts.index",
            component: ContactsIndex,
            meta: { title: "Contacts" }
        },
        {
            path: "/contacts/create",
            name: "contacts.create",
            component: ContactsCreate,
            meta: { title: "Add New Contact" }
        },
        {
            path: "/contacts/:id",
            name: "contacts.show",
            component: ContactsDetail,
            meta: { title: "Details for Contact" }
        },
        {
            path: "/contacts/:id/edit",
            name: "contacts.update",
            component: ContactsEdit,
            meta: { title: "Edit Contact" }
        }, {
            path: "/birthdays",
            name: "birthdays.index",
            component: BirthdaysIndex,
            meta: { title: "Birthdays" }
        },
        {
            path: "/logout",
            name: "logout",
            component: () => import("../Actions/Logout.vue")
        },
        {
            path: "*",
            name: "404",
            component: NotFound,
            meta: { title: "404" }
        },
    ]
});
