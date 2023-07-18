<template>
    <div>
        <h1>Bons de commandes</h1>

        <div class="alert alert-success my-2" v-if="$page.props.flash.message"> {{ $page.props.flash.message }} </div>

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Créer un bon
        </button>
        <CreateModal :services="services"/>

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
                <tr v-for="order in orders" :key="order.id">
                    <th scope="row">{{ order.id }}</th>
                    <td>{{ order.reference }}</td> 
                    <td>{{ order.price }} €</td>
                    <td>{{ order.date }}</td>
                    <td> {{ order.status == 1 ? "Ouvert" : "Fermé" }}</td>
                    <td>
                        <button class="m-1 btn btn-info text-light" data-bs-toggle="modal" v-bind:data-bs-target="'#showModal' + order.id">
                            <i class="fas fa-eye"></i>
                        </button>
                        <ShowModal :id="order.id" :order="order" :services="services"/>

                        <button v-if="order.status == 1" class="m-1 btn btn-secondary text-light" data-bs-toggle="modal" v-bind:data-bs-target="'#editModal' + order.id">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <EditModal :id="order.id" :order="order" :services="services"/>
                        
                        <button class="m-1 btn btn-danger" data-bs-toggle="modal" v-bind:data-bs-target="'#deleteModal' + order.id">
                            <i class="fas fa-trash"></i>
                        </button>
                        <DeleteModal :id=order.id />
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
    import ShowModal from './Partials/ShowModal.vue';

    export default {
        components : {
            CreateModal, 
            EditModal,
            DeleteModal,
            ShowModal
        },
        props: {
            orders: Array,
            services: Array
        },
        computed: {
            console: () => "console"
        },
    }

</script>

