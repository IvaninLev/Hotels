        import axios from "../../plugins/axios.js";

class CountryService {
 async getCities(countryId){
     return await axios.get('admin/country/get-cities', {
         params:{
             countryId
         }
     }).then(response => response.data)
 }
}

export default new CountryService()
