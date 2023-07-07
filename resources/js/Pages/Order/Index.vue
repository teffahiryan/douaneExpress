<template>
    <div>
        <h1>Bons de commandes</h1>
        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Créer un bon
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Référence</th>
                    <th scope="col">Prix total</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>50€</td>
                    <td>22/05/2000</td>
                    <td> Ouvert </td>
                    <td>
                        <a class="btn btn-info text-light me-2">Voir</a>
                        <button class="btn btn-secondary text-light me-2" data-bs-toggle="modal" data-bs-target="#editModal">
                            Modifier
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Supprimer
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <CreateModal/>
    <EditModal/>
    <DeleteModal/>

</template>

<script>

    import CreateModal from './Partials/CreateModal.vue';
    import EditModal from './Partials/EditModal.vue';
    import DeleteModal from './Partials/DeleteModal.vue';

    export default {
        components : {
            CreateModal, 
            EditModal,
            DeleteModal,
        },
    }

</script>

