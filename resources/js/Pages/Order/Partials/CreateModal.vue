<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Créer un bon</h1>
            <button id="createModalClose" 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="modal" 
                aria-label="Close">
            </button>
            </div>
            <div class="modal-body">
                <form id="createForm" @submit.prevent="submitCreateOrder" onkeydown="return event.key != 'Enter';">
                    
                    <!-- Date -->

                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date" :min="currentDate">
                        <div class="text-danger mt-2" v-if="errors.date">{{ errors.date }}</div>
                    </div>

                    <hr/>

                    <!-- Services -->

                    <OrderSelect :price="form.price" :services="services" :form-servicesList="form.servicesList" @getTotalPrice="getTotalPrice"></OrderSelect>

                    <hr/> 

                    <!-- Status -->

                    <div class="mb-3">
                        <fieldset>
                            <legend> Status </legend>
                            <div>
                                <input type="radio" v-model="form.status" :value="1">
                                <label class="ms-2" for="dewey">Ouvert</label>
                            </div>
                            <div>
                                <input type="radio" v-model="form.status" :value="0" checked>
                                <label class="ms-2" for="huey">Fermé</label>
                            </div>
                        </fieldset>
                        <div class="text-danger mt-2" v-if="errors.status">{{ errors.status }}</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button form="createForm" type="submit" class="btn btn-primary">Créer</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>
    import { router } from '@inertiajs/vue3'
    import OrderSelect from './OrderSelect.vue';
    import axios from 'axios'

    import { defineComponent } from 'vue';
    import { usePage } from '@inertiajs/vue3';

    export default {
        components: { OrderSelect },
        emits: ['getTotalPrice'],
        props: ['services', 'currentDate'],
        data() {
            return {
                form: {
                    reference: "",
                    date: null,
                    status: 0,
                    price: 0.0,
                    servicesList: [],
                },
                errors: [],
                totalPrice: 0.0
            }
        },
        methods : {

            // ****************** Modal ******************


                closeModal(){
                    document.getElementById("createModalClose").click();
                    this.form.date = null;
                    this.form.status = null;
                    this.form.price = 0.0;
                    this.form.servicesList = [];
                },


            // ****************** Submit ******************
 

                submitCreateOrder(){
                    console.log("send");
                    console.log(this.form);
                    router.post(
                        '/bons-de-commande', 
                        this.form,
                        {
                            onSuccess: (page) => {
                                this.closeModal();
                            },
                            onError: (errors) => {
                                this.errors = errors;
                                console.log("error");
                                console.log(this.form);
                                console.log(errors);
                                console.log("----------------------------------------");
                            },
                        }
                    );
                },

            // ****************** Get Total Price ******************

                getTotalPrice(){
                    axios.get('/panier/total', {params : {servicesList : this.form.servicesList} })
                    .then(res => {
                        this.form.price = res.data
                    })
                }
        },
    }

</script>

