<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Créer un bon</h1>
            <button id="createModalClose" @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" @submit.prevent="submitCreateOrder" onkeydown="return event.key != 'Enter';">
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
                                    
                                    <input v-if="selectedService.isLimited == 0" :id="'inputService'+selectedService.id" value="1" min="1" class="w-25" type="number" @change.prevent="updateQuantity(selectedService.id)"/>
                                    <input v-else :id="'inputService'+selectedService.id" class="w-25" value="1" type="number" @change.prevent="updateQuantity(selectedService.id)" disabled/>

                                    <button @click.prevent="removeServiceToList(selectedService.id)" type="button" class="m-1 btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                        <div class="text-right"> Prix total : {{ totalValue }} €</div>
                    </div>

                    <hr/>
 
                    <div class="mb-3">
                        <label class="form-label"> Sélectionner un ou plusieurs services </label>
                        <div class="d-flex">
                            <select id="selectService" class="form-select">
                                <option id="defaultOption" selected disabled value=""> Sélectionnez un service </option>
                                
                                <option 
                                    class="d-flex justify-content-between" 
                                    v-for="service in services" 
                                    :value="service.id" 
                                    :key="'selectCreateDisabled'+service.id"
                                    :disabled="isServiceDisabled(service)" 
                                    
                                > 
                                    <div>{{ service.id }} - </div>
                                    <div>{{ service.name }} - </div>
                                    <div>{{ service.price }} €</div>
                                </option>

                            </select>
                            <button @click.prevent="addServiceToList" type="button" class="btn btn-primary ms-2"> + </button>
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
                    status: 0,
                    price: 0.0,
                    services: [],
                    date: null,
                    quantity: []
                },
                totalValue: 0.0
            }
        },
        methods : {

            // Disable options

            isServiceDisabled(service) {
                        // Si le service possède un service supérieur et que le service supérieur n'est pas dans la liste des services sélectionné -> disabled
                return  (service.onService !== 'null' && this.form.services.findIndex(e => e.name === service.onService) === -1)
                        ||
                        // Si le service est limité à une commande et qu'il est déjà dans la liste des services sélectionné -> disabled
                        (service.isLimited == 1 && this.form.services.findIndex(e => e.name === service.name) > -1);
            },

            // Service list

            addServiceToList(){
                var selectService = document.getElementById("selectService");
                var selectedValue = selectService.value;

                if(selectedValue != ""){
                    var service = this.services.find(service => service.id == selectedValue);
                    this.form.services.push(service);

                    const newQuantity = {
                        'id': selectedValue,
                        'quantity' : 1,
                        'price' : service.price
                    }

                    this.form.quantity.push(newQuantity);

                    this.totalPrice();
                }
            },

            removeServiceToList(id){
                const index = this.form.services.findIndex(service => service.id == id);
                const indexQuantity = this.form.quantity.findIndex(element => element.id == id);

                if(index > -1){
                    this.form.services.splice(index, 1);
                    this.form.quantity.splice(indexQuantity, 1);
                }

                this.totalPrice();
            },

            updateQuantity(id){
                var inputValue = document.getElementById("inputService"+id).value;
                var indexOfQuantity = this.form.quantity.findIndex(quantity => quantity.id == id);
                var orderService = this.form.quantity[indexOfQuantity];

                orderService.quantity = inputValue;
                orderService.price = parseFloat(orderService.price);

                this.totalPrice();
            },

            totalPrice(){
                this.totalValue = 0;
                this.form.quantity.forEach(element => {
                    this.totalValue += parseFloat(element.price * element.quantity);
                });
            },

            // Modal

            closeModal(){
                document.getElementById("createModalClose").click();
                document.getElementById("selectService").value = "";
                this.form.reference = null;
                this.form.name = null;
                this.form.status = null;
                this.form.date = null;
                this.form.services = [];
                this.form.quantity = [];
                this.totalValue = 0;
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
        computed: {
            
        }
    }

</script>