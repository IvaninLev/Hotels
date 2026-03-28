import axios from 'axios';

class ReviewService {

    async getReviews(page = 1) {
        const res = await axios.get(`/api/reviews?page=${page}`);
        return res.data;
    }

    async createReview(data) {
            const res = await axios.post(`/api/reviews`, data);
            return res.data;

    }

}

export default new ReviewService;
