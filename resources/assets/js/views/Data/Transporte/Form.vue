<template>
    <div class="recipe__show">
        <div class="recipe__header">
            <h3>{{action}} Transporte</h3>
            <div>
                <button class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
                <template v-if="action == 'Update'">
                    <button class="btn btn__danger" @click.prevent="remove(form)" :disabled="isProcessing">Eliminar</button>
                </template>
                <button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
            </div>
        </div>

        <div class="recipe__details">
            <div class="recipe__box">
                <div class="form__group">
                    <label>Zona</label>
                    <select :id="form.zona_id" :name="form.zona_id" class="form__control" v-model="form.zona_id">
                        <option disabled value="">seleccione</option>
                        <option v-for="z in zonas" :value="z.id" selected = " form.zona_id == z.id ? true : false ">{{ z.name }}</option>
                    </select>
                </div>
                <div class="form__group">
                    <label>Name</label>
                    <input type="text" class="form__control" v-model="form.name">
                    <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
                </div>
                <div class="form__group">
                    <label>Unidad</label>
                    <input type="text" class="form__control" v-model="form.unidad">
                    <small class="error__control" v-if="error.marca">{{error.marca[0]}}</small>
                </div>
                <div class="form__group">
                    <label>Tipo</label>
                    <input type="text" class="form__control" v-model="form.tipo">
                    <small class="error__control" v-if="error.tipo">{{error.tipo[0]}}</small>
                </div>
                <div class="form__group">
                    <label>Tarifa</label>
                    <input type="number" step="any" class="form__control" v-model="form.tarifa">
                    <small class="error__control" v-if="error.tarifa">{{error.tarifa[0]}}</small>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import Flash from '../../../helpers/flash'
    import { get, post, del } from '../../../helpers/api'
    import { toMulipartedForm } from '../../../helpers/form'
    import ImageUpload from '../../../components/ImageUpload.vue'

    export default {
        components: {
            ImageUpload
        },
        data() {
            return {
                zonas:[],

                form: {},
                error: {},
                isProcessing: false,
                initializeURL: `/api/transportes/create`,
                storeURL: `/api/transportes`,
                action: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/transportes/${this.$route.params.id}/edit`
                this.storeURL = `/api/transportes/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
                }),
                get(`/api/zonas`)
                    .then((res) => {
                        this.zonas = res.data.zonas
                    })
        },
        methods: {
            save() {
                const form = toMulipartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                        if(res.data.saved) {
                            Flash.setSuccess(res.data.message)
                            this.$router.push(`/transportes`)
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
            remove() {
                del(`/api/transportes/${this.$route.params.id}`).then((res) => {
                    Flash.setSuccess('Ha eliminado correctamente el transporte!')
                    this.$router.back()
                });
            }
        }
    }
</script>