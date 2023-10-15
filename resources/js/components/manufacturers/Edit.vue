<script setup>
import Back from "./Back.vue";
</script>
<template>
    <Back />
    <div v-if="currentManufacturer" class="edit-form">
        <h4>Manufacturer</h4>
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name"
                       v-model="currentManufacturer.name"
                />
            </div>
        </form>

        <button type="submit" class="btn btn-sm btn-success"
                @click="updateManufacturer"
        >
            Update
        </button>

        <button class="btn btn-sm btn-danger"
                @click="deleteManufacturer"
        >
            Delete
        </button>
        <h4>{{ message }}</h4>
    </div>

    <div v-else>
        <br />
        <p>Please click on a Manufacturer...</p>
    </div>
</template>

<script>
import ManufacturerService from "../../services/ManufacturerService";

export default {
    name: "edit-manufacturer",
    data() {
        return {
            currentManufacturer: null,
            message: ''
        };
    },
    methods: {
        getManufacturer(id) {
            ManufacturerService.get(id)
                .then(response => {
                    this.currentManufacturer = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        updateManufacturer() {
            let data = {
                id: this.currentManufacturer.id,
                name: this.currentManufacturer.name
            };

            ManufacturerService.update(this.currentManufacturer.id, data)
                .then(response => {
                    console.log(response.data.data);
                    this.message = 'The manufacturer was updated successfully!';
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
        this.message = '';
        this.getManufacturer(this.$route.params.id);
    }
};
</script>
