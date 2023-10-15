import { createWebHistory, createRouter } from "vue-router";

const routes =  [
    {
        path: "/manufacturers",
        name: "manufacturers",
        component: () => import("./components/manufacturers/List.vue")
    },
    {
        path: "/manufacturers/models",
        name: "all-models",
        component: () => import("./components/models/List.vue")
    },
    {
        path: "/manufacturers/add",
        name: "add-manufacturer",
        component: () => import("./components/manufacturers/Add.vue")
    },
    {
        path: "/manufacturers/:id",
        name: "show-manufacturer",
        component: () => import("./components/manufacturers/Show.vue"),
        children: [
            {
                path: "models/add",
                name: "add-model",
                component: () => import("./components/models/Add.vue")
            },
            {
                path: "models/:model",
                name: "show-model",
                component: () => import("./components/models/Show.vue")
            },
            {
                path: "models/:model",
                name: "edit-model",
                component: () => import("./components/models/Edit.vue")
            }
        ]
    },
    {
        path: "/manufacturers/:id",
        name: "edit-manufacturer",
        component: () => import("./components/manufacturers/Edit.vue")
    },
    {
        path: "/",
        alias: "/transports",
        name: "transports",
        component: () => import("./components/transports/List.vue")
    },
    {
        path: "/transports/add",
        name: "add-transport",
        component: () => import("./components/transports/Add.vue")
    },
    {
        path: "/transports/:id",
        name: "show-transport",
        component: () => import("./components/transports/Show.vue")
    },
    {
        path: "/transports/:id",
        name: "edit-transport",
        component: () => import("./components/transports/Edit.vue")
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
