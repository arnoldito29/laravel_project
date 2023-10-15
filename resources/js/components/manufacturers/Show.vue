<script setup>
import Back from "./Back.vue";
</script>
<template>
    <Back />
    <div class="list row">
        <div v-if="currentManufacturer">
            <h4>Manufacturer</h4>
            <div>
                <label><strong>Name:</strong></label> {{ currentManufacturer.name }}
            </div>

            <router-link :to="{ name: 'add-model', params:{ id: currentManufacturer.id } }" class="btn btn-primary">
                Add model
            </router-link>
            <router-link :to="{ name: 'edit-manufacturer', params:{ id: currentManufacturer.id } }" class="btn btn-success">
                Edit
            </router-link>
            <button type="button" @click="deleteManufacturer()" class="btn btn-danger">Delete</button>
        </div>
        <div v-else>
            <br/>
            <p>Not found manufacturer...</p>
        </div>
    </div>
    <router-view/>
    <div class="row">
        <h4>Models List</h4>
        <ul class="list-group">
            <li class="list-group-item d-flex"
                v-for="(model, index) in models"
                :key="index"
            >
                <p class="p-0 m-0 flex-grow-1">{{ model.name }}</p>
                <router-link :to="{ name: 'show-model', params:{ id: currentManufacturer.id, model: model.id } }" class="btn btn-primary">Show</router-link>
                <router-link :to="{ name: 'edit-model', params:{ id: currentManufacturer.id, model: model.id } }" class="btn btn-success">Edit</router-link>
                <button type="button" @click="deleteManufacturer(model.id)" class="btn btn-danger">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import ManufacturerService from "../../services/ManufacturerService";
export default {
    name: "manufacturer-show",
    data() {
        return {
            currentManufacturer: null,
            models: [],
        };
    },
    methods: {
        getManufacturer(id) {
            ManufacturerService.get(id)
                .then(response => {
                    this.currentManufacturer = response.data.data;
                    this.models = this.currentManufacturer.models;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        deleteManufacturer() {
            ManufacturerService.delete(this.currentManufacturer.id)
                .then(response => {
                    console.log(response.data.data);
                    this.$router.push({ name: "manufacturers" });
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.getManufacturer(this.$route.params.id);
    }
};
</script>
