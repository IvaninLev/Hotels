import {defineStore} from "pinia";

export const useSearchStore = defineStore('useSearchStore', {
    state: () => ({
        tours: [],
        toursMeta: {},

        reviews: [],
        reviewsMeta: {},
    }),
    actions: {
        setTours(p) {
            const isArr = Array.isArray(p)
            this.tours = isArr ? p : (p?.data ?? [])
            this.toursMeta = isArr ? {} : (p?.meta ?? {})
        },
        setSearchQuery(query) {
            this.searchQuery = query
        },

    }
})
