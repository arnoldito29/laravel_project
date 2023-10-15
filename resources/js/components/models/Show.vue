<template>
    <div class="list row">
        <div v-if="currentModel">
            <h4>Model</h4>
            <div>
                <label><strong>Name:</strong></label> {{ currentModel.name }}
            </div>
        </div>
        <div v-else>
            <br/>
            <p>Not found model...</p>
        </div>
    </div>
</template>

<script>
import ModelService from "../../services/ModelService";

export default {
    name: "model-show",
    data() {
        return {
            currentModel: null,
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
