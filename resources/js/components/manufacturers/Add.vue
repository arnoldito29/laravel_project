<script setup>
import Back from "./Back.vue";
</script>
<template>
    <Back />
    <div class="submit-form">
        <div v-if="!submitted">
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    required
                    v-model="manufacturer.name"
                    name="name"
                />
            </div>

            <button @click="saveManufacturer" class="btn btn-success">Submit</button>
        </div>

        <div v-else>
            <h4>You submitted successfully!</h4>
            <button class="btn btn-success" @click="newManufacturer">Add more</button>
        </div>
    </div>
</template>

<script>
import ManufacturerService from "../../services/ManufacturerService";

export default {
    name: "add-manufacturer",
    data() {
        return {
            manufacturer: {
                id: null,
                name: "",
            },
            submitted: false
        };
    },
    methods: {
        saveManufacturer() {
            let data = {
                name: this.manufacturer.name,
            };

            ManufacturerService.create(data)
                .then(response => {
                    this.manufacturer.id = response.data.id;
                    console.log(response.data);
                    this.submitted = true;
                })
                .catch(e => {
                    console.log(e);
                });
        },

        newManufacturer() {
            this.submitted = false;
            this.manufacturer = {};
        }
    }
};
</script>
