<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    editing: false,
    data: {
        type: Object,
        default: () => ({}),
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    name: props.data.name,
    email: props.data.email,
    password: "",
    roles: props.data.roles,
});
const submit = () => {
    form.put(route("users.update", props.data.id));
};
if (!props.editing) {
    const form = useForm({
        name: "",
        email: "",
        password: "",
        roles: "",
    });

    const submit = () => {
        form.post(route("users.store"));
    };
}
</script>
<template>
    <form @submit.prevent="submit">
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
            <BreezeLabel for="password" value="Password" />
            <BreezeInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="roles" value="Role" />
            <select
                id="roles"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                v-model="form.roles"
                required
            >
                <option>Select Role</option>
                <option :value="index" v-for="(item, index) in props.roles">
                    {{ item.toUpperCase() }}
                </option>
            </select>
        </div>

        <div class="flex items-center justify-end mt-4">

            <Link
                :href="route('users.index')"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            >Back
            </Link>
            <BreezeButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                <span v-if="!props.editing">Create</span>
                <span v-else>Update</span>
            </BreezeButton>
        </div>
    </form>
</template>
