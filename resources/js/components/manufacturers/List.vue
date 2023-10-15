<template>
    <div class="list row">
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search by name"
                       v-model="name"/>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"
                            @click="searchName"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <router-link :to="{ name: 'add-manufacturer' }" class="btn btn-success">Add manufacturer</router-link>
        </div>
    </div>
    <div class="row">
        <h4>Manufacturers List</h4>
        <ul class="list-group">
            <li class="list-group-item d-flex"
                v-for="(manufacturer, index) in manufacturers"
                :key="index"
            >
                <p class="p-0 m-0 flex-grow-1">{{ manufacturer.name }}</p>
                <router-link :to="{ name: 'show-manufacturer', params:{ id: manufacturer.id } }" class="btn btn-primary">Show</router-link>
                <router-link :to="{ name: 'edit-manufacturer', params:{ id: manufacturer.id } }" class="btn btn-success">Edit</router-link>
                <button type="button" @click="deleteManufacturer(manufacturer.id)" class="btn btn-danger">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import ManufacturerService from "../../services/ManufacturerService";

export default {
    name: "manufacturers-list",
    data() {
        return {
            manufacturers: [],
            currentManufacturer: null,
            name: ""
        };
    },
    methods: {
        retrieveManufacturer() {
            ManufacturerService.getAll()
                .then(response => {
                    this.manufacturers = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        deleteManufacturer(manufacturer_id) {
            ManufacturerService.delete(manufacturer_id)
                .then(response => {
                    console.log(response.data);
                    this.retrieveManufacturer();
                })
                .catch(e => {
                    console.log(e);
                });
        },

        searchName() {
            ManufacturerService.findByName(this.name)
                .then(response => {
                    this.manufacturers = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.retrieveManufacturer();
    }
};
</script>

<style>
.list {
    text-align: left;
    max-width: 750px;
    margin: auto;
}
</style>
