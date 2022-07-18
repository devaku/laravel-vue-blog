<template>
    <nav>
        <router-link to="/" exact>Home</router-link> |

        <router-link v-if="currentRouteName !== 'login'" to="/login" exact
            >Login</router-link
        >
        |
        <router-link to="/asdfasdf" exact>404</router-link>
    </nav>
</template>
<script>
export default {
    computed: {
        currentRouteName() {
            return this.$route.name;
        },
    },
};
</script>
<style scoped></style>
