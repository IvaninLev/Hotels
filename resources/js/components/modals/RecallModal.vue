<script setup>
import {ref, computed} from "vue";

const emit = defineEmits(['submit', 'close'])
const form = ref({
    name: '',
    number: '',
})

const errors = ref({name: '', number: ''})

const valid = computed(() => {
    return form.value.name.trim().length > 0 && form.value.number.trim().length > 0
})

const submit = () => {
    errors.value = {name: '', number: ''}
    if (!valid.value) return
    emit('submit', {...form.value})
}

</script>

<template>
    <teleport to="body">
        <div class="modal-overlay">
            <v-sheet class="modal-content">
                <v-btn @click="emit('close')" variant="text" rounded class="mdi mdi-close-circle-outline "></v-btn>

                <div class="flex justify-items-center">
                    <div class="text-center">
                        <h2 class="font-bold">ПЕРЕЗВОНИТЬ</h2>
                        <h2 class="font-bold italic">ВАМ?</h2>
                    </div>
                    <div class=" text-center">
                        <p class="font-bold italic">Оставьте свой номер
                            и наш специалист свяжется с вами</p>
                    </div>
                </div>
                <div class="input-row">
                    <input class="recall-input" v-model="form.name" placeholder="name">
                    <p v-if="errors.name" class="error">{{ errors.name }}</p>
                    <input class="recall-input" v-model="form.number" placeholder="phone number">
                    <p v-if="errors.number" class="error">{{ errors.number }}</p>
                </div>
                <div class="flex d-flex  justify-center pt-5 ">
                    <v-btn :disabled="!valid" color="base-red" @click="submit" width="220px" class="text-white rounded-pill mb-3 ">
                        ОТПРАВИТЬ
                        <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                    </v-btn>
                </div>
            </v-sheet>
        </div>
    </teleport>
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
    width: 300px;
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

.input-row {
    margin-top: 24px;
}

.recall-input {
    width: 100%;
    padding: 8px 2px;
    border: none;
    border-bottom: 1px solid #c8c8c8;
    outline: none;
    transition: border-color 0.2s ease;
}

.recall-input:focus {
    border-bottom-color: #ff5252;
}

.error {
    color: #ff5252;
    font-size: 12px;
    margin: 4px 0 8px;
}
</style>
