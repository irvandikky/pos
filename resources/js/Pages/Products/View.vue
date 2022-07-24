<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <Head title="View Products" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Products
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col lg:flex-row mb-4 lg:space-x-8 space-y-8 lg:space-y-0">
                            <div class="w-full lg:w-1/2">
                                <img
                                    :src="products.image ? products.image : '/no-image.png'"
                                    class="w-full rounded shadow"
                                />
                            </div>
                            <div class="w-full lg:w-1/2 flex flex-col space-y-2">
                                <p>
                                    <strong>Name:</strong> {{ products.name }}
                                </p>
                                <p>
                                    <strong>Description:</strong> {{ products.description }}
                                </p>
                                <p>
                                    <strong>Price:</strong> {{ new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'IDR',
                                    }).format(products.price).replace(/(\.|,)00$/g, '') }}
                                </p>
                                <p>
                                    <strong>Stock:</strong> {{ products.stock }}
                                </p>
                                <p>
                                    <strong>Status:</strong> {{ products.status ? 'Published' : 'Draft' }}
                                </p>
                            </div>
                        </div>
                        <Link
                            :href="route('products.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            >Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
