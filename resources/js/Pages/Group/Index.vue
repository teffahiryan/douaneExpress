<template>
    <div>
        <h1>Groupes</h1>

        <div class="alert alert-success my-2" v-if="$page.props.flash.message"> {{ $page.props.flash.message }} </div>

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Créer un groupe
        </button>
        <CreateModal :groups="groups"/>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="group in groups" :key="group.id">
                    <th scope="row">{{ group.id }}</th>
                    <td>{{ group.name }}</td>
                    <td>
                        <button class="btn btn-secondary text-light me-2" data-bs-toggle="modal" v-bind:data-bs-target="'#editModal' + group.id">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <EditModal :id="group.id" :group="group" :groups="groups"/>
                        <button class="btn btn-danger" data-bs-toggle="modal" v-bind:data-bs-target="'#deleteModal' + group.id">
                            <i class="fas fa-trash"></i>
                        </button>
                        <DeleteModal :id=group.id />
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
            groups: Array,
            // Les messages flash sont directement configuré depuis un seul fichier : "HandleInertiaRequests"
            success: String
        },
        computed: {
            console: () => "console"
        },
    }

</script>
