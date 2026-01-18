import axios from "../../plugins/axios.js";

class HotelService {
        async createHotel(data) {
            return await axios.post('admin/hotel/store', data, {
                headers: {
                    'Content-Type': "multipart/form-data"
                }
            })
                .then(response => response.data)
        }
    async updateHotel(id, data){
        return await axios.post(`admin/hotel/update/${id}`, data, {
            headers: {
                'Content-Type': "multipart/form-data"
            }
        })
            .then(response => response.data)
    }


}

export default new HotelService

