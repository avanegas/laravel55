<template>
    <div class="recipe__show">
        <div class="recipe__header">
            <h3>{{action}} Precio</h3>
            <div>
                <button class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
                <button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
            </div>
        </div> 

        <div class="proyecto__body" >
            <table >
                    <caption><h5 >ANALISIS  DE  PRECIO  UNITARIO</h5></caption>
                <thead>
                    <tr>
                        <th style="text-align: left">GRUPO:</th>
                        <td colspan="4">
                            <select name="" id="" class="form__control" v-model="form.grupo_precio_id">
                                <option disabled value="">seleccione</option>
                                <option v-for="gp in grupo_precios" :value="gp.id" :selected="form.grupo_precio_id == gp.id ? true : false">{{ gp.name }}</option>
                            </select>
                        </td>
                        <th style="text-align: left">FECHA:</th>
                        <td >{{form.created_at}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">RUBRO:</th>
                        <td colspan="4"><input type="text" class="form__control" v-model="form.name">
                                        <small class="error__control" v-if="error.name">{{error.name[0]}}</small></td>
                        <th style="text-align: left">UNIDAD:</th>
                        <td ><input type="text" class="form__control" v-model="form.unidad">
                             <small class="error__control" v-if="error.unidad">{{error.unidad[0]}}</small></td>
                    </tr>
                    <tr>
                        <th style="text-align: left">ESPECIFICACION:</th>
                        <td colspan="6"><input type="text" class="form__control" v-model="form.detalle">
                                        <small class="error__control" v-if="error.detalle">{{error.detalle[0]}}</small></td>
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
                    <tr v-for="(equipo, index) in form.equipos">
                        <td @click="mostrar(elegido='equipo')"><input type="text" class="form__control" v-model="equipo.equipo_id"
                            :class="[error[`equipos.${index}.equipo_id`] ? 'error__bg' : '']"></td>
                        <td><input type="text" class="form__control" v-model="equipo.name"
                            :class="[error[`equipos.${index}.name`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="equipo.cantidad"
                            :class="[error[`equipos.${index}.cantidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="equipo.tarifa"
                            :class="[error[`equipos.${index}.tarifa`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(equipo.cantidad*equipo.tarifa).toFixed(5)}}</td>
                        <td class="right"><input type="text" class="form__control" v-model="equipo.rendimiento"
                            :class="[error[`equipos.${index}.rendimiento`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(equipo.cantidad * equipo.tarifa*equipo.rendimiento).toFixed(5)}}</td>
                    </tr>
                    <tr v-for="n in 5-numEquipos">
                        <td @click="mostrar(elegido='equipo')"><input type="text" class="form__control" value="Ingrese Equipo"></td>
                        <td><input type="text" class="form__control" ></td>
                        <td class="right"><input type="text" class="form__control" ></td>
                        <td class="right"><input type="text" class="form__control" ></td>
                        <td class="right"><input type="text" class="form__control" ></td>
                        <td class="right"><input type="text" class="form__control" ></td>
                        <td class="right"><input type="text" class="form__control" ></td>
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

                    <tr v-for="(obrero, index) in form.obreros">
                        <td @click="mostrar(elegido='obrero')"><input type="text" class="form__control" v-model="obrero.obrero_id"
                            :class="[error[`obreros.${index}.obrero_id`] ? 'error__bg' : '']"></td>
                        <td><input type="text" class="form__control" v-model="obrero.name"
                                   :class="[error[`obreros.${index}.name`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="obrero.cantidad"
                                                 :class="[error[`obreros.${index}.cantidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="obrero.jornalhora"
                                                 :class="[error[`obreros.${index}.jornalhora`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(obrero.cantidad*obrero.jornalhora).toFixed(5)}}</td>
                        <td class="right"><input type="text" class="form__control" v-model="obrero.rendimiento"
                                                 :class="[error[`obreros.${index}.rendimiento`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(obrero.cantidad * obrero.jornalhora*obrero.rendimiento).toFixed(5)}}</td>
                    </tr>
                    <tr v-for="n in 7-numObreros">
                        <td @click="mostrar(elegido='obrero')">Ingrese Obrero</td>
                        <td></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
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

                    <tr v-for="(material, index) in form.materials">
                        <td><input type="text" class="form__control" v-model="material.material_id"
                                   :class="[error[`materials.${index}.material_id`] ? 'error__bg' : '']"></td>
                        <td colspan="2"><input type="text" class="form__control" v-model="material.name"
                                   :class="[error[`materials.${index}.name`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="material.unidad"
                                   :class="[error[`materials.${index}.unidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="material.cantidad"
                                   :class="[error[`materials.${index}.cantidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="material.precio"
                                   :class="[error[`materials.${index}.precio`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(material.cantidad * material.precio).toFixed(5)}}</td>
                    </tr>
                    <tr v-for="n in 7-numMaterials">
                        <td>Ingrese Material</td>
                        <td colspan="2"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
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

                    <tr v-for="(transporte, index) in form.transportes">
                        <td><input type="text" class="form__control" v-model="transporte.transporte_id"
                                   :class="[error[`transportes.${index}.transporte_id`] ? 'error__bg' : '']"></td>
                        <td colspan="2"><input type="text" class="form__control" v-model="transporte.name"
                                               :class="[error[`transportes.${index}.name`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="transporte.unidad"
                                                 :class="[error[`transportes.${index}.unidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="transporte.cantidad"
                                                 :class="[error[`transportes.${index}.cantidad`] ? 'error__bg' : '']"></td>
                        <td class="right"><input type="text" class="form__control" v-model="transporte.tarifa"
                                                 :class="[error[`transportes.${index}.tarifa`] ? 'error__bg' : '']"></td>
                        <td class="right">{{(transporte.cantidad * transporte.tarifa).toFixed(5)}}</td>
                    </tr>
                    <tr v-for="n in 4-numTransportes">
                        <td>Ingrese Transporte</td>
                        <td colspan="2"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
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
                        <td class="right">{{ otros }}%</td>
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
        <!--use the modal component, pass in the prop -->
        <modal :elegido = "this.elegido" v-if="showModal" @close="showModal = false">
            <!-- you can use custom content here to overwrite default content
            <h3 slot="header">custom header</h3> -->
        </modal>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import Flash from '../../helpers/flash'
    import { get, post } from '../../helpers/api'
    import { toMulipartedForm } from '../../helpers/form'
    import Modal from '../../components/Modal.vue'
    export default {
        components: {
            Modal
        },
        data() {
            return {
                form: {
                    equipos: [],
                    obreros: [],
                    materials:[],
                    transportes:[]
                },
                error: {},
                grupo_precios:[],
                indirectos: 18,
                otros: 0,
                elegido: null,
                showModal: false,
                isProcessing: false,
                initializeURL: `/api/precios/create`,
                storeURL: `/api/precios`,
                action: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/precios/${this.$route.params.id}/edit`
                this.storeURL = `/api/precios/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
                }),
            get(`/api/grupo_precios`)
                .then((res) => {
                    this.grupo_precios = res.data.grupo_precios
                })
        },
        computed: {
            subTotalEquipos: function() {
                return this.form.equipos.reduce(function(carry, equipo) {
                    return carry + (parseFloat(equipo.cantidad) * parseFloat(equipo.tarifa)*parseFloat(equipo.rendimiento));
                }, 0);
            },
            numEquipos: function(){
                return this.form.equipos.length
            },

            subTotalObreros: function() {
                return this.form.obreros.reduce(function(carry, obrero) {
                    return carry + (parseFloat(obrero.cantidad) * parseFloat(obrero.jornalhora)*parseFloat(obrero.rendimiento));
                }, 0);
            },
            numObreros: function(){
                return this.form.obreros.length
            },

            subTotalMaterials: function() {
                return this.form.materials.reduce(function(carry, material) {
                    return carry + (parseFloat(material.cantidad) * parseFloat(material.precio));
                }, 0);
            },
            numMaterials: function(){
                return this.form.materials.length
            },

            subTotalTransportes: function() {
                return this.form.transportes.reduce(function(carry, transporte) {
                    return carry + (parseFloat(transporte.cantidad) * parseFloat(transporte.tarifa));
                }, 0);
            },
            numTransportes: function(){
                return this.form.transportes.length
            },

            directo: function(){
                return  this.form.directo = parseFloat(this.subTotalEquipos) + parseFloat(this.subTotalObreros) + parseFloat(this.subTotalMaterials) + parseFloat(this.subTotalTransportes);
            },
            indirecto: function(){
                return  this.form.indirecto = parseFloat(this.directo*this.indirectos/100);
            },
            otro: function(){
                return  parseFloat(this.directo*this.otros/100);
            },
            total: function(){
                return  parseFloat(this.directo) + parseFloat(this.indirecto) + parseFloat(this.otro);
            },
            ofertado: function(){
                return parseFloat(this.directo) + parseFloat(this.indirecto) + parseFloat(this.otro);
            }

        },
        methods: {
            save() {
                const form = toMulipartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                        if(res.data.saved) {
                            Flash.setSuccess(res.data.message)
                            this.$router.push(`/precios/${res.data.id}`)
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data
                        }
                        this.isProcessing = false
                    })
            },
            mostrar(elegido){
                this.showModal = true;
            }
        }
    }
</script>
