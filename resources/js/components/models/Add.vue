<template>
    <div class="submit-form">
        <h4>Add model</h4>
        <div v-if="!submitted">
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    required
                    v-model="model.name"
                    name="name"
                />
            </div>

            <button @click="saveModel" class="btn btn-success">Submit</button>
        </div>

        <div v-else>
            <h4>You submitted successfully!</h4>
            <button class="btn btn-success" @click="newModel">Add more</button>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
import ModelService from "../../services/ModelService";

export default {
    name: "add-model",
    data() {
        return {
            model: {
                id: null,
                name: "",
            },
            submitted: false
        };
    },
    methods: {
        saveModel() {
            let data = {
                name: this.model.name,
            };
            let manufacturer = this.$route.params.id;

            ModelService.create(manufacturer, data)
                .then(response => {
                    this.model.id = response.data.id;
                    console.log(response.data);
                    this.submitted = true;
                })
                .catch(e => {
                    console.log(e);
                });
        },

        newModel() {
            this.submitted = false;
            this.model = {};
        }
    }
};
</script>
