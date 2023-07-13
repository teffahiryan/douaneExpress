<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Ajout d'un service</h1>
            <button type="button" id="createModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" @submit.prevent="submitCreateService" >
                    <div class="mb-3">
                        <label class="form-label"> Référence </label>
                        <input type="text" class="form-control" v-model="form.reference">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Nom </label>
                        <input type="text" class="form-control" v-model="form.name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Prix </label>
                        <input type="text" class="form-control" v-model="form.price">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Image </label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <label class="form-label"> Limiter a une seule commande </label>
                        <input type="checkbox" v-model="form.isLimited" true-value="1" false-value="0" class="form-check-input" role="switch">
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label"> Sur service (Optionnel)</label>
                        <select class="form-select" v-model="form.onService">
                            <option disabled value=""> Sélectionnez un service </option>
                            <option v-for="service in services" :value="service.name" :key="'select'+service.id"> {{ service.name }} </option>
                        </select>
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

    import Form from './Form.vue';
    import {ref, reactive} from 'vue';
    import { router } from '@inertiajs/vue3'

    export default {
        data() {
            return {
                form: {
                    reference: null,
                    name: null,
                    price: null,
                    image: "null",
                    isLimited: null,
                    onService: ""
                }
            }
        },
        props: ['services'],
        components : {
            Form, 
        },
        methods : {

            closeModal(){
                document.getElementById("createModalClose").click();
                this.form.reference = null;
                this.form.name = null;
                this.form.price = null;
                this.form.reference = null;
                this.form.isLimited = null;
                this.form.onService = null;
            },

            submitCreateService(){
                router.post(
                    '/service', 
                    this.form,
                    {
                        onSuccess: (page) => {
                            this.closeModal();
                        },
                        onError: (errors) => {alert("error")},
                    }
                );
                console.log("test 2");
            },

        },
    }

</script>