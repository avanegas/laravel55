<template>
    <div class="panel">
        <div class="panel-heading">
            <router-link to="/equipos/create" class="panel-title" title="Nuevo Equipo">
                Equipos
            </router-link>
            <div class="form__search">
                <input 
                       type="text"
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
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Tarifa</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="equipo in searchEquipos" @click="detailsPage(equipo)">
                    <td class="w-1">{{equipo.grupo_equipo.name}}</td>
                    <td class="w-6">{{equipo.name}}</td>
                    <td class="w-6">{{equipo.marca}}</td>
                    <td class="w-3">{{equipo.tipo}}</td>
                    <td class="w-3">{{equipo.tarifa | formatMoney}}</td>
                    <td class="w-3">{{equipo.created_at}}</td>
                    <td class="w-3">Proveedor</td>
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
                equipos: [],
                search:''
            }
        },
        created() {
            get(`/api/equipos`)
                .then((res) => {
                    this.equipos = res.data.equipos
                })
        },
        methods: {
            detailsPage(equipo) {
                this.$router.push(`/equipos/${equipo.id}/edit`)
            }
        },
        computed: {
            searchEquipos: function(){
                return this.equipos.filter((equipo) => equipo.name.includes(this.search));
            }
        }
    }
</script>