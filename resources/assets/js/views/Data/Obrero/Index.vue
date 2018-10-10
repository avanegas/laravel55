<template>
    <div class="panel">
        <div class="panel-heading">
            <router-link to="/obreros/create" class="panel-title" title="Nuevo Obrero">
                Obreros
            </router-link>
            <div class="form__search">
                <input @keyup="searchObreros()"
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
                    <th>Jornal Hora</th>
                    <th>Factor</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="obrero in searchObreros" @click="detailsPage(obrero)">
                    <td class="w-1">{{obrero.grupo_obrero.name}}</td>
                    <td class="w-6">{{obrero.name}}</td>
                    <td class="w-6">{{obrero.jornalhora | formatMoney}}</td>
                    <td class="w-3">{{obrero.factor | formatMoney}}</td>
                    <td class="w-3">{{obrero.created_at}}</td>
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
                obreros: [],
                search:''
            }
        },
        created() {
            get(`/api/obreros`)
                .then((res) => {
                    this.obreros = res.data.obreros
                })
        },
        methods: {
            detailsPage(obrero) {
                this.$router.push(`/obreros/${obrero.id}/edit`)
            }
        },
        computed: {
            searchObreros: function(){
                return this.obreros.filter((obrero) => obrero.name.includes(this.search));
            }
        }
    }
</script>