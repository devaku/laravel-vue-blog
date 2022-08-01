<template>
    <div>POST PAGE</div>
    <button @click="editArticle(post)" class="btn btn-warning mb-2">
        Edit
    </button>
    <button @click="deleteArticle(post.id)" class="btn btn-danger">
        Delete
    </button>
</template>
<script>
export default {
    props: ["post"],
};
</script>
<style scoped></style>
