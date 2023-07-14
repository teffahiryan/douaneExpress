<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Créer un bon</h1>
            <button id="createModalClose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" @submit.prevent="submitCreateOrder">
                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date">
                    </div>

                    <hr/>

                    <div>
                        <div>Liste des services</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between" v-for="selectedService in form.services" :key="'selected'+selectedService.id">
                                <div>{{ selectedService.name }} - {{ selectedService.price }} € </div>
                                <div>
                                    
                                    <input v-if="selectedService.isLimited == 0" :id="'inputService'+selectedService.id" class="w-25" type="text" @change.prevent="updateQuantity(selectedService.id)"/>
                                    <input v-else :id="'inputService'+selectedService.id" class="w-25" value="1" type="text" @change.prevent="updateQuantity(selectedService.id)" disabled/>

                                    <button @click.prevent="removeServiceToList(selectedService.id)" class="m-1 btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                        <div class="text-right"> Prix total : 0 €</div>
                    </div>

                    <hr/>

                    <div class="mb-3">
                        <label class="form-label"> Sélectionner un ou plusieurs services </label>
                        <div class="d-flex">
                            <select id="selectService" class="form-select">
                                <option default disabled value=""> Sélectionnez un service </option>
                                
                                <option 
                                    class="d-flex justify-content-between" 
                                    v-for="service in services" 
                                    :value="service.id" 
                                    :key="'selectCreateDisabled'+service.id"
                                    :disabled="isServiceDisabled(service)" 
                                    
                                > 

                                <!-- :disabled="service.onService != 'null' && form.services.indexOf(e => e.name == service.onService) == -1"  -->
                                <!-- form.services.find(service => service.id == service.id) -->

                                    <div>{{ service.id }} - </div>
                                    <div>{{ service.name }} - </div>
                                    <div>{{ service.price }} €</div>
                                </option>

                            </select>
                            <button @click.prevent="addServiceToList" class="btn btn-primary ms-2"> + </button>
                        </div>
                    </div>

                    <hr/>

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
    import { router } from '@inertiajs/vue3'

    export default {
        data() {
            return {
                form: {
                    reference: "test",
                    name: null,
                    status: null,
                    services: [],
                    date: null,
                    quantity: []
                }
            }
        },
        methods : {

            isServiceDisabled(service) {
                return  (service.onService !== 'null' && this.form.services.findIndex(e => e.name === service.onService) === -1)
                        ||
                        (service.isLimited == 1 && this.form.services.findIndex(e => e.name === service.name) > -1);
            },

            // Service list

            addServiceToList(){
                var selectedValue = document.getElementById("selectService").value;
                var service = this.services.find(service => service.id == selectedValue);
                this.form.services.push(service);

                const newQuantity = {
                    'id': selectedValue,
                    'quantity' : 1,
                    'price' : service.price
                }

                this.form.quantity.push(newQuantity);
            },

            removeServiceToList(id){
                const index = this.form.services.findIndex(service => service.id == id)
                if(index > -1){
                    this.form.services.splice(index, 1);
                }
            },

            updateQuantity(id){
                var inputValue = document.getElementById("inputService"+id).value;
                var indexOfQuantity = this.form.quantity.findIndex(quantity => quantity.id == id);
                var orderService = this.form.quantity[indexOfQuantity];

                orderService.quantity = inputValue;
                orderService.price = orderService.price * inputValue;
            },

            // Modal

            closeModal(){
                document.getElementById("createModalClose").click();
                this.form.reference = null;
                this.form.name = null;
                this.form.status = null;
                this.form.date = null;
                this.form.services = null;
            },

            // Submit
 
            submitCreateOrder(){
                router.post(
                    '/bons-de-commande', 
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
        props: ['services'],
        components : {
            Form, 
        },
    }

</script>