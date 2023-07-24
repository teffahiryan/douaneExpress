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
                    
                    <!-- Date -->

                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date" :min="currentDate">
                        <div class="text-danger mt-2" v-if="errors.date">{{ errors.date }}</div>
                    </div>

                    <hr/>

                    <!-- Services -->

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
                        <label class="form-label"> Sélectionnez un ou plusieurs services </label>
                        <div class="d-flex justify-content-center">
                            <div class="w-75">
                                <div id="selectService" role="button" class="form-select p-2 user-select-none position-relative" @click="displayOptions">
                                    Sélectionnez un service
                                </div>
                                <div id="serviceOptionList" class="d-none w-75 p-2 position-absolute bg-white border rounded" style="z-index: 2;">
                                    <input id="inputOptionCreate" type="text" class="form-control" placeholder="Rechercher..." @keydown="searchOption($event)">
                                    <option
                                        :id="'option'+service.id"
                                        role="button"
                                        class="d-flex justify-content-between m-2" 
                                        v-for="service in serviceList" 
                                        :value="service.id" 
                                        :key="'selectCreateDisabled'+service.id"
                                        :disabled="isServiceDisabled(service)" 
                                        @click="selected('option'+service.id)"
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

    export default {
        props: ['services', 'currentDate'],
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
                totalValue: 0.0,
                errors: [],
                searchKey: "",
                serviceList: this.services,
            }
        },
        mounted(){

        },
        methods : {

            // ****************** Select ******************


                // Affichage ou non des options du select
                displayOptions(){
                    var serviceOptionList = document.getElementById("serviceOptionList");
                    if(serviceOptionList.classList.contains("d-none")){
                        serviceOptionList.classList.remove("d-none");
                    }else{
                        serviceOptionList.classList.add("d-none");
                    }
                },

                // Méthode qui permet de sélectionner le service cliqué
                selected(id){

                    var serviceOptionList = document.getElementById("serviceOptionList");
                    var input = document.getElementById("inputOptionCreate");
                    var selectService = document.getElementById("selectService");

                    // Je récupère le service en question
                    var service = this.services.find(service => service.id == document.getElementById(id).value);

                    // Si l'option est disable je ne sélectionne pas
                    if(!this.isServiceDisabled(service)){
                        // Je ferme la liste des options du select
                        serviceOptionList.classList.add("d-none");

                        // J'entre ensuite dans le select le service sélectionné et lui passe l'id en valeur pour la transmission du service en cas d'ajout
                        selectService.value = service.id;
                        selectService.innerHTML = service.name;

                        // Reset services list options
                        input.value = "";
                        this.serviceList = this.services;
                    }
                },

                // Méthode pour le fonctionnement de la barre de recherche dans le select
                searchOption(event){
                    // J'ajoute dans la liste des options qui seront dans le select, les services qui correspondent à la valeur entrée dans l'input
                    // J'ai créé ici une liste spécifique à la liste des options car une fois les services filtré ils ne seront plus récupèrable
                    this.serviceList = this.services.filter(service => service.name.toLowerCase().includes(event.target.value.toLowerCase()));
                },


            // ****************** Disable options ******************

                // Méthode qui permet de disable les options selon plusieurs critères
                isServiceDisabled(service) {
                            // Si le service possède un service supérieur et que le service supérieur n'est pas dans la liste des services sélectionné -> disabled
                    return  (service.onService !== 'null' && this.form.services.findIndex(e => e.name === service.onService) === -1)
                            ||
                            // Si le service est limité à une commande et qu'il est déjà dans la liste des services sélectionné -> disabled
                            (service.isLimited == 1 && this.form.services.findIndex(e => e.name === service.name) > -1)
                            ||
                            // Si le service est déjà sélectionné -> disabled
                            (this.form.services.findIndex(e => e.name === service.name) > -1);
                },


            // ****************** Service list ******************

                // Ajout du service sélectionné dans la liste des services sélectionné
                addServiceToList(){
                    var selectService = document.getElementById("selectService");
                    var selectedValue = selectService.value;

                    if(selectedValue != ""){
                        // Je récupère le service via le value du select
                        var service = this.services.find(service => service.id == selectedValue);
                        // Je l'ajoute dans la liste des services sélectionné
                        this.form.services.push(service);

                        // Création des informations de pivot 
                        const newQuantity = {
                            'id': selectedValue,
                            'quantity' : 1,
                            'price' : service.price
                        }
                        this.form.quantity.push(newQuantity);

                        // Je met à jour le prix total
                        this.totalPrice();

                        // ResetSelectService
                        selectService.innerHTML = "Sélectionnez un service";
                        selectService.value = null;
                    }
                },


                // Suppression du service de la liste des services sélectionné
                removeServiceToList(id){
                    const index = this.form.services.findIndex(service => service.id == id);
                    const indexQuantity = this.form.quantity.findIndex(element => element.id == id);

                    // Si le service est bien trouvé je le retire avec la méthode splice
                    if(index > -1){
                        this.form.services.splice(index, 1);
                        this.form.quantity.splice(indexQuantity, 1);
                    }

                    // Je met à jour le prix total
                    this.totalPrice();
                },


                // Je met à jour la quantité du service
                updateQuantity(id){
                    var inputValue = document.getElementById("inputService"+id).value;
                    var indexOfQuantity = this.form.quantity.findIndex(quantity => quantity.id == id);

                    // Je récupère les informations pivot en question
                    var orderService = this.form.quantity[indexOfQuantity];

                    // Je lui insère les nouvelles valeurs
                    orderService.quantity = inputValue;
                    orderService.price = parseFloat(orderService.price);

                    // Je met à jour le prix total
                    this.totalPrice();
                },

                // Méthode qui permet de mettre à jour le prix total
                totalPrice(){
                    this.totalValue = 0;
                    this.form.quantity.forEach(element => {
                        this.totalValue += parseFloat(element.price * element.quantity);
                    });
                },


            // ****************** Modal ******************


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


            // ****************** Submit ******************
 

                submitCreateOrder(){
                    router.post(
                        '/bons-de-commande', 
                        this.form,
                        {
                            onSuccess: (page) => {
                                this.closeModal();
                            },
                            onError: (errors) => {
                                this.errors = errors
                            },
                        }
                    );
                },
        },
    }

</script>