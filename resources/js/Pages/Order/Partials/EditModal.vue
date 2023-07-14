<template>
    <div class="modal fade modal-lg" :id="'editModal'+id" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Modifier un bon</h1>
            <button :id="'editModalClose'+id" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" @submit.prevent="submitUpdateOrder">
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
                                    <input :id="'inputService'+selectedService.id" class="w-25" type="text" @change.prevent="updateQuantity(selectedService.id)"/>
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
                                <option disabled value=""> Sélectionnez un service </option>
                                <option class="d-flex justify-content-between" v-for="service in services" :value="service.id" :key="'selectCreate'+service.id"> 
                                    <div>{{ service.id }} </div>
                                    <div>{{ service.name }}</div>
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
                                <input type="radio" v-model="form.status" :value="0">
                                <label class="ms-2" for="huey">Fermé</label>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button form="updateForm" type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>

    import Form from './Form.vue';

    export default {
        props: ['id', 'order', 'services'],
        data() {
            return {
                form: {
                    reference: null,
                    name: this.order.name,
                    status: this.order.status,
                    services: null,
                    date: this.order.date
                }
            }
        },
        methods : {

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

            // Modal

            closeModal(){
                document.getElementById("createModalClose"+this.id).click();
            },

            // Submit

            submitUpdateOrder(){
                router.put(
                    '/bons-de-commande/'+this.id, 
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
        components : {
            Form, 
        },
    }

</script>