import http from "../http-common";

class TransportService {
    getAll() {
        return http.get("/transports");
    }

    get(id) {
        return http.get(`/transports/${id}`);
    }

    create(data) {
        return http.post("/transports", data);
    }

    update(id, data) {
        return http.patch(`/transports/${id}`, data);
    }

    delete(id) {
        return http.delete(`/transports/${id}`);
    }

    find(licensePlate, selectManufacturer, selectModel, deleted) {
        return http.get(`/transports?search=${licensePlate}&manufacturer=${selectManufacturer}&model=${selectModel}&deleted=${deleted}`);
    }
}

export default new TransportService();
