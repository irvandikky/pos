<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    customers: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <Head title="View Users" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Users
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="mb-4">
                            <strong>Name:</strong> {{ customers.name }}
                        </p>
                        <p class="mb-4">
                            <strong>Phone:</strong> {{ customers.email }}
                        </p>
                        <p class="mb-4">
                            <strong>Email:</strong> {{ customers.email }}
                        </p>
                        <p class="mb-4">
                            <strong>Address:</strong> {{ customers.address.street }}, {{ customers.address.city }}, {{ customers.address.zip }}
                        </p>
                        <Link
                            :href="route('customers.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            >Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
