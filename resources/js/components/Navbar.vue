<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <router-link to="/" exact class="navbar-brand">Home</router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left side -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <!-- Right side -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item" v-if="isLoggedIn">
                        <a href="#" class="nav-link" v-on:click="submitForm()"
                            >Logout</a
                        >
                    </li>
                    <li class="nav-item" v-else>
                        <span v-if="currentRouteName !== 'login'">
                            <router-link to="/login" exact class="nav-link"
                                >Login</router-link
                            >
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    data() {
        return {
            logoutUrl: `${process.env.MIX_APP_URL}/logout`,
            isLoggedIn: null,
        };
    },

    beforeMount() {
        // this.loginStatus();
    },

    created() {
        this.loginStatus();
    },

    mounted() {
        // this.loginStatus();
    },

    computed: {
        currentRouteName() {
            return this.$route.name;
        },
    },

    methods: {
        async loginStatus() {
            let response = await axios
                .get("/api/authenticated")
                .then(() => {
                    return true;
                })
                .catch(() => {
                    return false;
                });

            this.isLoggedIn = response;
        },
        async submitForm() {
            // this.$refs.logoutForm.submit();
            await axios(this.logoutUrl, {
                method: "post",
                data: {},
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (this.currentRouteName != "home") {
                        this.$router.push({ name: "home" });
                    } else {
                        // Refresh the page
                        this.$router.go();
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },
    },
};
</script>
<style scoped></style>
