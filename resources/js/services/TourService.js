 import axios from "axios";

class TourService {
    async getTours() {
        const response = await axios.get('/api/tours');
        return response.data.data;
    }

    async getToursPage(page = 1) {
        const response = await axios.get('/api/tours', {params: {page}});
        return response.data;
    }

    async getTour(id) {
        const response = await axios.get(`/api/tours/${id}`);
        return response.data?.data ?? response.data;
    }


}

export default new TourService()
