<template>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <a class="navbar-brand" href="/">Douane Express</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bons-de-commandes">Bons de commandes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/groups">Groupes</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <slot/>
    </main>

</template>

<script>
    import { Link } from '@inertiajs/vue3';

    export default {
        components : {
            Link
        },
    }
</script>