<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import { defineComponent } from "vue";
import Pagination from "@/Components/Pagination.vue";
import Search from "@/Components/Search.vue";

defineComponent({
    component: {
        Pagination,
    },
});

defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({})

const data = {
    model: "products",
    terms: new URL(location.href).searchParams.get("terms")
        ? new URL(location.href).searchParams.get("terms")
        : "",
};

const destroy = (id) => {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("products.destroy", id));
    }
};
</script>

<template>
    <Head title="Products" />

    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
            <Link
                :href="route('products.create')" v-if="$page.props.auth.access.indexOf('create products') != -1"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                >Add Products
            </Link>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    v-if="$page.props.flash.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
                </div>
                <div class="overflow-hidden bg-white shadow-md sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="relative overflow-x-auto">
                            <Search
                                v-bind:searchable="data.model"
                                v-bind:terms="data.terms"
                            />
                            <table
                                class="w-full text-sm text-left text-gray-500"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-indigo-200"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Stock
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-center"
                                        >
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in products.data"
                                        :key="product.id"
                                        class="bg-white border-b"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900"
                                        >
                                            {{ product.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{
                                                new Intl.NumberFormat("en-US", {
                                                    style: "currency",
                                                    currency: "IDR",
                                                })
                                                    .format(product.price)
                                                    .replace(/(\.|,)00$/g, "")
                                            }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ product.stock }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{
                                                product.status
                                                    ? "Published"
                                                    : "Draft"
                                            }}
                                        </td>

                                        <td
                                            class="px-6 py-4 flex space-x-4 justify-center"
                                        >
                                            <Link v-if="$page.props.auth.access.indexOf('view products') != -1"
                                                :href="
                                                    route(
                                                        'products.show',
                                                        product.id
                                                    )
                                                "
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                                >View</Link
                                            >
                                            <Link v-if="$page.props.auth.access.indexOf('update products') != -1"
                                                :href="
                                                    route(
                                                        'products.edit',
                                                        product.id
                                                    )
                                                "
                                                class="px-4 py-2 text-white bg-gray-800 hover:bg-gray-700 rounded-lg uppercase"
                                                >Edit</Link
                                            >
                                            <BreezeButton v-if="$page.props.auth.access.indexOf('delete products') != -1"
                                                class="bg-red-700 hover:bg-red-800"
                                                @click="destroy(product.id)"
                                            >
                                                Delete
                                            </BreezeButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination
                            class="mt-6 flex justify-end"
                            :links="products.links"
                        />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
