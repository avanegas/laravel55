<template>
	<div class="recipe__show">
		<div class="recipe__header">
			<h3>{{action}} Equipo</h3>
			<div>
				<button class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
        		<template v-if="action == 'Update'">
            		<button class="btn btn__danger" @click.prevent="remove(form)" :disabled="isProcessing">Eliminar</button>
        		</template>
				<button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
			</div>
		</div>

		<div class="recipe__details">
			<div class="recipe__box">
				<div class="form__group">
					<label>Grupo de equipo</label>
					<select :id="form.grupo_equipo_id" :name="form.grupo_equipo_id" class="form__control" v-model="form.grupo_equipo_id">
						<option disabled value="">seleccione</option>
						<option v-for="ge in grupo_equipos" :value="ge.id" selected = " form.grupo_equipo_id == ge.id ? true : false ">{{ ge.name }}</option>
					</select>
				</div>
				<div class="form__group">
				    <label>Name</label>
				    <input type="text" class="form__control" v-model="form.name">
				    <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
				</div>
				<div class="form__group">
				    <label>Marca</label>
				    <input type="text" class="form__control" v-model="form.marca">
				    <small class="error__control" v-if="error.marca">{{error.marca[0]}}</small>
				</div>
				<div class="form__group">
				    <label>Tipo</label>
				    <input type="text" class="form__control" v-model="form.tipo">
				    <small class="error__control" v-if="error.tipo">{{error.tipo[0]}}</small>
				</div>
				<div class="form__group">
				    <label>Tarifa</label>
				    <input type="number" step="any" class="form__control" v-model="form.tarifa">
				    <small class="error__control" v-if="error.tarifa">{{error.tarifa[0]}}</small>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Vue from 'vue'
	import Flash from '../../../helpers/flash'
	import { get, post, del } from '../../../helpers/api'
	import { toMulipartedForm } from '../../../helpers/form'
	import ImageUpload from '../../../components/ImageUpload.vue'
	
	export default {
		components: {
			ImageUpload
		},
		data() {
			return {
				grupo_equipos:[],

				form: {},
				error: {},
				isProcessing: false,
				initializeURL: `/api/equipos/create`,
				storeURL: `/api/equipos`,
				action: 'Create'
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeURL = `/api/equipos/${this.$route.params.id}/edit`
				this.storeURL = `/api/equipos/${this.$route.params.id}?_method=PUT`
				this.action = 'Update'
			}
			get(this.initializeURL)
				.then((res) => {
					Vue.set(this.$data, 'form', res.data.form)
				}),
			get(`/api/grupo_equipos`)
				.then((res) => {
					this.grupo_equipos = res.data.grupo_equipos
				})
		},
		methods: {
			save() {
				const form = toMulipartedForm(this.form, this.$route.meta.mode)
				post(this.storeURL, form)
				    .then((res) => {
				        if(res.data.saved) {
				            Flash.setSuccess(res.data.message)
				            this.$router.push(`/equipos`)
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
			remove() {
				del(`/api/equipos/${this.$route.params.id}`).then((res) => {
					Flash.setSuccess('Ha eliminado correctamente el equipo!')
					this.$router.back()
				});
      		}
		}
	}
</script>
