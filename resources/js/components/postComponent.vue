<template>
    <div class="card card-body mb-2" v-for="post in posts" :key="post.id">
        <h3>{{ post.title }}</h3>
        <p>{{ post.body }}</p>
        <hr />
        <button @click="editArticle(post)" class="btn btn-warning mb-2">
            Edit
        </button>
        <button @click="deleteArticle(post.id)" class="btn btn-danger">
            Delete
        </button>
    </div>
</template>
<script>
export default {
    props: ["posts"],
};
</script>
<style></style>
