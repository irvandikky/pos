<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeTextarea from "@/Components/TextArea.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
    editing: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    permissions: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    name: props.editing ? props.data.name : "",
    permissions: props.editing ? props.data.permissions : [],
});
const update = () => {
    form.put(route("roles.update", props.data.id));
};

const create = () => {
    form.post(route("roles.store"));
};
</script>
<template>
    <form @submit.prevent="!props.editing ? create() : update()">
        <div class="mb-4">
            <BreezeLabel for="name" value="Name" />
            <BreezeInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="permissions" value="Select Permissions" />
            <Multiselect v-model="form.permissions" :closeOnSelect="false" mode="tags" :options="props.permissions" :object="true" :searchable="true"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('roles.index')"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                >Back
            </Link>
            <BreezeButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                <span v-text="!props.editing ? 'Create' : 'Update'"></span>
            </BreezeButton>
        </div>
    </form>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>
