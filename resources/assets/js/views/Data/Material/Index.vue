<template>
	<div class="panel">
		<div class="panel-heading">
			<router-link to="/materials/create" class="panel-title" title="Nuevo Material">
				Materiales
			</router-link>
			<div class="form__search">
				<input @keyup="searchMaterials()"
					   type="search"
					   class="search__input"
					   name="search"
					   placeholder="Search"
					   v-model="search">
			</div>
		</div>

		<div class="panel-body">
			<table class="table table-link">
				<thead>
				<tr>
					<th>Grupo</th>
					<th>Descripción</th>
					<th>Unidad</th>
					<th>Precio</th>
					<th>Fecha</th>
					<th>Proveedor</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="material in searchMaterials" @click="detailsPage(material)">
					<td class="w-1">{{material.grupo_material.name}}</td>
					<td class="w-6">{{material.name}}</td>
					<td class="w-6">{{material.unidad}}</td>
					<td class="w-3">{{material.precio | formatMoney}}</td>
					<td class="w-3">{{material.created_at}}</td>
					<td class="w-3">Provedeor</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>
<script type="text/javascript">
	import { get } from '../../../helpers/api'
	export default {
		data() {
			return {
				materials: [],
				search:''
			}
		},
		created() {
			get(`/api/materials`)
			.then((res) => {
				this.materials = res.data.materials
			})
		},
        methods: {
            detailsPage(material) {
                this.$router.push(`/materials/${material.id}/edit`)
            }
        },
        computed: {
            searchMaterials: function(){
                return this.materials.filter((material) => material.name.includes(this.search));
            }
        }
	}
</script>