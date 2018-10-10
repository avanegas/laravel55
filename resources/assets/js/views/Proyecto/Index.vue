<template>
	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title">Proyectos</span>
			<div>
				<router-link to="/proyectos/create" class="btn btn__primary">
					Nuevo Proyecto
				</router-link>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-link">
				<thead>
				<tr>
					<th>ID</th>
					<th>Usuario</th>
					<th>Proyecto</th>
					<th>Contratante</th>
					<th>Entrega</th>
					<th>Total</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
					<td class="w-1">{{item.id}}</td>
					<td class="w-3">{{item.user_id}}</td>
					<td class="w-6">{{item.name}}</td>
					<td class="w-6">{{item.contratante}}</td>
					<td class="w-3">{{item.entrega}}</td>
					<td class="w-3">{{item.gran_total | formatMoney}}</td>
				</tr>
				</tbody>
			</table>
		</div>

        <div class="panel-footer flex-between">
            <div>
                <small>Mostrando {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn__sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Anterior
                </button>
                <button class="btn btn__sm" :disabled="!model.next_page_url" @click="nextPage">
                    Siguiente
                </button>
            </div>
        </div>
	</div>
</template>

<script type="text/javascript">
    import Vue from 'vue'
	import { get } from '../../helpers/api'
	export default {
		data() {
			return {
			    model: {
                    data: []
                }
			}
		},
        beforeRouteEnter(to, from, next) {
            get('/api/proyectos', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/proyectos', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            detailsPage(item) {
                this.$router.push(`/proyectos/${item.id}`)
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
                        path: '/proyectos',
                        query: query
                    })
                }
            },
            prevPage() {
                if (this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1

                    this.$router.push({
                        path: '/proyectos',
                        query: query
                    })
                }
            }
        }
	}
</script>