<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    orders: {
        type: Object,
        default: () => ({}),
    },
    details: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <Head title="View Order" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Order
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div
                        class="p-6 bg-white border-gray-200 grid lg:grid-cols-2"
                    >
                        <div>
                            <p class="mb-4">
                                <strong>Order ID:</strong> {{ orders.id }}
                            </p>
                            <p class="mb-4">
                                <strong>Customer:</strong>
                                {{ orders.customer.name }}
                            </p>
                            <p class="mb-4">
                                <strong>CS:</strong> {{ orders.user.name }}
                            </p>
                        </div>
                        <table
                            class="w-full text-sm text-left text-gray-500 mt-4"
                        >
                            <thead
                                class="text-gray-700 uppercase bg-indigo-200"
                            >
                                <tr>
                                    <th class="px-6 py-3">Product</th>
                                    <th class="px-6 py-3">Qty</th>
                                    <th class="px-6 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detail in details" :key="detail.id">
                                    <td class="px-6 py-4">
                                        {{ detail.product.name }}
                                    </td>
                                    <td>{{ detail.qty }}</td>
                                    <td>{{ detail.total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6">
                        <Link
                            :href="route('orders.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            >Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
