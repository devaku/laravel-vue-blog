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
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between">

                    <div>
                        <span>Author: {{ post.user_name }}</span>
                    </div>
                    <div>
                        <span>Created at: {{ getDate }}</span>
                    </div>
                </div>
                <div v-if="post.user_id == user.id">
                    <router-link
                        :to="{
                            name: 'modifyPost',
                            params: { id: post.id, method: 'edit' },
                        }"
                        class="d-inline-block btn btn-warning w-100"
                    >
                        EDIT
                    </router-link>
                    <a
                        href="#"
                        @click="handleDelete(post.id)"
                        class="d-inline-block btn btn-danger w-100 mx-2"
                    >
                        DELETE
                    </a>
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
            post: {
                id: 0,
            },
            user: {},
        };
    },
    mounted() {
        const id = this.$route.params.id;
        this.getLoggedIn();
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

        isSameUser() {
            return this.post.user_id == this.user.user_id;
        }
    },
    methods: {
        async getLoggedIn() {
            await axios
                .get("/api/user")
                .then((response) => {
                    this.user = response.data;
                    return;
                })
                .catch(() => {
                    this.user = null;
                    return;
                });
        },
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
<style scoped>
.btn {
    max-width: 250px;
}
</style>
