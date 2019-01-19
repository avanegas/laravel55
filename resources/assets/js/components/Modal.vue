<template>
        <transition name="modal">
            <div class="modal__mask">
                <div class="modal__wrapper">
                    <div class="modal__container"  @scroll="handleScroll">

                        <div class="modal__cerrar modal__header">
                                <a  @click="$emit('close')">Cerrar  <em>X</em></a>
                        </div>

                        <div class="modal__header">
                            <slot  name="header">
                                <button class="btn btn__warning btn__block"><em>Borrar datos en esta linea. .  .?</em></button>
                            </slot>
                        </div>

                        <div class="modal__body">
                            <slot name="body">
                                <div class="modal__search">
                                    <h3>{{ this.elegido + 's' }}</h3>
                                    <div class="form__search">
                                        <input
                                                type="search"
                                                class="search__input"
                                                name="query"
                                                placeholder="Search"
                                                v-model="searchQuery">
                                    </div>
                                </div>
                                <lista-search
                                        :data="gridData"
                                        :columns="gridColumns"
                                        :filter-key="searchQuery"
                                        :lista="lista"
                                        :isAutorized="isAutorized">
                                </lista-search>
                            </slot>
                        </div>

                        <div class="modal__footer">
                            <slot name="footer">
                                << 1.2.3.4..>>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
</template>

<script type="text/javascript">
    import { get } from '../helpers/api'
    import ListaSearch from '../components/ListaSearch.vue'
    export default {
        props: [
            'elegido'
        ],
        components: {
            ListaSearch
        },
        data() {
            return {

                scrollPosition: 0,
                searchQuery:'',
                gridData: [],
                gridColumns:['name', 'tarifa'],
                lista:`${this.elegido}s`,
                isAutorized: false
            }
        },
        created() {
            get(`/api/${this.elegido}s`)
                .then((res) => {
                    this.gridData = res.data.equipos
                })
        },
        methods: {
            handleScroll: function (e) {
                var currentScrollPosition = e.srcElement.scrollTop;
                if (currentScrollPosition > this.scrollPosition) {
                    console.log("Scrolling down");
                }
                this.scrollPosition = currentScrollPosition;
            }
        }
    }
</script>

<style lang="scss">
    .modal {
        &__mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }
        &__wrapper {
            display: table-cell;
            vertical-align: middle;
        }
        &__container {
            width: 400px;
            margin: 0px auto;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
            max-height: 600px;
            overflow-y: scroll;
        }
        &__header h3 {
            margin-top: 0;
            color: #42b983;
        }
        &__body {
            margin: 20px 0;
        }
        &__body table{
            width:100%;
        }
        &__default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        &__enter {
            opacity: 0;
        }
        &__leave-active {
            opacity: 0;
        }
        &__enter &__container,
        &__leave-active &__container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
        &__cerrar {
            font-weight: 600;
            text-align: right;
        }
        &__cerrar a {
            color: red;
            cursor: default;
        }
        &__search {
            height: 40px;
            box-shadow: rgba(0, 0, 0, 0.09) 0 1px 0;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 15px;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>
