<template>
    <div class="modal fade modal-lg" :id="'editModal'+id" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Modifier le service : {{ service.reference }} </h1>
            <button :id="'editModalClose'+id" @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form :id="'editForm'+id" @submit.prevent="submitEditService" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"> Référence </label>
                        <input type="text" class="form-control" v-model="form.reference">
                        <div class="text-danger mt-2" v-if="errors.reference">{{ errors.reference }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Nom </label>
                        <input type="text" class="form-control" v-model="form.name">
                        <div class="text-danger mt-2" v-if="errors.name">{{ errors.name }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Prix </label>
                        <input type="text" class="form-control" v-model="form.price">
                        <div class="text-danger mt-2" v-if="errors.price">{{ errors.price }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Image </label>
                        <div class="d-flex">
                            <input :id="'editFile'+id" type="file" @input="form.image = $event.target.files[0]" class="form-control">
                            <button type="button" class="btn btn-danger ms-2" @click.prevent="removeFile"> <i class="fa fa-times"></i> </button>
                        </div>
                        <div class="text-danger mt-2" v-if="errors.image">{{ errors.image }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Quantité Maximale </label>
                        <input type="text" class="form-control" v-model="form.maxQuantity">
                        <div class="text-danger mt-2" v-if="errors.maxQuantity">{{ errors.maxQuantity }}</div>
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label"> Groupe </label>
                        <select class="form-select" v-model="form.group_id">
                            <option disabled value="null"> Sélectionnez un groupe </option>
                            <option v-for="group in groups" :value="group.id" :key="'select'+group.id"> {{ group.name }} </option>
                        </select>
                        <div class="mt-2 fst-italic">Le sur service permettra à ce que ce service ne soit pas sélectionnable tant que le service supérieur n'a pas été sélectionné dans la commande.</div>
                        <div class="text-danger mt-2" v-if="errors.group">{{ errors.group }}</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button :form="'editForm'+id" type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>

    import { router } from '@inertiajs/vue3'

    export default {
        props: ['id', 'service', 'groups'],
        data() {
            return {
                form: {
                    // J'intègre la méthode PUT ici, car la méthode PUT ne fonctionne pas avec les fichiers
                    _method: 'put',
                    reference: this.service.reference,
                    name: this.service.name,
                    price: this.service.price,
                    maxQuantity: this.service.maxQuantity,
                    image: this.service.image,
                    group_id: this.service.group_id,
                    isLimited: 0,
                    onService: "null"
                },
                errors: []
            }
        },
        methods : {

            // File

            removeFile(){
                this.form.image = "null";
                document.getElementById("editFile"+this.id).value = null;
            },

            // Modal

            closeModal(){
                document.getElementById("editModalClose"+this.id).click();
                this.errors = [];
            },

            submitEditService(){
                router.post(
                    '/service/'+this.id, 
                    this.form,
                    {
                        onSuccess: (page) => {
                            this.closeModal();
                        },
                        onError: (errors) => {this.errors = errors},
                    }
                );
            },

        },
    }

</script>