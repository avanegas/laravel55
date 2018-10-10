<template>
    <div class="panel">
        <div class="panel-heading">
            <router-link to="/equipos/create" class="panel-title" title="Nuevo Equipo">
                Equipos
            </router-link>
            <div>
                Search
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Tarifa</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                    <td class="w-1">{{item.grupo_equipo.name}}</td>
                    <td class="w-6">{{item.name}}</td>
                    <td class="w-6">{{item.marca}}</td>
                    <td class="w-3">{{item.tipo}}</td>
                    <td class="w-3">{{item.tarifa | formatMoney}}</td>
                    <td class="w-3">{{item.created_at}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="panel-footer flex-between">
            <div>
                <small>Mostrando {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Anterior
                </button>
                <button class="btn btn-sm" :disabled="!model.next_page_url" @click="nextPage">
                    Siguiente
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">

    import Vue from 'vue'
    import { get } from '../../../helpers/api'
    export default {
        data() {
            return {
                model: {
                    data: []
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/equipos', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/equipos', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            detailsPage(item) {
                this.$router.push(`/equipos/${item.id}/edit`)
            },
            setData(res) {
                Vue.set(this.$data, 'model', res.data.results)
                this.page = this.model.current_page
                this.$bar.finish()
            },
            nextPage() {
                if (this.model.next_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) + 1) : 2

                    this.$router.push({
                        path: '/equipos',
                        query: query
                    })
                }
            },
            prevPage() {
                if (this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1

                    this.$router.push({
                        path: '/equipos',
                        query: query
                    })
                }
            }
        }
    }
</script>