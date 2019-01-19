<template>
	<div class = "recipe__show">

		<div class="recipe__box">
			<div class="image__show">
				<img :src="`/images/${post.image}`" v-if="post.image">
			</div>
			<p>El articulo lo escribio <strong>{{ post.user.name }} </strong> {{post.created_at}}</p>
		</div>

		<div class="recipe__box">
			<p><strong>Categoría: </strong>{{ post.category.name }}</p>
			<h1 class="recipe__title">{{post.name}}</h1>
			<p>{{post.content}}</p>
			<p><strong>Articulos relacionados: </strong>{{post.tags}}</p>
			<br>
			<div v-if="authState.api_token && authState.user_id === post.user_id">
				<router-link :to="`/posts/${post.id}/edit`" class="btn btn__primary">Edit</router-link>
				<button class="btn btn__danger" @click="remove" :disabled="isRemoving">Delete</button>
			</div>
		</div>

	</div>
</template>
<script type="text/javascript">
	import Auth from '../../store/auth'
	import Flash from '../../helpers/flash'
	import { get, del } from '../../helpers/api'
	export default {
		data() {
			return {
				authState: Auth.state,
				isRemoving: false,
				post: {
					user: {},
					category: {}
				}
			}
		},
		created() {
			get(`/api/posts/${this.$route.params.id}`)
			.then((res) => {
				this.post = res.data.post
			})
		},
		methods: {
			remove() {
				this.isRemoving = false
				del(`/api/posts/${this.$route.params.id}`)
				.then((res) => {
					if(res.data.deleted) {
						Flash.setSuccess('You have successfully deleted post!')
						this.$router.push('/')
					}
				})
			}
		}
	}
</script>
