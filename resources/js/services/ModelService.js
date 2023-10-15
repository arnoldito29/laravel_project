import http from "../http-common";

class ModelService {
    getAll() {
        return http.get(`/manufacturers/models`);
    }

    getModels(manufacturer) {
        return http.get(`/manufacturers/${manufacturer}/models`);
    }

    get(manufacturer, id) {
        return http.get(`/manufacturers/${manufacturer}/models/${id}`);
    }

    create(manufacturer, data) {
        return http.post(`/manufacturers/${manufacturer}/models`, data);
    }

    update(manufacturer, id, data) {
        return http.patch(`/manufacturers/${manufacturer}/models/${id}`, data);
    }

    delete(manufacturer, id) {
        return http.delete(`/manufacturers/${manufacturer}/models/${id}`);
    }

    findByName(name) {
        return http.get(`/manufacturers/models?search=${name}`);
    }
}

export default new ModelService();
