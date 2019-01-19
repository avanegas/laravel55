<template>
	<div class="container">
		<header>
			<h2>Menu</h2>
			<a href="#" class="stuts">INFOASISTENCIA <span>Costos</span></a>
		</header>
		<nav class="menu">
			<ul>
				<li><router-link to="/" class="active brand">- Apuntes -</router-link></li>
				<li>
					<a href="#">Datos</a>
					<nav class="submenu">
						<li><router-link to="/equipos">Equipos</router-link></li>
						<li><router-link to="/materials">Materiales</router-link></li>
						<li><router-link to="/obreros">Obreros</router-link></li>
						<li><router-link to="/transportes">Transportes</router-link></li>
					</nav>
				</li>
				<li><router-link to="/precios">Precios</router-link></li>
				<li><router-link to="/proyectos">Proyectos</router-link></li>
				<li><router-link to="/ofertas">Ofertas</router-link></li>

				<li><router-link :to="`/posts/${authState.user_id}`"  v-if="auth">Entradas</router-link></li>
                <li><router-link to="/categories"  v-if="auth">Categorias</router-link></li>
                <li><router-link to="/tags"  v-if="auth">Etiquetas</router-link></li>

				<li><router-link to="/login" v-if="guest">LOGIN</router-link></li>			
				<li><router-link to="/register" v-if="guest">REGISTER</router-link></li>

                <li>
                    <a href="#" v-if="auth">{{ authState.user_id }} <span class="caret"> Admin</span></a>
                    <nav class="submenu">
                        <router-link to="/users" v-if="auth" >Administrar</router-link>
                        <a href="#" @click.stop="logout" v-if="auth">LOGOUT</a>
                    </nav>
                </li>
			</ul>
		</nav>
		<div class="flash flash__error" v-if="flash.error">
			{{flash.error}}
		</div>
		<div class="flash flash__success" v-if="flash.success">
			{{flash.success}}
		</div>
		<router-view></router-view>
	</div>
</template>
<script type="text/javascript">
	import Auth from './store/auth'
	import Flash from './helpers/flash'
	import { post, interceptors } from './helpers/api'
	export default {
		created() {
			// global error http handler
			interceptors((err) => {
				if(err.response.status === 401) {
					Auth.remove()
					this.$router.push('/login')
				}

				if(err.response.status === 500) {
					Flash.setError(err.response.statusText)
				}

				if(err.response.status === 404) {
					this.$router.push('/not-found')
				}
			})
			Auth.initialize()
		},
		data() {
			return {
				authState: Auth.state,
				flash: Flash.state
			}
		},
		computed: {
			auth() {
				if(this.authState.api_token) {
					return true
				}
				return false
			},
			guest() {
				return !this.auth
			}
		},
		methods: {
			logout() {
				post('/api/logout')
				.then((res) => {
					if(res.data.done) {
				            // remove token
				            Auth.remove()
				            Flash.setSuccess('Ha terminado su sesión correctamente. Gracias y suerte!')
				            this.$router.push('/login')
				        }
				    })
			}
		}
	}
</script>
