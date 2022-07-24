<script setup>
import BreezeInput from "@/Components/Input.vue";
import BreezeButton from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    searchable: {
        type: String,
        default: null,
    },
    terms: {
        type: String,
        default: null,
    },
});

const form = useForm({
    terms: props.terms,
});

const search = () => {
    if (props.searchable) {
        const url = props.searchable + ".index";
        form.get(route(url));
    }
};
const reset = () => {
    const url = props.searchable + ".index";
    form.terms = '';
    form.get(route(url));
};
</script>

<template>
    <form @submit.prevent="search">
        <div class="mb-4 flex">
            <BreezeInput
                id="terms"
                type="text"
                class="mt-1 block w-full"
                v-model="form.terms"
                placeholder="Search"
            />
            <div class="flex flex-col lg:flex-row">
                <BreezeButton
                    class="ml-4 bg-indigo-600 hover:bg-indigo-700"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Search
                </BreezeButton>
                <BreezeButton
                    v-if="form.terms"
                    @click="reset"
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset
                </BreezeButton>
            </div>
        </div>
    </form>
</template>
