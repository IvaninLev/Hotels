<script setup>
import useVuelidate from "@vuelidate/core";
import {required} from "@vuelidate/validators";

const props = defineProps({
    countries: {
        type: Array,
        required: true
    },
    cities: {
        type: Array,
        default: []
    }
})
const rules = {
    name: {required},
    city: {required},
    country: {required}
}

const form = {
    name: null,
    city: null,
    country: null
}
const countries = ref(props.countries.sort((a, b) => a.name.localeCompare(b.name)))
const cities = ref(props.cities)

const v$ = useVuelidate({rules, form})
</script>

<template>
    <v-container fluid>
        <v-row>

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
                <h1> Hello </h1>
                <div>
                    <label>City</label>
                    <v-select
                        :model="form.city"
                        :items="cities"
                    >

                    </v-select>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
