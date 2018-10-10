<template>
	<div class="panel" v-if="show">
		<div class="panel-heading">
			<span class="panel-title">AUTOR: {{proyecto.user.name}}</span>
			<div v-if="authState.api_token && authState.user_id === proyecto.user_id" class="recipe__foot">
				<router-link to="/proyectos" class="btn">Back</router-link>
				<router-link :to="`/proyectos/${proyecto.id}/edit`" class="btn btn__primary">Edit</router-link>
				<button class="btn btn__danger" @click="deleteItem">Delete</button>
			</div>
		</div>

		<div class="recipe__header">
			<div class="recipe__box">
				<div class="recipe__row">
					<div class="form__group recipe__eight">
						<label>Proyecto</label>
						<h4 class="recipe__title">{{proyecto.name}}</h4>
					</div>
					<div class="form__group recipe__three">
						<label>Ubicacion</label>
						<p>{{proyecto.ubicacion}}</p>
					</div>
					<div class="form__group recipe__one">
						<label>Distancia</label>
						<p>{{proyecto.distancia}}</p>
					</div>
				</div>
				<div class="recipe__row">
					<div class="form__group recipe__eight">
						<label>Contratante</label>
						<p>{{proyecto.contratante}}</p>
					</div>
					<div class="form__group recipe__two">
						<label>Presentacion</label>
						<p>{{proyecto.entrega}}</p>
					</div>
					<div class="form__group recipe__one">
						<label>Forma</label>
						<p>{{proyecto.formato}}</p>
					</div>
					<div class="form__group recipe__one">
						<label>Decimales</label>
						<p>{{proyecto.precision}}</p>
					</div>
				</div>
				<div class="recipe__row">
					<div class="form__group recipe__four">
						<label>Oferente</label>
						<p>{{proyecto.oferente}}</p>
					</div>
					<div class="form__group recipe__four">
						<label>Representante</label>
						<p>{{proyecto.representante}}</p>
					</div>
                    <div class="form__group recipe__two">
                        <label>Referencial</label>
                        <p>{{proyecto.referencial}}</p>
                    </div>
					<div class="form__group recipe__one">
						<label>Indirectos</label>
						<p>{{proyecto.indirecto}}</p>
					</div>
					<div class="form__group recipe__one">
						<label>IVA %</label>
						<p>{{proyecto.descuento}}</p>
					</div>
				</div>
				<br>
				<table class="recipe__box">
					<caption>TABLA DE DESCRIPCION DE RUBROS, UNIDADES, CANTIDADES Y PRECIOS</caption>
					<thead>
						<tr>
							<th class="recipe__one">Id</th>
							<th class="recipe__one">Rubro Nº</th>
							<th class="recipe__six">Descripcion</th>
							<th class="recipe__one">Unidad</th>
							<th class="recipe__one">Cantidad</th>
							<th class="recipe__one">Precio</th>
							<th class="recipe__one">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="rubro in proyecto.rubros" :key="rubro.id">
							<td>{{rubro.precio_id}}</td>
							<td>{{rubro.orden}}</td>
							<td>{{rubro.rubro}}</td>
							<td>{{rubro.unidad}}</td>
							<td class="right">{{rubro.cantidad}}</td>
							<td class="right">{{rubro.precio}}</td>
							<td class="right">{{rubro.cantidad * rubro.precio}}</td>
						</tr>
					</tbody>

					<tfoot>
						<tr>
							<td colspan="5"></td>
							<td> Subtotal</td>
							<td class="right">{{ proyecto.sub_total }}</td>
						</tr>
						<tr>
							<td colspan="5"></td>
							<td>IVA %</td>
							<td class="right">{{ proyecto.descuento }}</td>
						</tr>
						<tr>
							<td colspan="5"></td>
							<td>Total</td>
							<td class="right">{{ proyecto.gran_total }}</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
	import Auth from '../../store/auth'
	import Flash from '../../helpers/flash'
	import { get, byMethod } from '../../helpers/api'

	export default {
		data() {
			return {
			    show: false,
				authState: Auth.state,
				proyecto: {
					rubros: [],
                    user: {}
				}
			}
		},
        beforeRouteEnter(to, from, next) {
            get(`/api/proyectos/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/proyectos/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'proyecto', res.data.proyecto)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/proyectos/${this.proyecto.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/proyectos')
                        }
                    })
            }
        }
	}
</script>