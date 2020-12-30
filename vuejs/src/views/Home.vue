<template>
    <div class="home">
        <notes/>
    </div>
</template>

<script>
    // @ is an alias to /src
    import Notes from "../components/Notes"
    // import Card from "../components/Card";
    export default {
        name: 'Home',
        components: {
            Notes,
            // Card
        }
    }
</script>
