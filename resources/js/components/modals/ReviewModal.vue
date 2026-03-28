<script setup>
import {ref} from "vue";
import ReviewsService from "../../services/ReviewsService.js";

const emit = defineEmits(['close', 'submit'])

const form = ref({
    name: '',
    from: '',
    flightDate: '',
    flightPlace: '',
    text: '',
    rating: 5,
})


const submit = async () => {
    const payload = {
        name: form.value.name,
        person_from: form.value.from,
        flight_date: form.value.flightDate,
        flight_to: form.value.flightPlace,
        was_in_hotel: form.value.flightPlace,
        main_text: form.value.text,
        rating: Number(form.value.rating ?? 5),
        avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(form.value.name)}&size=200&background=random&color=fff`,
    };
    await ReviewsService.createReview(payload);
    emit('submit', payload);
    emit('close');
};
</script>

<template>
    <Teleport to="body">
        <div class="modal-overlay">
            <v-sheet class="modal-content">
                <v-btn @click="emit('close')">x</v-btn>
                <div class="flex justify-items-center">
                    <h3>БУДЕМ РАДЫ ВАШЕМУ ОТЗЫВУ</h3>
                </div>

                <div class="pt-5">
                    <div class="flex d-flex ga-4">
                        <div>
                            <label class="field-label">Имя и Фамилия</label>
                            <v-text-field
                                v-model="form.name"
                                rounded
                                variant="outlined"
                                density="compact"
                                width="226px"
                                placeholder="Александра Иванова"
                            />
                        </div>
                        <div>
                            <label class="field-label">Откуда вы</label>
                            <v-text-field
                                v-model="form.from"
                                rounded
                                variant="outlined"
                                density="compact"
                                width="226px"
                                placeholder="Москва"
                            />
                        </div>
                    </div>

                    <div class="flex d-flex ga-4 pt-3">
                        <div>
                            <label class="field-label">Когда летали (дата)</label>
                            <v-text-field
                                v-model="form.flightDate"
                                rounded
                                type="date"
                                variant="outlined"
                                density="compact"
                                width="226px"
                                placeholder="10.10.23"
                            />
                        </div>
                        <div>
                            <label class="field-label">Куда летали (страна и отель)</label>
                            <v-text-field
                                v-model="form.flightPlace"
                                rounded
                                variant="outlined"
                                density="compact"
                                width="226px"
                                placeholder="Бали, Hanging Gardens"
                            />
                        </div>

                    </div>
                    <div class="pt-3">
                        <label class="field-label">Ваша оценка</label>
                        <v-rating
                            v-model="form.rating"
                            color="red"
                            hover
                            :length="5"
                            :size="32"
                        />
                    </div>

                    <div class="pt-3">
                        <label class="field-label">Напишите отзыв</label>
                        <v-textarea
                            v-model="form.text"
                            rounded
                            variant="outlined"
                            width="464px"
                            placeholder="Текст"
                            rows="6"
                        />
                    </div>
                    <div class="flex d-flex  justify-center  ">
                        <v-btn color="base-red" @click="submit" width="220px" class="text-white rounded-pill mb-3 ">
                            ОТПРАВИТЬ
                            <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                        </v-btn>
                    </div>
                </div>
            </v-sheet>

        </div>
    </Teleport>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 1;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    width: 544px;
    background: white;
    border-radius: 16px;
    padding: 40px;
}

.field-label {
    display: block;
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
}
</style>
