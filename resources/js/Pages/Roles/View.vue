<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
    permissions: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <Head title="View Roles" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Roles
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="mb-4">
                            <strong>Name:</strong> {{ roles.name }}
                        </p>
                        <p class="mb-4">
                            <strong>Permissions:</strong>
                            <ul class="grid grid-cols-2 lg:grid-cols-4">
                            <li class="list-disc ml-4" v-for="permission in permissions" :key="id">
                                {{ permission.name }}
                            </li>
                            </ul>
                        </p>
                        <Link
                            :href="route('roles.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            >Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
