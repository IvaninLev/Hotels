import axios from 'axios';

class FilterService {
    async getFilteredTours(params) {
        return await axios.get('/api/tours/filters', {params})
            .then(response => response.data);
    }

    async getSearchedTours(params) {
        const response = await axios.get('/api/tours/search', {params});
        return response.data?.data ?? [];
    }
}

export default new FilterService();
