<template>
    <div>
        <h1>Services</h1>

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Créer un service
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Référence</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prix</th>
                    <th scope="col">isLimited</th>
                    <th scope="col">Sur service</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="service in services" :key="service.id">
                    <th scope="row">1</th>
                    <td>null</td>
                    <td>{{ service.reference }}</td>
                    <td>{{ service.name }}</td>
                    <td>{{ service.price }} €</td>
                    <td>{{ service.isLimited }}</td>
                    <td> {{ service.onService }} </td>
                    <td>
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
        props: {
            services: Array
        }
    }

</script>
