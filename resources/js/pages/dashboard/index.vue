<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="container-fluid d-flex flex-column align-items-center">
            <div class="w-100">
                <h2 class="text-start">Dashboard</h2>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Post #</th>
                        <th scope="col">Post Title</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts" :key="post.id">
                        <td>{{ post.id }}</td>
                        <td>{{ post.title }}</td>
                        <td>
                            <div class="container">
                                <router-link
                                    :to="{
                                        name: 'details',
                                        params: { id: post.id },
                                    }"
                                    class="btn btn-success w-100 m-2"
                                >
                                    VIEW
                                </router-link>
                                <router-link
                                    :to="{
                                        name: 'modifyPost',
                                        params: { id: post.id, method: 'edit' },
                                    }"
                                    class="btn btn-warning w-100 m-2"
                                >
                                    EDIT
                                </router-link>
                                <router-link
                                    :to="{ name: 'login' }"
                                    class="btn btn-danger w-100 m-2"
                                >
                                    DELETE
                                </router-link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import Navbar from "../../components/Navbar.vue";
export default {
    data() {
        return {
            posts: {},
        };
    },
    mounted() {
        this.getPosts();
    },
    computed: {},
    methods: {
        async getPosts() {
            // const url = `${process.env.MIX_APP_URL}/api/posts/`;
            const url = `${process.env.MIX_APP_URL}/api/getAllPosts/`;
            const posts = await axios(url, {
                method: "get",
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    // console.log(response.data.data);
                    this.posts = response.data.data;
                    // return response.data.data;
                })
                .catch((e) => {
                    // console.log(JSON.stringify(e));
                    console.log(JSON.stringify(e.response.data.message));
                });

            // this.posts = posts;
        },
    },
    components: {
        Navbar,
    },
};
</script>
<style scoped>
.btn {
    max-width: 150px;
}
</style>
