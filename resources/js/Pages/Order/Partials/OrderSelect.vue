<template>
    
    <div>
        <div>Liste des services</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between" v-for="service in formServicesList" :key="'selected'+service.id">
                <div>{{ service.name }} - {{ service.price }} € </div>
                <div>
                    <input min="1" class="w-25" type="number" v-model="service.pivot.quantity"/>
                    <button @click.prevent="remove(service)" type="button" class="m-1 btn btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </li>
        </ul>
        <div class="text-right"> Prix total : {{ price }} €</div>
    </div>

    <hr/>

    <div class="mb-3">
        <label class="form-label"> Sélectionnez un ou plusieurs services </label>
        <div class="d-flex justify-content-center">
            <div class="w-75">

                <div
                    role="button" 
                    class="form-select p-2 user-select-none position-relative" 
                    @click="displayOptions.display > 0 ? displayOptions.display = 0 : displayOptions.display = 1"
                >
                    {{ selectedServiceName }}
                </div>

                <div class="w-75 p-2 position-absolute bg-white border rounded" :class="displayOptions.display > 0 || 'd-none' " style="z-index: 2;">
                    <input 
                        id="inputOptionCreate" 
                        type="text" class="form-control" 
                        placeholder="Rechercher..." 
                        v-model="searchValue"
                    >
                    
                    <option
                        role="button"
                        class="d-flex justify-content-between m-2" 
                        v-for="service in filteredServiceList" 
                        :value="service.id" 
                        :key="'selectCreateDisabled'+service.id"
                        @click="selectedService = service, selectedServiceName = service.name, displayOptions.display = 0"
                    >
                        <div>{{ service.reference }} </div>
                        <div>{{ service.name }} </div>
                        <div>{{ service.price }} €</div>
                    </option>
                </div>
            </div>
            <button @click.prevent="add" type="button" class="btn btn-primary ms-2"> + </button>
        </div>
        </div>

</template>

<script>
    export default {
        props: {
            services: Array,
            formServicesList: Array,
            price: Number
        },
        data() {
            return {
                displayOptions : {
                    display: Boolean,
                    default: 0,
                },

                selectedServiceName : "Sélectionnez un service",
                selectedService : [],

                searchValue : "",
                filteredServiceList: this.services,
            }
        },
        methods: {

            add(){
                var newService = Object.assign({}, this.selectedService);
                console.log(newService);
                newService.pivot = {
                    quantity: 1
                }
                newService.index = this.formServicesList.length;
                this.formServicesList.push(newService);
                this.selectedServiceName = "Sélectionnez un service";

                this.$emit('getTotalPrice');
            },

            remove(service){
                var index = this.formServicesList.map(e => e.index).indexOf(service.index);
                index >= 0 ? this.formServicesList.splice(index, 1) : '';
            },

        },
        computed: {
            searchAssignments(){
                this.filteredServiceList = this.services.filter(service => service.name.toLowerCase().includes(this.searchValue.toLowerCase()));
            }
        }
    }
</script>