<template>
    <Navbar></Navbar>
    <div class="container">
        <h3>{{ method }} Post</h3>
        <div class="container error-holder my-3" v-show="formError">
            <div class="card border-danger mb-3">
                <div class="card-header text-danger border-danger">Error</div>
                <div class="card-body">
                    <p class="card-text">{{ formError }}</p>
                </div>
            </div>
        </div>
        <form @submit.prevent="handleForm" action="" class="mb-3">
            <div class="form-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Title"
                    required
                    v-model="post.title"
                />
            </div>
            <div class="form-group mb-3">
                <textarea
                    class="form-control"
                    name="body"
                    id=""
                    rows="3"
                    required
                    placeholder="Body"
                    v-model="post.body"
                ></textarea>
            </div>
            <input type="hidden" name="method" :value="method" />

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</template>
<script>
import Navbar from "../../components/Navbar.vue";
export default {
    data() {
        return {
            method: null,
            post: {},
            formError: null,
        };
    },
    mounted() {
        this.method = this.capitalizeFirstLetter(this.$route.params.method);
        this.getPost(this.$route.params.id);
    },
    computed: {},
    methods: {
        hideError() {
            setTimeout(() => (this.formError = ""), 3000);
        },
        async handleForm() {
            const url = `${process.env.MIX_APP_URL}/api/posts/${this.post.id}`;
            await axios({
                url,
                method: "put",
                data: JSON.stringify(this.post),
                headers: {
                    "Content-Type": "application/json",
                    // "Content-Type": "multipart/form-data",
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    // console.log(response.data);
                    this.$router.push({
                        name: "details",
                        params: { id: this.post.id },
                    });
                })
                .catch((e) => {
                    console.log(e.response);
                    this.formError = e.response.data;
                    this.hideError();
                });
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
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
            this.post = {
                id: response.id,
                title: response.title,
                body: response.body,
            };
        },
    },
    components: { Navbar },
};
</script>
<style scoped>
.container {
    max-width: 500px;
}
</style>
