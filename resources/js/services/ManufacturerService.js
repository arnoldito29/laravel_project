import http from "../http-common";

class ManufacturerService {
    getAll() {
        return http.get("/manufacturers");
    }

    get(id) {
        return http.get(`/manufacturers/${id}`);
    }

    create(data) {
        return http.post("/manufacturers", data);
    }

    update(id, data) {
        return http.patch(`/manufacturers/${id}`, data);
    }

    delete(id) {
        return http.delete(`/manufacturers/${id}`);
    }

    findByName(search) {
        return http.get(`/manufacturers?search=${search}`);
    }
}

export default new ManufacturerService();
