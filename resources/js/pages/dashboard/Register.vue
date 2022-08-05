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
                <label for="inputName" class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="inputName"
                    aria-describedby="nameHelp"
                    v-model="name"
                />
                <div id="nameHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">
                    Email address
                </label>
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
            email: "email@email.com",
            name: "name",
            password: "email",
        };
    },
    created() {},

    methods: {
        clearForm() {
            this.email = null;
            this.null = null;
            this.password = null;
        },
        async submitForm() {
            this.formErrors = [];
            const data = {
                email: this.email,
                password: this.password,
                name: this.name,
            };

            // Get CSRF Cookie
            let url = `${process.env.MIX_APP_URL}/sanctum/csrf-cookie`;
            await axios({
                url,
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

            // Register
            url = `${process.env.MIX_APP_URL}/api/register`;
            const response = await axios(url, {
                method: "put",
                data,
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    Accept: "application/json",
                },
            })
                .then(async (response) => {
                    this.formError =
                        response.data.message + ". You can now try logging in.";
                    this.clearForm();
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
