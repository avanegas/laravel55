<template>
    <div class="recipe__show">
        <div class="recipe__header">
            <div class="form__group recipe__eight">
                <p><strong>AUTOR: </strong>{{precio.user.name}}</p>
            </div>
            <div v-if="authState.api_token && authState.user_id === precio.user_id" class="recipe__foot">
                <router-link :to="`/precios/${precio.id}/edit`" class="btn btn__primary"> Edit</router-link>
                <button class="btn btn__danger" @click="remove" :disabled="isRemoving">Delete</button>
            </div>
        </div>

        <div class="proyecto__body" >
            <table >
                    <caption><h5 >ANALISIS  DE  PRECIO  UNITARIO</h5></caption>
                <thead>
                    <tr>
                        <th style="text-align: left">GRUPO:</th>
                        <td colspan="4">{{precio.grupo_precio.name}}</td>
                        <th style="text-align: left">FECHA:</th>
                        <td >{{precio.created_at}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">RUBRO:</th>
                        <td colspan="4">{{precio.name}}</td>
                        <th style="text-align: left">UNIDAD:</th>
                        <td >{{precio.unidad}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">ESPECIFICACION:</th>
                        <td colspan="6">{{precio.detalle}}</td>
                    </tr>
                    <tr>
                        <td colspan="7">EQUIPOS</td>
                    </tr>
                    <tr>
                        <th class="recipe__one">&nbsp;</th>
                        <th class="recipe__one">Descripcion</th>
                        <th class="recipe__six">Cantidad</th>
                        <th class="recipe__one">Tarifa</th>
                        <th class="recipe__one">Costo Hora</th>
                        <th class="recipe__one">Rendimiento</th>
                        <th class="recipe__one">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="equipo in precio.equipos">
                        <td>{{equipo.equipo_id}}</td>
                        <td>{{equipo.name}}</td>
                        <td class="right">{{equipo.cantidad}}</td>
                        <td class="right">{{equipo.tarifa}}</td>
                        <td class="right">{{(equipo.cantidad*equipo.tarifa).toFixed(5) }}</td>
                        <td class="right">{{equipo.rendimiento}}</td>
                        <td class="right">{{ (equipo.cantidad * equipo.tarifa*equipo.rendimiento).toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">MANO DE OBRA</td>
                        <td class="right"> Subtotal</td>
                        <td class="right">{{ subTotalEquipos.toFixed(5) }}</td>
                    </tr>
                    <!-- FIN EQUIPO -->
                    <tr>
                        <th class="recipe__one">&nbsp;</th>
                        <th class="recipe__one">Descripcion</th>
                        <th class="recipe__six">Cantidad</th>
                        <th class="recipe__one">Jornal Hora</th>
                        <th class="recipe__one">Costo Hora</th>
                        <th class="recipe__one">Rendimiento</th>
                        <th class="recipe__one">Total</th>
                    </tr>

                    <tr v-for="obrero in precio.obreros">
                        <td>{{obrero.obrero_id}}</td>
                        <td>{{obrero.name}}</td>
                        <td class="right">{{obrero.cantidad}}</td>
                        <td class="right">{{obrero.jornalhora}}</td>
                        <td class="right">{{ (obrero.cantidad*obrero.jornalhora).toFixed(5) }}</td>
                        <td class="right">{{obrero.rendimiento}}</td>
                        <td class="right">{{ (obrero.cantidad * obrero.jornalhora*obrero.rendimiento).toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">MATERIALES</td>
                        <td class="right"> Subtotal</td>
                        <td class="right">{{ subTotalObreros.toFixed(5) }}</td>
                    </tr>
                    <!-- FIN OBRERO -->
                    <tr>
                        <th class="recipe__one">&nbsp;</th>
                        <th colspan="2" class="recipe__one">Descripcion</th>
                        <th class="recipe__six">unidad</th>
                        <th class="recipe__one">Cantidad</th>
                        <th class="recipe__one">Precio</th>
                        <th class="recipe__one">Total</th>
                    </tr>

                    <tr v-for="material in precio.materials">
                        <td>{{material.material_id}}</td>
                        <td colspan="2">{{material.name}}</td>
                        <td class="right">{{material.unidad}}</td>
                        <td class="right">{{material.cantidad}}</td>
                        <td class="right">{{material.precio}}</td>
                        <td class="right">{{ (material.cantidad * material.precio).toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">TRANSPORTES</td>
                        <td class="right"> Subtotal</td>
                        <td class="right">{{ subTotalMaterials.toFixed(5) }}</td>
                    </tr>
                    <!-- FIN MATERIAL -->
                    <tr>
                        <th class="recipe__one">&nbsp;</th>
                        <th colspan="2" class="recipe__one">Descripcion</th>
                        <th class="recipe__six">Unidad</th>
                        <th class="recipe__one">Cantidad</th>
                        <th class="recipe__one">Tarifa</th>
                        <th class="recipe__one">Total</th>
                    </tr>

                    <tr v-for="transporte in precio.transportes">
                        <td>{{transporte.transporte_id}}</td>
                        <td colspan="2">{{transporte.name}}</td>
                        <td class="right">{{transporte.unidad}}</td>
                        <td class="right">{{transporte.cantidad}}</td>
                        <td class="right">{{transporte.tarifa}}</td>
                        <td class="right">{{ (transporte.cantidad * transporte.tarifa).toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                        <td class="right"> Subtotal</td>
                        <td class="right">{{ subTotalTransportes.toFixed(5) }}</td>
                    </tr>
                    <!-- FIN TRANSPORTE -->
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="3">TOTAL DE COSTO DIRECTO</td>
                        <td class="right">{{ directo.toFixed(5) }}</td>
                    </tr>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">INDIRECTOS Y UTILIDADES %</td>
                        <td class="right">{{ indirectos }}%</td>
                        <td class="right">{{ indirecto.toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">OTROS INDIRECTOS %</td>
                        <td class="right">{{otros}}%</td>
                        <td class="right">{{ otro.toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="3">COSTO TOTAL DEL RUBRO</td>
                        <td class="right">{{ total.toFixed(5) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="3">VALOR OFERTADO</td>
                        <td class="right">{{ ofertado.toFixed(5) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Auth from '../../store/auth'
    import Flash from '../../helpers/flash'
    import { get, del } from '../../helpers/api'
    export default {
        data() {
            return {
                authState: Auth.state,
                isRemoving: false,
                indirectos: 18,
                otros: 0,
                precio: {
                    user: {},
                    grupo_precio: {},
                    equipos: [],
                    obreros: [],
                    materials:[],
                    transportes:[]
                }
            }
        },
        created() {
            get(`/api/precios/${this.$route.params.id}`)
                .then((res) => {
                    this.precio = res.data.precio
                })
        },
        methods: {
            remove() {
                this.isRemoving = false
                del(`/api/precios/${this.$route.params.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            Flash.setSuccess('You have successfully deleted precio!')
                            this.$router.push('/')
                        }
                    })
            }
        },
        computed: {
            subTotalEquipos: function() {
                return this.precio.equipos.reduce(function(carry, equipo) {
                    return carry + (parseFloat(equipo.cantidad) * parseFloat(equipo.tarifa)*parseFloat(equipo.rendimiento));
                }, 0);
            },
            subTotalObreros: function() {
                return this.precio.obreros.reduce(function(carry, obrero) {
                    return carry + (parseFloat(obrero.cantidad) * parseFloat(obrero.jornalhora)*parseFloat(obrero.rendimiento));
                }, 0);
            },
            subTotalMaterials: function() {
                return this.precio.materials.reduce(function(carry, material) {
                    return carry + (parseFloat(material.cantidad) * parseFloat(material.precio));
                }, 0);
            },
            subTotalTransportes: function() {
                return this.precio.transportes.reduce(function(carry, transporte) {
                    return carry + (parseFloat(transporte.cantidad) * parseFloat(transporte.tarifa));
                }, 0);
            },
            directo: function(){
                return  this.precio.directo = this.subTotalEquipos + this.subTotalObreros + this.subTotalMaterials + this.subTotalTransportes;
            },
            indirecto: function(){
                return  this.precio.indirecto = this.directo*this.indirectos/100;
            },
            otro: function(){
                return  this.directo*this.otros/100;
            },
            total: function(){
                return  this.directo + this.indirecto + this.otro;
            },
            ofertado: function(){
                return  this.directo + this.indirecto + this.otro;
            }
        }
    }
</script>