<template>
	<div class="panel">
		<div class="panel-heading">
            <router-link to="/posts/create" class="panel-title" title="Nuevo Articulo">
                Apuntes, detalles y teoría de la construcción.
            </router-link>
            <div class="form__search">
 				Search
            </div>
		</div>
		<div class="post__list">
			<div class="post__item" v-for="post in posts">
				<router-link class="recipe__inner" :to="`/posts/${post.id}`">
					<p class="post__autor">Escribió, {{post.user.name}}, exactamente<em> {{post.created_at}}.</em></p>
					<img class="post__image" :src="`/images/${post.image}`" v-if="post.image">
					<p class="post__name"><strong>Categoría:</strong> {{post.category.name}}</p>
					<p class="post__name"><strong>Tema:</strong> {{post.name}}</p>
					<p class="post__name"><strong>Temas relacionados:</strong> {{ post.tags }}</p>
				</router-link>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import { get } from '../../helpers/api'
	export default {
		data() {
			return {
				posts: []
			}
		},
		created() {
			get(`/api/posts`)
			.then((res) => {
				this.posts = res.data.posts
			})
		}
	}
</script>
