<template>
    <div class="recipe__show">
        <div class="title">
            <router-link to="/precios/create" title="Nuevo"><h3>PRECIOS</h3></router-link>
        </div>

        <div class="proyecto__body">
            <table>
                <thead>
                <tr>
                    <th class="recipe__three">Grupo</th>
                    <th class="recipe__four">Rubro</th>
                    <th class="recipe__one">Unidad</th>
                    <th class="recipe__three">Especificaciones</th>
                    <th class="recipe__one">Costo Directo</th>
                    <th class="recipe__cero">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="precio in precios">
                        <td>{{precio.grupo_precio.name}}</td>
                        <td>{{precio.name}}</td>
                        <td>{{precio.unidad}}</td>
                        <td>{{precio.detalle}}</td>
                        <td>{{precio.directo}}</td>
                        <td><router-link :to="`/precios/${precio.id}`">x</router-link></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>
<script type="text/javascript">
    import { get } from '../../helpers/api'
    export default {
        data() {
            return {
                precios: []
            }
        },
        created() {
            get(`/api/precios`)
                .then((res) => {
                    this.precios = res.data.precios
                })
        }
    }
</script>