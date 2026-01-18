import axios from "axios";

let config = {
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',

    }
}

const _axios = axios.create(config)
export default _axios
