<script setup>

import {ref} from "vue";

const emit = defineEmits(['submit', 'close'])
const form = ref({
    name: '',
    number: '',
})


const close = () => emit('close')

const onOverlayClick = (e) => {
    if (e.target === e.currentTarget) close()
}

</script>

<template>
    <teleport to="body">
        <div class="modal-overlay" @click="onOverlayClick">
            <v-sheet class="modal-content" @click.stop>

                <div class="flex justify-items-center">
                    <div class="text-center">
                        <v-icon color="info" >mdi-check-bold</v-icon>
                        <h2 class="font-bold">ЗАЯВКА УСПЕШНО</h2>
                        <h2 class="font-bold italic">ОТПРАВЛЕНА</h2>
                    </div>
                </div>
                <div class="actions">
                    <v-btn color="primary" @click="close">Закрыть</v-btn>
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

.actions {
    display: flex;
    justify-content: center;
    margin-top: 16px;
}
</style>
