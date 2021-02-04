import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    {
        path: '/empleado/spa/bienvenida',
        name: 'Bienvenido',
        component: () => import('./components/Bienvenido.vue'),
        meta: { title: 'Bienvenidos | InteloPack' }
    },
    {
        path: '/empleado/spa/paquete_repartidor',
        name: 'RepartidorPaquete',
        component: () => import('./components/PaqueteRepartidor.vue'),
        meta: { title: 'Paquete Repartidor | InteloPack' }
    },
    {
        path: '/empleado/spa/entrega_paquete',
        name: 'EntregaPaquete',
        component: () => import('./components/EntregaPaquete.vue'),
        meta: { title: 'Entrega de Paquete | InteloPack' }
    },
]

const router = new VueRouter({
    mode: 'history', routes
})

router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title ? to.meta.title : 'default title';
    });
})

export default router