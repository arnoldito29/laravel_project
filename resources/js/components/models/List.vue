<template>
    <div class="list row">
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search by name"
                       v-model="title"/>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"
                            @click="searchName"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h4>Models List</h4>
        <ul class="list-group">
            <li class="list-group-item d-flex"
                v-for="(model, index) in models"
                :key="index"
            >
                <p class="p-0 m-0 flex-grow-1">{{ model.name }}</p>
                <router-link :to="{ name: 'show-model', params:{ id: model.manufacturer.id, model: model.id }}" class="btn btn-primary">Show</router-link>
                <router-link :to="{ name: 'edit-model', params:{ model: model.id, id: model.manufacturer.id } }" class="btn btn-success">Edit</router-link>
                <button type="button" @click="deleteModel(model.manufacturer.id, model.id)" class="btn btn-danger">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import ModelService from "../../services/ModelService";

export default {
    name: "models-list",
    data() {
        return {
            models: [],
            currentModel: null,
            title: ""
        };
    },
    methods: {
        retrieveModel() {
            ModelService.getAll()
                .then(response => {
                    this.models = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        deleteModel(manufacturer_id, model_id) {
            ModelService.delete(manufacturer_id, model_id)
                .then(response => {
                    console.log(response.data);
                    this.retrieveModel();
                })
                .catch(e => {
                    console.log(e);
                });
        },

        searchName() {
            ModelService.findByName(this.title)
                .then(response => {
                    this.models = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.retrieveModel();
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
