<template>
    <div>
        <div class="title">
            <router-link to="/obreros/create" title="NUEVO"><h3>OBREROS</h3></router-link>
            <div class="form__search">
                <input @keyup="searchObreros()"
                       type="search"
                       class="search__input"
                       name="search"
                       placeholder="Search"
                       v-model="search">
            </div>
        </div>

        <div class="post__list">
            <div class="data data__titles">
                <div><p>Grupo</p></div>
                <div><p>Descripcion</p></div>
                <div><p>Jornal Hora</p></div>
                <div><p>Factor</p></div>
                <div><p>Proveedor</p></div>
            </div>
            <div v-for="obrero in searchObreros" @click="detailsPage(obrero)">
                    <div><p>{{obrero.grupo_obrero.name}}</p></div>
                    <div><p>{{obrero.name}}</p></div>
                    <div class="right"><p>{{obrero.jornalhora}}</p></div>
                    <div class="right"><p>{{obrero.factor}}</p></div>
                    <div><p>Proveedor</p></div>
            </div>
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