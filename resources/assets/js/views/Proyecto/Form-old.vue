<template>
	<div class="recipe__show">
		<div class="recipe__header">
			<h3>{{action}} Proyecto</h3>
			<div>
				<button class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
				<button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
			</div>

		</div>
		<div class="recipe__header">

			<div class="recipe__box">
				<div class="recipe__row">
					<div class="form__group recipe__eight">
					    <label>Proyecto</label>
					    <input type="text" class="form__control" v-model="form.name">
					    <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
					</div>
					<div class="form__group recipe__three">
					    <label>Ubicación</label>
					    <input type="text" class="form__control" v-model="form.ubicacion">
					    <small class="error__control" v-if="error.ubicacion">{{error.ubicacion[0]}}</small>
					</div>
					<div class="form__group recipe__one">
					    <label>Distancia</label>
					    <input type="text" class="form__control" v-model="form.distancia">
					    <small class="error__control" v-if="error.distancia">{{error.distancia[0]}}</small>
					</div>
				</div>
				<div class="recipe__row">
					<div class="form__group recipe__eight">
					    <label>Contratante</label>
					    <input type="text" class="form__control" v-model="form.contratante">
					    <small class="error__control" v-if="error.contratante">{{error.contratante[0]}}</small>
					</div>
					<div class="form__group recipe__two">
					    <label>Presentacion</label>
					    <input type="date" class="form__control" v-model="form.entrega">
					    <small class="error__control" v-if="error.entrega">{{error.entrega[0]}}</small>
					</div>
					<div class="form__group recipe__one">
					    <label>Forma</label>
					    <input type="text" class="form__control" v-model="form.formato">
					    <small class="error__control" v-if="error.formato">{{error.formato[0]}}</small>
					</div>
					<div class="form__group recipe__one">
					    <label>Punto</label>
					    <input type="text" class="form__control" v-model="form.precision">
					    <small class="error__control" v-if="error.precision">{{error.precision[0]}}</small>
					</div>
				</div>
				<div class="recipe__row">
					<div class="form__group recipe__four">
					    <label>Oferente</label>
					    <input type="text" class="form__control" v-model="form.oferente">
					    <small class="error__control" v-if="error.oferente">{{error.oferente[0]}}</small>
					</div>
					<div class="form__group recipe__four">
					    <label>Representante</label>
					    <input type="text" class="form__control" v-model="form.representante">
					    <small class="error__control" v-if="error.representante">{{error.representante[0]}}</small>
					</div>
					<div class="form__group recipe__two">
					    <label>Indirectos</label>
					    <input type="text" class="form__control" v-model="form.indirecto">
					    <small class="error__control" v-if="error.indirecto">{{error.indirecto[0]}}</small>
					</div>
					<div class="form__group recipe__two">
					    <label>Referencial</label>
					    <input type="text" class="form__control" v-model="form.referencial">
					    <small class="error__control" v-if="error.referencial">{{error.referencial[0]}}</small>
					</div>
				</div>
				<div class="proyecto__body">
					<table>
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
								<th class="recipe__cero">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(rubro, index) in form.rubros">
								<td>
									<typeahead :url="precioURL" :initialize="rubro.precio_id"
											   @input="onPrecio(index, $event)" />
									<small class="error-control" v-if="error[`rubros.${index}.precio_id`]">
										{{error[`rubros.${index}.precio_id`][0]}}
									</small>
								</td>

								<td><input type="text" class="form__control" v-model="rubro.orden"
									:class="[error[`rubros.${index}.orden`] ? 'error__bg' : '']"></td>
								<td><input type="text" class="form__control" v-model="rubro.rubro"
									:class="[error[`rubros.${index}.rubro`] ? 'error__bg' : '']"></td>
								<td><input type="text" class="form__control" v-model="rubro.unidad"
									:class="[error[`rubros.${index}.unidad`] ? 'error__bg' : '']"></td>
								<td><input type="text" class="form__control right" v-model="rubro.cantidad"
									:class="[error[`rubros.${index}.cantidad`] ? 'error__bg' : '']"></td>
								<td><input type="text" class="form__control right" v-model="rubro.precio"
									:class="[error[`rubros.${index}.precio`] ? 'error__bg' : '']"></td>
								<td class="right">{{rubro.cantidad * rubro.precio}}</td>
								<td>
									<button @click="remove('rubros', index)" class="btn btn__danger">&times;</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5"><button class="btn btn__success" @click="addRubro">Add Rubro</button></td>
								<td>SubTotal</td>
								<td class="right">{{ sub_total }}</td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td>Descuento</td>
								<td>
									<input type="text" class="form__control right" v-model="form.descuento">
									<small class="error__control" v-if="error.descuento">{{error.descuento[0]}}</small>
								</td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td>Total</td>
								<td class="right">{{ gran_total }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Vue from 'vue'
	import Flash from '../../helpers/flash'
	import { get, post } from '../../helpers/api'
	import { toMulipartedForm } from '../../helpers/form'
	import ImageUpload from '../../components/ImageUpload.vue'
    import {getParams, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'

    function initialize(to) {
        let urls = {
            'create': `/api/precios/create`,
            'edit': `/api/precios/${to.params.id}/edit`
        }

        return (urls[to.meta.mode] || urls['create'])
    }

	export default {
		components: {
			Typeahead
		},
		data() {
			return {
				form: {
					rubros: []
				},
				error: {},
				isProcessing: false,
				show:false,
				initializeURL: `/api/proyectos/create`,
				storeURL: `/api/proyectos`,
				action: 'Create',
                precioURL: `/api/precios`
			}
		},
        beforeRouteEnter(to, from, next) {
            getParams(initialize(to))
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            getParams(initialize(to))
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeURL = `/api/proyectos/${this.$route.params.id}/edit`
				this.storeURL = `/api/proyectos/${this.$route.params.id}?_method=PUT`
				this.action = 'Update'
			}
			get(this.initializeURL)
				.then((res) => {
					Vue.set(this.$data, 'form', res.data.form)
				})
		},
		computed: {
		    sub_total: function() {
		      return this.form.rubros.reduce((carry, rubro)=> {
		        return carry + (parseFloat(rubro.cantidad) * parseFloat(rubro.precio));
		      }, 0);
		    },
		    gran_total: function() {
		      return this.sub_total - parseFloat(this.form.descuento);
		    }
		  },
		methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.form)

                if(this.$route.meta.mode === 'edit') {
                    this.store = `/api/invoices/${this.$route.params.id}`
                    this.method = 'PUT'
                    this.title = 'Edit'
                }

                //this.show = true
                //this.$bar.finish()
            },
			save() {
				const form = toMulipartedForm(this.form, this.$route.meta.mode)
				post(this.storeURL, form)
				    .then((res) => {
				        if(res.data.saved) {
				            Flash.setSuccess(res.data.message)
				            this.$router.push(`/proyectos/${res.data.id}`)
				        }
				        this.isProcessing = false
				    })
				    .catch((err) => {
				        if(err.response.status === 422) {
				            this.error = err.response.data
				        }
				        this.isProcessing = false
				    })
			},
			addRubro() {
				this.form.rubros.push({
					precio_id: '',
					orden: '',
					rubro: '',
					unidad: '',
					cantidad: '',
					precio: '',
					total: ''
				})
			},
			remove(type, index) {
				if(this.form[type].length > 1) {
					this.form[type].splice(index, 1)
				}
			}
		}
	}
</script>