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

                    <div class="mb-3">
                        <label class="form-label"> Référence </label>
                        <div> {{ order.reference }} </div>
                    </div>

                    <hr/>

                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date" :min="currentDate">
                        <div class="text-danger mt-2" v-if="errors.date">{{ errors.date }}</div>
                    </div>

                    <hr/>

                    <!-- Liste des services sélectionné -->

                    <div>
                        <div>Liste des services</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between" v-for="selectedService in form.services" :key="'selected'+selectedService.id">
                                <div>{{ selectedService.name }} - {{ selectedService.price }} € </div>
                                <div>
                                
                                    <!-- Not limited -->
                                    <input  v-if="selectedService.isLimited == 0" 
                                            :id="'inputService'+order.id+selectedService.id" 
                                            value="1"
                                            min="1" 
                                            class="w-25" 
                                            type="number" 
                                            @change.prevent="updateQuantity(selectedService.id)"
                                    />
                                    <!-- Limited -->
                                    <input v-else :id="'inputService'+order.id+selectedService.id" class="w-25" value="1" type="number" @change.prevent="updateQuantity(selectedService.id)" disabled/>

                                    <button @click.prevent="removeServiceToList(selectedService.id)" type="button" class="m-1 btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                        <div class="text-right"> Prix total : {{ totalValue }} €</div>
                    </div>
 
                    <hr/>

                    <!-- Sélection des services -->

                    <div class="mb-3">
                        <label class="form-label"> Sélectionnez un ou plusieurs services </label>
                        <div class="d-flex justify-content-center">
                            <div class="w-75">
                                <div :id="'selectService'+id" role="button" class="form-select p-2 user-select-none position-relative" @click="displayOptions">
                                    Sélectionnez un service
                                </div>
                                <div :id="'serviceOptionList'+id" class="d-none w-75 p-2 position-absolute bg-white border rounded" style="z-index: 2;">
                                    <input :id="'inputOptionCreate'+id" type="text" class="form-control" placeholder="Rechercher..." @keydown="searchOption($event)">
                                    <option
                                        :id="'option'+id+service.id"
                                        role="button"
                                        class="d-flex justify-content-between m-2" 
                                        v-for="service in serviceList" 
                                        :value="service.id" 
                                        :key="'selectCreateDisabled'+service.id"
                                        :disabled="isServiceDisabled(service)" 
                                        @click="selected('option'+id+service.id)"
                                    >
                                        <div>{{ service.reference }} </div>
                                        <div>{{ service.name }} </div>
                                        <div>{{ service.price }} €</div>
                                    </option>
                                </div>
                            </div>
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

    import Form from './Form.vue';
    import { router } from '@inertiajs/vue3'

    export default {
        props: ['id', 'order', 'services'],
        components : {
            Form, 
        },
        data() {
            return {
                form: {
                    name: this.order.name,
                    status: this.order.status,
                    price: this.order.price,
                    services: this.order.services,
                    date: this.order.date,
                    quantity: [],
                },
                totalValue: this.order.price,
                errors: [],
                currentDate: "",
                searchKey: "",
                serviceList: this.services,
            }
        },
        beforeMount(){
            this.order.services.forEach(element => {
                this.form.quantity.push(

                    {
                        'id': element.id,
                        'quantity': element.pivot.quantity,
                        'price': element.pivot.price
                    }

                );
            });
        },
        mounted(){
            this.order.services.forEach(element => {
                document.getElementById("inputService"+this.order.id+element.id).value = element.pivot.quantity;
            });

            var date = new Date();
            this.currentDate += date.getFullYear()+"-";
            date.getMonth() < 10 ? this.currentDate += "0"+(date.getMonth()+1)+"-" : this.currentDate += date.getMonth()+1+"-";
            date.getDate() < 10 ? this.currentDate += "0"+date.getDate()+"-" : this.currentDate += date.getDate();
        },
        methods : {

            // Select

            displayOptions(){
                var serviceOptionList = document.getElementById("serviceOptionList"+this.id);
                if(serviceOptionList.classList.contains("d-none")){
                    serviceOptionList.classList.remove("d-none");
                }else{
                    serviceOptionList.classList.add("d-none");
                }
            },

            selected(id){
                var serviceOptionList = document.getElementById("serviceOptionList"+this.id);
                var input = document.getElementById("inputOptionCreate"+this.id);
                var selectService = document.getElementById("selectService"+this.id);
                var service = this.services.find(service => service.id == document.getElementById(id).value);
                serviceOptionList.classList.add("d-none");
                selectService.value = service.id;
                selectService.innerHTML = service.name;
                // Reset services list options
                input.value = "";
                this.serviceList = this.services;
            },

            searchOption(event){
                this.serviceList = this.services.filter(service => service.name.toLowerCase().includes(event.target.value.toLowerCase()));
            },

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
                var selectService = document.getElementById("selectService"+this.id);
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

                    
                    // ResetSelectService
                    selectService.innerHTML = "Sélectionnez un service";
                    selectService.value = null;
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
                // Je récupère la valeur de l'input quantity
                var inputValue = document.getElementById("inputService"+this.order.id+id).value;
                // Je récupère l'index de l'objet quantity du service
                var indexOfQuantity = this.form.quantity.findIndex(quantity => quantity.id == id);
                // Je récupère l'objet quantity du service
                var orderService = this.form.quantity[indexOfQuantity];

                // Je lui change suite la valeur de quantité
                orderService.quantity = inputValue;
                // Le prix
                orderService.price = parseFloat(orderService.price);

                this.totalPrice();
            },

            totalPrice(){
                this.totalValue = 0;
                this.form.quantity.forEach(element => {
                    this.totalValue += parseFloat(element.price * element.quantity);
                });
                this.form.price = 0;
                this.form.quantity.forEach(element => {
                    this.form.price += parseFloat(element.price * element.quantity);
                });
            },

            // Modal

            closeModal(){
                document.getElementById("editModalClose"+this.id).click();
                // document.getElementById("selectService").value = "";
            },

            // Submit

            submitUpdateOrder(){
                router.put(
                    '/bons-de-commande/'+this.id, 
                    this.form,
                    {
                        onSuccess: (page) => {
                            this.closeModal();
                            console.log("test success");
                        },
                        onError: (errors) => {errors},
                    }
                );
            },

        },
    }

</script>