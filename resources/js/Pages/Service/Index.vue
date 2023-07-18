<template>
    <div>
        <h1>Services</h1>

        <div class="alert alert-success my-2" v-if="$page.props.flash.message"> {{ $page.props.flash.message }} </div>

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Créer un service
        </button>
        <CreateModal :services="services"/>

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
                    <th scope="row">{{ service.id }}</th>
                    <td v-if="service.image != 'null'" class="text-center w-25"> <img :src="'/storage/'+service.image" class="w-50 rounded" /> </td>
                    <td v-else class="text-center"> Aucune image </td>
                    <td>{{ service.reference }}</td>
                    <td>{{ service.name }}</td>
                    <td>{{ service.price }} €</td>
                    <td>{{ service.isLimited }}</td>
                    <td> {{ service.onService }} </td>
                    <td>
                        <button class="btn btn-secondary text-light me-2" data-bs-toggle="modal" v-bind:data-bs-target="'#editModal' + service.id">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <EditModal :id="service.id" :service="service" :services="services"/>
                        <button class="btn btn-danger" data-bs-toggle="modal" v-bind:data-bs-target="'#deleteModal' + service.id">
                            <i class="fas fa-trash"></i>
                        </button>
                        <DeleteModal :id=service.id />
                    </td>
                </tr>
            </tbody>
        </table>
    </div> 
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
            services: Array,
            success: String
        },
        computed: {
            console: () => "console"
        },
    }

</script>
