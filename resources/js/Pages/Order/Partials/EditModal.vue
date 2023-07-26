<template>
    <div class="modal fade modal-lg" :id="'editModal'+id" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Modifier un bon</h1>
            <button :id="'editModalClose'+id" @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form :id="'updateForm'+id" @submit.prevent="submitUpdateOrder" onkeydown="return event.key != 'Enter';">

                    <!-- Affichage réference -->

                    <div class="mb-3">
                        <label class="form-label"> Référence </label>
                        <div> {{ order.reference }} </div>
                    </div>

                    <hr/>

                    <!-- Date -->

                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date" :min="currentDate">
                        <div class="text-danger mt-2" v-if="errors.date">{{ errors.date }}</div>
                    </div>

                    <hr/>

                    <!-- Liste des services sélectionné -->

                    <OrderSelect :services="services" :form-servicesList="form.servicesList"></OrderSelect>

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
                                <input type="radio" v-model="form.status" :value="0">
                                <label class="ms-2" for="huey">Fermé</label>
                            </div>
                        </fieldset>
                        <div class="text-danger mt-2" v-if="errors.status">{{ errors.status }}</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button :form="'updateForm'+id" type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>
    import { router } from '@inertiajs/vue3'
    import OrderSelect from './OrderSelect.vue';

    export default {
        components: { OrderSelect },
        props: ['id', 'order', 'services', 'currentDate'],
        data() {
            return {
                form: {
                    status: this.order.status,
                    price: this.order.price,
                    servicesList: this.order.services,
                    date: this.order.date,
                },
                errors: [],
            }
        },
        methods : {

            // ****************** Modal ******************


                closeModal(){
                    document.getElementById("editModalClose"+this.id).click();
                },


            // ****************** Submit ******************


                submitUpdateOrder(){
                    router.put(
                        '/bons-de-commande/'+this.id, 
                        this.form,
                        {
                            onSuccess: (page) => {
                                this.closeModal();
                            },
                            onError: (errors) => {
                                this.errors = errors;
                                console.log(errors);
                            },
                        }
                    );
                },

        },
    }

</script>