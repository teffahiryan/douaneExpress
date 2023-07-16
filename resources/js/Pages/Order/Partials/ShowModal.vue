<!-- <template>
    <div class="modal fade modal-lg" :id="'showModal'+id" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="showModalLabel">Bons de commande REF : {{ order.reference }} </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="mb-4">
                    <h2 class="mb-3"> Informations </h2>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="fw-bold">Référence</span> : {{ order.reference }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Date</span> : {{ order.date }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Status</span> : {{ order.status == 1 ? "Ouvert" : "Fermé" }}
                        </li>
                    </ul>
                </div>
 
                <div class="mb-4">
                    <h2 class="mb-3"> Liste des services </h2>
                    <ul class="list-group mb-3">
                        <li class="list-group-item" v-for="service in order.services" :key="'orderService'+id+service.id">
                            {{ service.name }} - {{ service.price }} € - x{{ service.pivot.quantity }}
                        </li>
                    </ul>
                    <div>Prix total : {{ order.price }} € </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Fermer</button>
            </div>
        </div>
        </div>
    </div>
</template>  

<script>
import Header from '../../../Layouts/Partials/Header.vue'

    export default {
        components: { Header },
        props: ['id', 'order', 'services'],
    }

</script> -->