<template>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Avertissement</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Êtes-vous sur de vouloir supprimer ce bon ?
                <div class="mt-2">
                    <button class="btn btn-primary mx-1" data-bs-dismiss="modal" aria-label="Close">Non</button>
                    <a href="#" class="btn btn-primary mx-1">Oui</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>  