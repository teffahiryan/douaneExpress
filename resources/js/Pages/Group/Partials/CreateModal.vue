<template>
    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="createModalLabel">Ajout d'un groupe</h1>
            <button type="button" @click="closeModal" id="createModalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" @submit.prevent="submitCreateGroup">
                    <div class="mb-3">
                        <label class="form-label"> Nom </label>
                        <input type="text" class="form-control" v-model="form.name">
                        <div class="text-danger mt-2" v-if="errors.name">{{ errors.name }}</div>
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
        data() {
            return {
                form: {
                    name: null,
                },
                errors: [],
            }
        },
        methods : {

            // Modal

            closeModal(){
                document.getElementById("createModalClose").click();
                this.errors = [];
                this.form.name = null;
            },

            // Submit

            submitCreateGroup(){
                router.post(
                    '/group', 
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