<script setup>
import Back from "./Back.vue";
</script>
<template>
    <Back />
    <div class="list row">
        <div v-if="currentTransport">
            <h4>Transport</h4>
            <div>
                {{ currentTransport.id }}
            </div>
            <div>
                {{ currentTransport.license_plate }}
            </div>
            <div>
                {{ currentTransport.model.manufacturer.name }}
            </div>
            <div>
                {{ currentTransport.model.name }}
            </div>
            <div>
                {{ currentTransport.fuel_tank_capacity }}
            </div>
            <div>
                {{ currentTransport.average_fuel }}
            </div>
            <div>
                {{ currentTransport.estimated_distance }}
            </div>

            <router-link :to="{ name: 'edit-transport', params:{ id: currentTransport.id } }" class="btn btn-success">
                Edit
            </router-link>
            <button type="button" @click="deleteTransport()" class="btn btn-danger">Delete</button>
        </div>
        <div v-else>
            <br/>
            <p>Not found transport...</p>
        </div>
    </div>
</template>

<script>
import TransportService from "../../services/TransportService";

export default {
    name: "transport-show",
    data() {
        return {
            currentTransport: null,
        };
    },
    methods: {
        getTransport(id) {
            TransportService.get(id)
                .then(response => {
                    this.currentTransport = response.data.data;
                })
                .catch(e => {
                    console.log(e);
                });
        },

        deleteTransport() {
            TransportService.delete(this.currentTransport.id)
                .then(response => {
                    console.log(response.data.data);
                    this.$router.push({ name: "transports" });
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.getTransport(this.$route.params.id);
    }
};
</script>
