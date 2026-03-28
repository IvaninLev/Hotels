import axios from 'axios';

class NewsService {
    async getNews() {
        const response = await axios.get('/api/news');
        const items = response.data?.data ?? [];
        return items.map((item) => {
            const image = Array.isArray(item.image) ? item.image : {};
            return {
                ...item,
                image: image,
                cols: 6,
                rows: 1,

            }
        })

    }
}

export default new NewsService();
