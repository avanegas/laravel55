<template>
	<div class="container">
		<header>
			<h2>Menu</h2>
			<a href="#" class="stuts">INFOASISTENCIA <span>Costos</span></a>
		</header>
		<nav>
			<ul class="menu">
				<li class="item"><router-link to="/" class="active brand">- Apuntes -</router-link></li>
				<li class="item"><a class="hsubs" href="#">Datos</a>
					<ul class="subs">
						<li class="item"><router-link to="/equipos" v-if="auth">Equipos</router-link></li>
						<li class="item"><router-link to="/materials" v-if="auth">Materiales</router-link></li>
						<li class="item"><router-link to="/obreros" v-if="auth">Obreros</router-link></li>
						<li class="item"><router-link to="/transportes" v-if="auth">Transporte</router-link></li>
					</ul>
				</li>
				<li class="item"><router-link to="/precios" v-if="auth">Precios</router-link></li>
				<li class="item"><router-link to="/proyectos"  v-if="auth">Proyectos</router-link></li>
				<li class="item"><router-link to="/login" v-if="guest">LOGIN</router-link></li>			
				<li class="item"><router-link to="/register" v-if="guest">REGISTER</router-link></li>
				<li class="item"><a @click.stop="logout" v-if="auth">LOGOUT</a></li>
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
