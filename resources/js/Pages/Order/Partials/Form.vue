<template>
    <form>

    <div class="mb-3">
        <label class="form-label"> Date </label>
        <input type="date" class="form-control">
    </div>

    <hr/>

    <div>
        <div>Liste des services</div>
        <p class="my-3"> Aucun service</p>
    </div>

    <hr/>

    <div class="mb-3">
        <label class="form-label"> Sélectionner un service </label>
        <select class="form-control">
            <option value="">--Sélectionner un service--</option>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select>
    </div>

    <hr/>

    <div class="mb-3">
        <fieldset>
            <legend> Status </legend>

            <div>
            <input type="radio" id="huey" name="drone" value="huey"
                    checked>
            <label for="huey">Oui</label>
            </div>

            <div>
            <input type="radio" id="dewey" name="drone" value="dewey">
            <label for="dewey">Non</label>
            </div>
        </fieldset>
    </div>
</form>
</template>