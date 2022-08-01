<template>
    <router-link :to="{ name: 'details', params: { id: internalPost.id } }">
        <h3>{{ internalPost.title }}</h3>
    </router-link>
    <p>{{ createSnippet }}</p>
</template>
<script>
export default {
    props: ["post"],
    data() {
        return {
            internalPost: {
                ...this.post,
            },
        };
    },
    computed: {
        createSnippet() {
            return this.internalPost.body.substring(0, 100) + "....";
        },
    },
};
</script>
<style></style>
