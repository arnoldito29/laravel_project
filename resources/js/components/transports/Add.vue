<script setup>
import Back from "./Back.vue";
</script>
<template>
    <Back />
    <h4>Create new transport</h4>
    <div class="submit-form">
        <div v-if="!submitted">
            <div class="form-group">
                <label for="license_plate">License plate</label>
                <input
                    type="text"
                    class="form-control"
                    id="license_plate"
                    required
                    v-model="transport.license_plate"
                    name="license_plate"
                />
            </div>
            <div class="input-group">
                <select id="selectManufacturer" @change="onChangeManufacturer()" v-model="selectManufacturer"  class="form-control">
                    <option value="">Select an manufacturer</option>
                    <option v-for="manufacturer in manufacturers" :key="manufacturer.id" :value="manufacturer.id">
                        {{ manufacturer.name }}
                    </option>
                </select>
            </div>
            <div class="input-group">
                <select id="selectModel" v-model="selectModel"  class="form-control">
                    <option value="">Select an model</option>
                    <option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
                </select>

            </div>
            <div class="form-group">
                <label for="fuel_tank_capacity">Fuel tank capacity (l)</label>
                <input
                    type="text"
                    class="form-control"
                    id="fuel_tank_capacity"
                    required
                    v-model="transport.fuel_tank_capacity"
                    name="fuel_tank_capacity"
                    @change="calculate()"
                />
            </div>
            <div class="form-group">
                <label for="average_fuel">Average fuel (l/100 km)</label>
                <input
                    type="text"
                    class="form-control"
                    id="average_fuel"
                    required
                    v-model="transport.average_fuel"
                    name="average_fuel"
                    @change="calculate()"
                />
            </div>
            <div class="form-group">
                <label>Estimated distance (km):</label>
                {{ this.estimatedDistance }}
            </div>

            <button @click="saveTransport" class="btn btn-success">Submit</button>
        </div>

        <div v-else>
            <h4>You submitted successfully!</h4>
            <button class="btn btn-success" @click="newTransport">Add more</button>
        </div>
    </div>
</template>

<script>
import TransportService from "../../services/TransportService";
import ModelService from "../../services/ModelService";
import ManufacturerService from "../../services/ManufacturerService";

export default {
    name: "add-transport",
    data() {
        return {
            transport: {
                id: null,
                license_plate: "",
                fuel_tank_capacity: "",
                average_fuel: "",
            },
            manufacturers: [],
            models: [],
            selectManufacturer: '',
            selectModel: '',
            submitted: false,
            estimatedDistance: 0
        };
    },
    components: {
        ManufacturerService,
        ModelService
    },
    methods: {
        onChangeManufacturer() {
            ModelService.getModels(this.selectManufacturer)
                .then(response => {
                    this.models = response.data.data;
                    console.log(response.data.data);
                    this.selectModel = '';
                })
                .catch(e => {
                    console.log(e);
                });
        },
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
        calculate() {
            let tank = this.transport.fuel_tank_capacity ? this.transport.fuel_tank_capacity : 0;
            let average = this.transport.average_fuel ? this.transport.average_fuel : 0;

            if (average === 0) {
                this.estimatedDistance = 0;
            } else {
                this.estimatedDistance = tank / average * 100;
            }
        },
        saveTransport() {
            let data = {
                license_plate: this.transport.license_plate,
                model_id: this.selectModel,
                fuel_tank_capacity: this.transport.fuel_tank_capacity,
                average_fuel: this.transport.average_fuel,
            };

            TransportService.create(data)
                .then(response => {
                    this.transport.id = response.data.id;
                    console.log(response.data);
                    this.submitted = true;
                })
                .catch(e => {
                    console.log(e);
                });
        },

        newTransport() {
            this.submitted = false;
            this.transport = {};
            this.selectManufacturer = "";
            this.selectModel = "";
        }
    },
    mounted() {
        this.retrieveManufacturer();
    }
};
</script>
