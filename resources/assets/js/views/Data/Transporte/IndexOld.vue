<template>
    <div>
        <div class="title">
            <router-link to="/transportes/create" title="NUEVO"><h3>TRANSPORTES</h3></router-link>
            <div class="form__search">
                <input @keyup="searchTransportes()"
                       type="search"
                       class="search__input"
                       name="search"
                       placeholder="Search"
                       v-model="search">
            </div>
        </div>

        <div class="post__list">
            <div class="data data__titles">
                <div><p>Zona</p></div>
                <div><p>Descripcion</p></div>
                <div><p>Unidad</p></div>
                <div><p>Tipo</p></div>
                <div><p>Tarifa</p></div>
                <div><p>Proveedor</p></div>
            </div>
            <div v-for="transporte in searchTransportes">
                <router-link :to="`/transportes/${transporte.id}/edit`" class="data">
                    <div><p>{{transporte.zona.name}}</p></div>
                    <div><p>{{transporte.name}}</p></div>
                    <div><p>{{transporte.unidad}}</p></div>
                    <div><p>{{transporte.tipo}}</p></div>
                    <div class="right"><p>{{transporte.tarifa}}</p></div>
                    <div><p>Proveedor</p></div>
                </router-link>
            </div>
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
        computed: {
            searchTransportes: function(){
                return this.transportes.filter((transporte) => transporte.name.includes(this.search));
            }
        }
    }
</script>