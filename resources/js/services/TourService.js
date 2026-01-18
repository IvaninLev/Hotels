import axios from "axios";

class TourService {
    async getTours() {
        return await axios.get('tours')
            .then(response => response.data)
    }
}

export default new TourService()
