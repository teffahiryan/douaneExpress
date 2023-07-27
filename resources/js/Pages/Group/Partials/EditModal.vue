<template>
    <div class="modal fade modal-lg" :id="'editModal'+id" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Modifier le groupe : {{ group.name }} </h1>
            <button :id="'editModalClose'+id" @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form :id="'editForm'+id" @submit.prevent="submitEditGroup" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"> Nom </label>
                        <input type="text" class="form-control" v-model="form.name">
                        <div class="text-danger mt-2" v-if="errors.name">{{ errors.name }}</div>
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
        props: ['id', 'group'],
        data() {
            return {
                form: {
                    // J'intègre la méthode PUT ici, car la méthode PUT ne fonctionne pas avec les fichiers
                    _method: 'put',
                    name: this.group.name,
                },
                errors: []
            }
        },
        methods : {

            // Modal

            closeModal(){
                document.getElementById("editModalClose"+this.id).click();
                this.errors = [];
            },

            submitEditGroup(){
                router.post(
                    '/group/'+this.id, 
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