<template>
	<div class="recipe__show">
		<div class="recipe__header">
			<h3>{{action}} Nota</h3>
			<div>
				<button class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
				<button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
			</div>
		</div>
		<br>
		<div class="image__show">
			<div class="recipe__box">
				<image-upload v-model="form.image"></image-upload>
				<small class="error__control" v-if="error.image">{{error.image[0]}}</small>
			</div>
		</div>
		<div class="recipe__details">
			<div class="recipe__box">
				<div class="form__group">
					<label for="category_id">Categoría</label>
					<select id="category_id" name="category_id" class="form__control" v-model="form.category_id">
						<option disabled value="">seleccione</option>
						<option v-for="c in categories" :value="c.id" selected = " form.category_id == c.id ? true : false ">{{ c.name }}</option>
					</select>
				</div>
				<div class="form__group">
					<label>Titulo</label>
					<input type="text" class="form__control" v-model="form.name">
					<small class="error__control" v-if="error.name">{{error.name[0]}}</small>
				</div>
				<div class="form__group">
					<label>Contenido</label>
					<textarea class="form__control form__description" v-model="form.content"></textarea>
					<small class="error__control" v-if="error.content">{{error.content[0]}}</small>
				</div>
				<div class="form__group">
					<label>Asociaciones</label>
					<input type="text" class="form__control" v-model="form.tags">
					<small class="error__control" v-if="error.tags">{{error.tags[0]}}</small>
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

	export default {
		components: {
			ImageUpload
		},
		data() {
			return {
				categories:[],

				form: {},
				error: {},
				isProcessing: false,
				initializeURL: `/api/posts/create`,
				storeURL: `/api/posts`,
				action: 'Create'
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeURL = `/api/posts/${this.$route.params.id}/edit`
				this.storeURL = `/api/posts/${this.$route.params.id}?_method=PUT`
				this.action = 'Update'
			}
			get(this.initializeURL)
			.then((res) => {
				Vue.set(this.$data, 'form', res.data.form)
			}),
			get(`/api/categories`)
			.then((res) => {
				this.categories = res.data.categories
			})
		},
		methods: {
			save() {
				const form = toMulipartedForm(this.form, this.$route.meta.mode)
				post(this.storeURL, form)
				.then((res) => {
					if(res.data.saved) {
						Flash.setSuccess(res.data.message)
						this.$router.push(`/posts/${res.data.id}`)
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
				alert('borrar');
			}
		}
	}
</script>
