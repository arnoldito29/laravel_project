<template>
    <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <router-link to="/" class="navbar-brand">Home</router-link>
            <div class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link :to="{ name: 'transports' }" class="nav-link">Transports</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'manufacturers' }" class="nav-link">Manufacturers</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'all-models' }" class="nav-link">Models</router-link>
                </li>
            </div>
        </nav>

        <div class="container mt-3">
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "app"
};
</script>
