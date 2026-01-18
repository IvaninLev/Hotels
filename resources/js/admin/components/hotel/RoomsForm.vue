<script setup>
import {inject, ref, onMounted} from 'vue'
import {required} from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'

const {roomTypes, form} = inject('rooms-form')

const rules = {
    roomTypes: {
        $each: {
            room_type_id: {required},
            beds: {required},
            area: {required},
            price: {required},
            total_rooms: {required}
        }
    },
    files: {required}
}


const isDeleteMode = ref(false);
const v$ = useVuelidate(rules, form)

const roomType = ref({
    room_type_id: null,
    beds: 1,
    area: null,
    price: null,
    total_rooms: null
})

const addItem = () => {
    form.value.roomTypes.push({
        room_type_id: null,
        beds: 1,
        area: null,
        price: null,
        total_rooms: null
    })
}

const destroy = (index) => {
    form.value.roomTypes.splice(index, 1)
    isDeleteMode.value = false
}

onMounted(() => {
    if (!form.value.roomTypes.length) {
        form.value.roomTypes.push(roomType.value)
    }
})
</script>

<template>
    <v-container>
        <div
            :key="`roomType-${index}`"
            v-for="(roomType, index) in form.roomTypes"
            @click="isDeleteMode && destroy(index )"
            :class="{'delete-mode':isDeleteMode}"
            class="hotel-item"
        >
            <label class="mb-2 d-block">Room Type</label>
            <v-select
                v-model="roomType.room_type_id"
                :items="roomTypes"
                item-title="name"
                item-value="id"
                placeholder="Select room types"
                variant="outlined"
                density="comfortable"
            />
            <div>
                <v-row>
                    <v-col cols="12" md="6">
                        <label>Beds</label>
                        <v-text-field
                            v-model.number="roomType.beds"
                            type="number"
                            placeholder="Number of Beds"
                            variant="outlined"
                            density="comfortable"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <label class="mb-2 d-block">Area (m²)</label>
                        <v-text-field
                            v-model.number="roomType.area"
                            type="number"
                            placeholder="Room area"
                            variant="outlined"
                            density="comfortable"
                        />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <label> Price</label>
                        <v-text-field
                            v-model.number="roomType.price"
                            type="number"
                            placeholder="price"
                            variant="outlined"
                            density="comfortable"
                            prefix="$"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <label> Total Rooms</label>
                        <v-text-field
                            v-model.number="roomType.total_rooms"
                            type="number"
                            placeholder="Total rooms of this type"
                            variant="outlined"
                            density="comfortable"
                        >
                        </v-text-field>
                    </v-col>
                </v-row>
            </div>
        </div>
        <v-btn @click="addItem"> + Add Item</v-btn>
        <v-btn
            @click="isDeleteMode = !isDeleteMode"
            :color="isDeleteMode ? 'error' : 'default'"
            :variant="isDeleteMode ? 'flat' : 'outlined'"
            class="ml-5 "
        >
            <v-icon start>mdi-delete</v-icon>
            {{ isDeleteMode ? 'Cancel' : 'Delete Item' }}
        </v-btn>
    </v-container>
</template>

<style scoped>
label {
    font-weight: 500;
    color: #333;
}

.delete-mode {
    cursor: pointer;
    background-color: white;
    border: 2px dashed red;

}

.delete-mode:hover {
    background-color: #ffcdd2;
}

.hotel-item {
    margin-bottom: 16px;
    padding: 12px;
    border-radius: 8px;
    transition-duration: 0.2s;
}
</style>
