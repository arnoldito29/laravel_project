<template>
    <div v-if="currentModel" class="edit-form">
        <h4>model</h4>
        <form ref="editModelForm">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name"
                       v-model="currentModel.name"
                />
            </div>
        </form>

        <button type="submit" class="btn btn-sm btn-success"
                @click="updateModel"
        >
            Update
        </button>

        <button class="btn btn-sm btn-danger"
                @click="restore"
        >
            Restore
        </button>
        <h4>{{ message }}</h4>
    </div>

    <div v-else>
        <br />
        <p>Please click on a model...</p>
    </div>
</template>

<script>
import ModelService from "../../services/ModelService";

export default {
    name: "edit-model",
    data() {
        return {
            currentModel: null,
            message: ''
        };
    },
    methods: {
        getModel(manufacturer, id) {
            if (manufacturer === undefined) {
                return;
            }
            ModelService.get(manufacturer, id)
                .then(response => {
                    this.currentModel = response.data.data;
                    console.log(response.data.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        updateModel() {
            let data = {
                id: this.currentModel.id,
                name: this.currentModel.name
            };

            ModelService.update(this.$route.params.id, this.currentModel.id, data)
                .then(response => {
                    console.log(response.data.data);
                    this.message = 'The model was updated successfully!';
                })
                .catch(e => {
                    console.log(e);
                });
        },
        restore() {
            this.getModel(this.$route.params.id, this.$route.params.model);
        }
    },
    watch: {
        '$route'() {
            this.getModel(this.$route.params.id, this.$route.params.model);
        }
    },
    mounted() {
        this.getModel(this.$route.params.id, this.$route.params.model);
    }
};
</script>
