<template>
    <Navbar></Navbar>
    <div class="container error-holder my-3" v-if="formError">
        <div class="card border-danger mb-3">
            <div class="card-header text-danger border-danger">Error</div>
            <div class="card-body">
                <p class="card-text">{{ formError }}</p>
            </div>
        </div>
    </div>
    <div class="container">
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">
                    Email address</label
                >
                <input
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    v-model="email"
                />
                <div id="emailHelp" class="form-text">
                    We'll never share your email with anyone else.
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">
                    Password</label
                >
                <input
                    type="password"
                    class="form-control"
                    id="exampleInputPassword1"
                    v-model="password"
                />
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</template>
<script>
import axios from "axios";
import Navbar from "../../components/Navbar.vue";
export default {
    components: {
        Navbar,
    },

    data() {
        return {
            formError: null,
            email: null,
            password: null,
        };
    },
    created() {
        // this.$cookies.set("Z COOKIE", "Hello", 7200);
    },

    methods: {
        async submitForm() {
            this.formErrors = [];
            const data = {
                email: this.email,
                password: this.password,
            };

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
                    this.formError = e.response.data.message;
                });

            // Login
            url = `${process.env.MIX_APP_URL}/api/login`;
            const response = await axios(url, {
                method: "post",
                data,
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    Accept: "application/json",
                },
            })
                .then(async (response) => {
                    console.log(response.data);
                    // Refresh page
                    this.$router.go();
                    // this.$router.push({ name: "home" });
                })
                .catch((e) => {
                    // console.log(JSON.stringify(e));
                    console.log(JSON.stringify(e.response));
                    this.formError = e.response.data.message;
                });
        },
    },
};
</script>

<style scoped lang="scss">
.container {
    max-width: 500px;
}
</style>
