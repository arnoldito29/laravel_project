<template>
    <div class="row">
        <div class="col-md-10">
            <div class="form-inline">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by license plate"
                           v-model="licensePlate"/>
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
                <div class="input-group">
                    <input type="checkbox" id="deleted" v-model="deleted" />
                    <label for="deleted"> Show deleted</label>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"
                            @click="searchName"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <router-link :to="{ name: 'add-transport' }" class="btn btn-success">Add transport</router-link>
        </div>
    </div>
    <div class="row">
        <h4>Transports List</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">License plate</th>
                <th scope="col">Manufacturer</th>
                <th scope="col">Model</th>
                <th scope="col">Fuel tank capacity</th>
                <th scope="col">Average fuel</th>
                <th scope="col">Estimated distance</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(transport, index) in transports"
                :key="index"
            >
                <td>
                    {{ transport.id }}
                </td>
                <td>
                    {{ transport.license_plate }}
                </td>
                <td>
                    {{ transport.model.manufacturer.name }}
                </td>
                <td>
                    {{ transport.model.name }}
                </td>
                <td>
                    {{ transport.fuel_tank_capacity }}
                </td>
                <td>
                    {{ transport.average_fuel }}
                </td>
                <td>
                    {{ transport.estimated_distance }}
                </td>
                <td>
                    <div v-if="transport.deleted">
                        Record was deleted
                    </div>
                    <div v-else>
                        <router-link :to="{ name: 'show-transport', params:{ id: transport.id } }" class="btn btn-primary">
                            Show
                        </router-link>
                        <router-link :to="{ name: 'edit-transport', params:{ id: transport.id } }" class="btn btn-success">
                            Edit
                        </router-link>
                        <button type="button" @click="deleteTransport(transport.id)" class="btn btn-danger">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import TransportService from "../../services/TransportService";
import ManufacturerService from "../../services/ManufacturerService";
import ModelService from "../../services/ModelService";

export default {
    name: "transports-list",
    data() {
        return {
            transports: [],
            manufacturers: [],
            models: [],
            licensePlate: '',
            selectManufacturer: '',
            selectModel: '',
            deleted: ''
        }
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
                })
                .catch(e => {
                    console.log(e);
                });
        },

        retrieveTransport() {
            TransportService.getAll()
                .then(response => {
                    this.transports = response.data.data;
                })
                .catch(e => {
                    console.log(e);
                });
        },

        deleteTransport(transport_id) {
            TransportService.delete(transport_id)
                .then(response => {
                    this.retrieveTransport();
                })
                .catch(e => {
                    console.log(e);
                });
        },

        searchName() {
            let deleted = this.deleted ? 1 : 0;
            TransportService.find(this.licensePlate, this.selectManufacturer, this.selectModel, deleted)
                .then(response => {
                    this.transports = response.data.data;
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.retrieveManufacturer();
        this.retrieveTransport();
    }
};
</script>
