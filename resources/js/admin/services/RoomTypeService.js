import axios from "../../plugins/axios.js";

class RoomTypeService {
    async getRoomTypes(roomType) {
        return await axios.get('admin/room-type/get-roomTypes', {
            config:{
                roomType
            }
        }).then(response => response.data)

        }
        async createRoomType(data) {
        return await axios.post('admin/room-type/store', data, {

        })
            .then(response => response.data)
        }
}

export default new RoomTypeService()
