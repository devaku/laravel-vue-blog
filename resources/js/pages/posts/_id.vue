<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="container-fluid d-flex flex-column">
            <!-- Header -->
            <div>
                <h3>{{ post.title }}</h3>
                <h5>Post #{{ post.id }}</h5>
                <p>{{ post.body }}</p>
            </div>
            <!-- Footer -->
            <div class="d-flex justify-content-between">
                <div>
                    <span>Author: {{ post.user_name }}</span>
                </div>
                <div>
                    <span>Created at: {{ getDate }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import Navbar from "../../components/Navbar.vue";

export default {
    data() {
        return {
            post: {},
        };
    },
    mounted() {
        const id = this.$route.params.id;
        this.getPost(id);
    },

    computed: {
        getDate() {
            let timestamp = Date.parse(this.post.created_at);
            const date = new Date(timestamp);
            const dateString =
                date.getMonth() +
                1 +
                "/" +
                date.getDate() +
                "/" +
                date.getFullYear();

            return dateString;
        },
    },
    methods: {
        async getPost(id) {
            const url = `${process.env.MIX_APP_URL}/api/posts/${id}`;
            const response = await axios(url, {
                method: "get",
                // headers: {
                //     // 'Content-Type': 'multipart/form-data',
                //     Accept: "application/json",
                // },
            })
                .then((response) => {
                    // console.log(response.data.data);
                    return response.data.data;
                })
                .catch((e) => {
                    console.log(e);
                    return null;
                });
            this.post = response;
        },
    },
    components: { Navbar },
};
</script>
<style scoped></style>
