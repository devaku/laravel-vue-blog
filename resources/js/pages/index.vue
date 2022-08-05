<template>
    <Navbar></Navbar>

    <div class="posts-form container" v-if="user">
        <h2 class="text-center">Share what's on your mind.</h2>
        <form @submit.prevent="createPost" action="" class="mb-3">
            <div class="form-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Title"
                    v-model="post.title"
                />
            </div>
            <div class="form-group mb-3">
                <textarea
                    class="form-control"
                    name="body"
                    id=""
                    rows="3"
                    placeholder="Body"
                    v-model="post.body"
                ></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
    <div class="container" v-else>
        <h2 class="text-center">See what everyone else has been posting :D</h2>
    </div>
    <!-- Pagination -->
    <div class="container my-5">
        <ul class="pagination justify-content-center">
            <li
                :class="[{ disabled: !pagination.prev_page_url }]"
                class="page-item"
                @click="
                    pagination.prev_page_url &&
                        fetchPosts(pagination.prev_page_url)
                "
            >
                <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link text-dark" href="#"
                    >Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}</a
                >
            </li>
            <li
                :class="[{ disabled: !pagination.next_page_url }]"
                class="page-item"
                @click="
                    pagination.next_page_url &&
                        fetchPosts(pagination.next_page_url)
                "
            >
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </div>
    <!-- Posts Content -->
    <div class="container mb-5">
        <div class="card card-body mb-2" v-for="post in posts" :key="post.id">
            <postComponent :post="post"></postComponent>
        </div>
        <div v-if="posts.length < 0">
            <h2 class="text-center">There are no posts available</h2>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
import postComponent from "../components/postComponent.vue";

export default {
    data() {
        return {
            post: {
                title: null,
                body: null,
            },
            posts: [],
            pagination: {},
            user: null,
        };
    },
    mounted() {
        this.fetchPosts();
        this.getLoggedIn();
    },
    components: { Navbar, postComponent },
    methods: {
        async getLoggedIn() {
            // Get CSRF Cookie
            let url = `${process.env.MIX_APP_URL}/sanctum/csrf-cookie`;
            await axios(url, {
                method: "get",
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    // console.log(response.data);
                })
                .catch((e) => {
                    // console.log(JSON.stringify(e));
                    console.log(JSON.stringify(e.response));
                });

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
        async fetchPosts(pageUrl) {
            let fetchUrl = pageUrl
                ? pageUrl
                : `${process.env.MIX_APP_URL}/api/posts`;

            axios
                .get(fetchUrl)
                .then((response) => response.data)
                .then((response) => {
                    this.posts = response.data;
                    // this.posts = [];
                    this.makePagination(response.meta, response.links);
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        makePagination(meta, links) {
            this.pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };
        },

        async createPost() {},
    },
};
</script>
<style scoped>
.posts-form {
    max-width: 500px;
}
</style>
