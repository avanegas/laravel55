<template>
	<div class="recipe__show">
		<div class="recipe__header">
			<h3>{{action}} Material</h3>
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
					<label>Grupo de material</label>
					<select :id="form.grupo_material_id" :name="form.grupo_material_id" class="form__control" v-model="form.grupo_material_id">
						<option disabled value="">seleccione</option>
						<option v-for="gm in grupo_materials" :value="gm.id" selected = " form.grupo_material_id == gm.id ? true : false ">{{ gm.name }}</option>
					</select>
				</div>
				<div class="form__group">
				    <label>Name</label>
				    <input type="text" class="form__control" v-model="form.name">
				    <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
				</div>
				<div class="form__group">
				    <label>Unidad</label>
				    <input type="text" class="form__control" v-model="form.unidad">
				    <small class="error__control" v-if="error.unidad">{{error.unidad[0]}}</small>
				</div>
				<div class="form__group">
				    <label>Precio</label>
				    <input type="number" step="any" class="form__control" v-model="form.precio">
				    <small class="error__control" v-if="error.precio">{{error.precio[0]}}</small>
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
				grupo_materials:[],

				form: {},
				error: {},
				isProcessing: false,
				initializeURL: `/api/materials/create`,
				storeURL: `/api/materials`,
				action: 'Create'
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeURL = `/api/materials/${this.$route.params.id}/edit`
				this.storeURL = `/api/materials/${this.$route.params.id}?_method=PUT`
				this.action = 'Update'
			}
			get(this.initializeURL)
				.then((res) => {
					Vue.set(this.$data, 'form', res.data.form)
				}),
			get(`/api/grupo_materials`)
				.then((res) => {
					this.grupo_materials = res.data.grupo_materials
				})
		},
		methods: {
			save() {
				const form = toMulipartedForm(this.form, this.$route.meta.mode)
				post(this.storeURL, form)
				    .then((res) => {
				        if(res.data.saved) {
				            Flash.setSuccess(res.data.message)
				            this.$router.push(`/materials`)
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
                del(`/api/materials/${this.$route.params.id}`).then((res) => {
                    Flash.setSuccess('Ha eliminado correctamente el material!')
                    this.$router.back()
                });
            }
		}
	}
</script>