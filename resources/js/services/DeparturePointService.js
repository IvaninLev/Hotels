import axios from 'axios';

class DeparturePointService {
    async getDeparturePoints() {
        const response = await axios.get('/api/departurePoints');
        return response.data.data;
    }
}

export default new DeparturePointService;
