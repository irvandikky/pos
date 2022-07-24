<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeTextarea from "@/Components/TextArea.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    editing: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    name: props.editing ? props.data.name : '',
    email: props.editing ? props.data.email : '',
    phone: props.editing ? props.data.phone : '',
    address: props.editing ? props.data.address.street : '',
    city: props.editing ? props.data.address.city : '',
    zip: props.editing ? props.data.address.zip : '',
});
const update = () => {
    form.put(route("customers.update", props.data.id));
};

const create = () => {
    form.post(route("customers.store"));
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
            <BreezeLabel for="email" value="Email" />
            <BreezeInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="email"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="phone" value="Phone" />
            <BreezeInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                autocomplete="phone"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="address" value="Address" />
            <BreezeTextarea
                id="address"
                class="mt-1 block w-full"
                v-model="form.address"
                required
                autocomplete="address"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="city" value="City" />
            <BreezeInput
                id="city"
                type="text"
                class="mt-1 block w-full"
                v-model="form.city"
                required
                autocomplete="city"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="zip" value="Postal Code" />
            <BreezeInput
                id="zip"
                type="text"
                class="mt-1 block w-full"
                v-model="form.zip"
                required
                autocomplete="zip"
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('customers.index')"
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
