<template>
    <div class="modal fade" :id="'deleteModal'+id" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Avertissement</h1>
            <button :id="'deleteModalClose'+id" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Êtes-vous sur de vouloir supprimer ce service ?
                <div class="mt-2">
                    <button class="btn btn-primary mx-1" data-bs-dismiss="modal" aria-label="Close">Non</button>
                    <button @click="submitDeleteService" type="submit" class="btn btn-primary mx-1">Oui</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>

    import { router } from '@inertiajs/vue3'

    export default {
        props: ['id'],
        methods : {

            closeModal(){
                document.getElementById("deleteModalClose"+this.id).click();
            },

            submitDeleteService(){
                router.delete(
                    '/service/'+this.id,
                    {
                        onBefore: visit => {
                            this.closeModal()
                        },

                        onSuccess: (page) => {
                            
                        },
                        onError: (errors) => {
                            alert("error")
                        },
                    }
                );
            }
        }
    }
</script>