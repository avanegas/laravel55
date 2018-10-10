<template>
    <div class="panel">
        <div class="panel-heading">
            <router-link to="/transportes/create" class="panel-title" title="Nuevo Transporte">
                Transportes
            </router-link>
            <div class="form__search">
                <input @keyup="searchTransportes()"
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
                    <th>Zona</th>
                    <th>Descripción</th>
                    <th>Unidad</th>
                    <th>Tipo</th>
                    <th>Tarifa</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="transporte in searchTransportes" @click="detailsPage(transporte)">
                    <td class="w-1">{{transporte.zona.name}}</td>
                    <td class="w-6">{{transporte.name}}</td>
                    <td class="w-6">{{transporte.unidad}}</td>
                    <td class="w-6">{{transporte.tipo}}</td>
                    <td class="w-3">{{transporte.tarifa | formatMoney}}</td>
                    <td class="w-3">{{transporte.created_at}}</td>
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
                transportes: [],
                search:''
            }
        },
        created() {
            get(`/api/transportes`)
                .then((res) => {
                    this.transportes = res.data.transportes
                })
        },
        methods: {
            detailsPage(transporte) {
                this.$router.push(`/transportes/${transporte.id}/edit`)
            }
        },
        computed: {
            searchTransportes: function(){
                return this.transportes.filter((transporte) => transporte.name.includes(this.search));
            }
        }
    }
</script>