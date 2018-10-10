import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../views/Auth/Login.vue'
import Register from '../views/Auth/Register.vue'

import PostIndex from '../views/Post/Index.vue'
import PostShow from '../views/Post/Show.vue'
import PostForm from '../views/Post/Form.vue'

import EquipoIndex from '../views/Data/Equipo/Index.vue'
import EquipoForm from '../views/Data/Equipo/Form.vue'

import MaterialIndex from '../views/Data/Material/Index.vue'
import MaterialForm from '../views/Data/Material/Form.vue'

import ObreroIndex from '../views/Data/Obrero/Index.vue'
import ObreroForm from '../views/Data/Obrero/Form.vue'

import TransporteIndex from '../views/Data/Transporte/Index.vue'
import TransporteForm from '../views/Data/Transporte/Form.vue'


import PrecioIndex from '../views/Precio/Index.vue'
import PrecioShow from '../views/Precio/Show.vue'
import PrecioForm from '../views/Precio/Form.vue'

import ProyectoIndex from '../views/Proyecto/Index.vue'
import ProyectoShow from '../views/Proyecto/Show.vue'
import ProyectoForm from '../views/Proyecto/Form.vue'

import NotFound from '../views/NotFound.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [

        { path: '/', component: PostIndex},
        { path: '/posts/create', component: PostForm, meta: { mode: 'create' }},
        { path: '/posts/:id/edit', component: PostForm, meta: { mode: 'edit' }},
        { path: '/posts/:id', component: PostShow },

        { path: '/equipos', component: EquipoIndex},
        { path: '/equipos/create', component: EquipoForm, meta: { mode: 'create' }},
        { path: '/equipos/:id/edit', component: EquipoForm, meta: { mode: 'edit' }},


        { path: '/materials', component: MaterialIndex},
        { path: '/materials/create', component: MaterialForm, meta: { mode: 'create' }},
        { path: '/materials/:id/edit', component: MaterialForm, meta: { mode: 'edit' }},


        { path: '/obreros', component: ObreroIndex},
        { path: '/obreros/create', component: ObreroForm, meta: { mode: 'create' }},
        { path: '/obreros/:id/edit', component: ObreroForm, meta: { mode: 'edit' }},

        { path: '/transportes', component: TransporteIndex},
        { path: '/transportes/create', component: TransporteForm, meta: { mode: 'create' }},
        { path: '/transportes/:id/edit', component: TransporteForm, meta: { mode: 'edit' }},

        { path: '/precios', component: PrecioIndex},
        { path: '/precios/create', component: PrecioForm, meta: { mode: 'create' }},
        { path: '/precios/:id/edit', component: PrecioForm, meta: { mode: 'edit' }},
        { path: '/precios/:id', component: PrecioShow},

        { path: '/proyectos', component: ProyectoIndex},
        { path: '/proyectos/create', component: ProyectoForm},
        { path: '/proyectos/:id/edit', component: ProyectoForm, meta: { mode: 'edit' }},
        { path: '/proyectos/:id', component: ProyectoShow},

        { path: '/login', component: Login },
        { path: '/register', component: Register },
        { path: '/not-found', component: NotFound },
        { path: '*', component: NotFound }

    ]
})

export default router