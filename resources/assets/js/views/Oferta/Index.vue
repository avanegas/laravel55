<template>
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				
				<div class="row action-panel">
					<div class="col-xs-12">
						<div class="btn-group pull-right">
							<a id="list" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-th-list"></span>
								List
							</a>
							<a id="grid" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-th"></span>
								Grid
							</a>
						</div>

					</div>

				</div>
				<div class="is-flex">
					<div class="col-md-4 item" v-for="post in posts">
						<div class="thumbnail">
							
							<div class="caption margin-left-sm">
								<h4 class="pull-right">$ 1240,00</h4>
								<h4>
									<router-link class="recipe__inner" :to="`/posts/${post.id}`">
										Descripcion del equipo a la venta
									</router-link>
								</h4>
								<p class="truncate"> sdfafsd sd fsdf f sd f sd f asd f sd f sdf sd f sd fs df s f sdf as  df sd f asdf sd f...</p>
							</div>
							<p >{{post.user.name}}, {{post.created_at}}</p>
							<p >{{post.category.name}}</p>
							<p >{{post.name}}</p>
							<p > {{ post.tags }}</p>
							
						</div>
						

						
					</div>
				</div>
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
