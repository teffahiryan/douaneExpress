<template>
    
    <header>
        <h1> Douane Express</h1>
        <ul>
            <li> <Link href="/">Accueil</Link> </li>
            <li> <Link href="/services">Service</Link> </li>
            <li> <Link href="/bons-de-commandes">Bons de commandes</Link> </li>
        </ul>
    </header>

    <main>
        <slot/>
    </main>

</template>

<script>
    import { Link } from '@inertiajs/vue3'

    export default {
        components : {
            Link
        }
    }
</script>