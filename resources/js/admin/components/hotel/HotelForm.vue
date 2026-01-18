<script setup>
import {VFileUpload} from "vuetify/labs/VFileUpload";
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {inject} from "vue";

const { cities, getCities, countries, form} = inject('hotel-form')

const rules = {
    name: {required},
    description: {required},
    files: {required},
    country: {required},
    city: {required}
}

const v$ = useVuelidate(rules, form)

const destroy = (index) => {
    form.value.image.splice(index, 1)
}
</script>

<template>
    <v-container fluid>
        <v-row>
            <!-- Левая часть формы -->
            <v-col cols="12" md="6">
                <div class="form-group col-sm-12 mb-3 required">
                    <label>Name</label>
                    <v-text-field
                        v-model="form.name"
                        variant="outlined"
                        density="comfortable"
                        :error-messages="v$.name.$errors.map(e => e.$message)"
                        :error="v$.name.$dirty && v$.name.$errors.length"
                        @blur="v$.name.$touch()"
                    />
                </div>

                <div class="form-group col-sm-12 mb-3 required">
                    <label>Description</label>
                    <v-text-field
                        v-model="form.description"
                        variant="outlined"
                        density="comfortable"
                        :error-messages="v$.description.$errors.map(e => e.$message)"
                        :error="v$.description.$dirty && v$.description.$errors.length"
                        @blur="v$.description.$touch()"
                    />
                </div>

                    <div class="form-group col-sm-12 mb-3 required">
                    <label>Country</label>
                    <v-select
                        v-model="form.country"
                        :items="countries"
                        @update:modelValue="getCities"
                        item-title="name"
                        item-value="id"
                        label="Country"
                        :error-messages="v$.country.$errors.map(e => e.$message)"
                        :error="v$.country.$dirty && v$.country.$errors.length"
                    />
                </div>

                <div class="form-group col-sm-12 mb-3 required">
                    <label>City</label>
                    <v-select
                        v-model="form.city"
                        :items="cities"
                        item-title="name"
                        item-value="id"
                        label="City"
                        :error-messages="v$.city.$errors.map(e => e.$message)"
                        :error="v$.city.$dirty && v$.city.$errors.length"
                    />
                </div>
            </v-col>

            <!-- Правая часть (файлы) -->
            <v-col cols="12" md="6">
                <div class="form-group col-sm-12 mb-3 required">
                    <label>Images</label>
                    <v-file-upload
                        v-model="form.files"
                        clearable
                        multiple
                        density="compact"
                        variant="compact"
                        :error-messages="v$.files.$errors.map(e => e.$message)"
                        :error="v$.files.$dirty && v$.files.$errors.length"
                    />
                    <div
                        v-for="(image,index) in form.image"
                        :key="index"
                        class="d-flex justify-space-between align-center border rounded px-4 py-3  mt-2"

                    >
                        <div class="d-flex gap-3">
                            <v-img :src="image" width="40" height="40" cover/>
                            <p>{{ image.split('/')[7] }}</p>
                        </div>
                        <v-btn icon="mdi-close-circle" flat density="comfortable"
                               @click="destroy(index)"></v-btn>
                    </div>

                </div>
            </v-col>
        </v-row>
    </v-container>

</template>

<style scoped>

</style>
