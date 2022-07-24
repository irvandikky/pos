<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    permissions: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <Head title="View Permissions" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Permissions
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="mb-4">
                            <strong>Name:</strong> {{ permissions.name }}
                        </p>
                        <Link
                            :href="route('permissions.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            >Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
