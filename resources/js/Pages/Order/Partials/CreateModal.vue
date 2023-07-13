<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Créer un bon</h1>
            <button id="createModalClose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label"> Date </label>
                        <input type="date" class="form-control" v-model="form.date">
                    </div>

                    <hr/>

                    <div>
                        <div>Liste des services</div>
                        <p class="my-3"> Aucun service</p>
                    </div>

                    <hr/>

                    <div class="mb-3">
                        <label class="form-label"> Sélectionner un ou plusieurs services </label>
                        <select class="form-select" v-model="form.services" multiple>
                            <option disabled value=""> Sélectionnez un service </option>
                            <option class="d-flex justify-content-between" v-for="service in services" :value="service.name" :key="'select'+service.id"> 
                                <div>{{ service.name }}</div>
                                <div>{{ service.price }} €</div>
                            </option>
                        </select>
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
            <button type="button" class="btn btn-primary">Créer</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>

    import Form from './Form.vue';

    export default {
        data() {
            return {
                form: {
                    reference: "test",
                    name: null,
                    status: null,
                    services: null,
                    date: null
                }
            }
        },
        methods : {
            closeModal(){
                document.getElementById("createModalClose").click();
                this.form.reference = null;
                this.form.name = null;
                this.form.status = null;
                this.form.date = null;
                this.form.services = null;
            },

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