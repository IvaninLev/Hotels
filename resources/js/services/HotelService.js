import axios from "axios";

class HotelService {
    async getHotels() {
        const response = await axios.get('/api/hotels');
        return response.data.data;
    }

    async getHotelsPage(page = 1) {
        const response = await axios.get('/api/hotels', {params: {page}});
        return response.data;
    }

}

export default new HotelService()
