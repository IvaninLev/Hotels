import axios from "axios"

class BookingService {
    async sentBooking(data) {
        const response = await axios.post('/api/booking', data)
        return response.data.data
    }
}

export default new BookingService;
