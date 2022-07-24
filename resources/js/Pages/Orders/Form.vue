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
    product: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    customer_id: props.editing ? props.data.customer_id : null,
    products: props.editing ? props.product : [],
    status: props.editing ? props.data.status : null,
});
const getCustomer = (term) => {
    return axios
        .get(route("getCustomer"), {
            params: {
                terms: term,
            },
        })
        .then(function (response) {
            return response.data;
        });
};

const getProduct = (term, index) => {
    return axios
        .get(route("getProduct"), {
            params: {
                terms: term,
            },
        })
        .then(function (response) {
            return response.data;
        });
};
const getInput = (e, index) => {
    return axios
        .get(route("getProduct"), {
            params: {
                id: e,
            },
        })
        .then(function (response) {
            form.products[index].id = response.data.id;
            form.products[index].qty = 1;
            form.products[index].price = response.data.price;
            form.products[index].subprice = response.data.price;
        });
};
const changePrice = (e, index) => {
    const price = e.target.value * form.products[index].price;
    form.products[index].subprice = price;
};
const addProduct = () => {
    form.products.push({
        id: null,
        qty: null,
        price: null,
        subprice: null,
    });
};
const removeProduct = (index) => {
    form.products.splice(index, 1);
}
const update = () => {
    form.put(route("orders.update", props.data.id));
};

const create = () => {
    form.post(route("orders.store"));
};
</script>
<template>
    <form @submit.prevent="!props.editing ? create() : update()">
        <div class="mb-4">
            <BreezeLabel for="customer_id" value="Select Customers" />
            <Multiselect
                v-model="form.customer_id"
                :filter-results="false"
                :min-chars="1"
                :resolve-on-load="true"
                :placeholder="'Search Customers'"
                :noOptionsText="'Type min. 1 word'"
                :delay="0"
                :searchable="true"
                :disabled="props.editing"
                :options="
                    async function (query) {
                        return await getCustomer(query);
                    }
                "
            />
        </div>

        <div
            class="mb-4 flex flex-col lg:flex-row space-x-0 lg:space-x-4 space-y-4 lg:space-y-0 items-center justify-center"
            v-for="(row, index) in form.products"
            :key="index"
        >
            <div class="w-full lg:w-6/12">
                <BreezeLabel for="products" value="Select Product" />
                <Multiselect
                    class="w-full"
                    :filter-results="false"
                    :min-chars="1"
                    :placeholder="'Search Products'"
                    :noOptionsText="'Type min. 1 word'"
                    :resolve-on-load="true"
                    :delay="0"
                    :disabled="props.product[index].disabled"
                    :required="true"
                    :searchable="true"
                    @change="getInput($event, index)"
                    v-model="form.products[index].id"
                    :options="
                        async function (query) {
                            return await getProduct(query, index);
                        }
                    "
                />
            </div>
            <div class="w-full lg:w-2/12">
                <BreezeLabel for="qty" value="Qty" />
                <BreezeInput
                    id="qty"
                    type="number"
                    min="1"
                    @change="changePrice($event, index)"
                    @keyup="changePrice($event, index)"
                    v-model="form.products[index].qty"
                    class="block w-full"
                    required
                />
            </div>
            <div class="w-full lg:w-2/12">
                <BreezeLabel for="price" value="Price" />
                <BreezeInput
                    id="price"
                    type="text"
                    class="block w-full bg-gray-100 text-gray-700"
                    v-model="form.products[index].subprice"
                    disabled
                />
            </div>
            <div class="w-full lg:w-2/12">
                <BreezeButton
                    v-bind:type="'button'"
                    @click="removeProduct(index)"
                    class="w-full items-center justify-center mt-4"
                >
                    X
                </BreezeButton>
            </div>
        </div>

        <div class="w-full lg:w-2/12">
            <BreezeButton
                v-bind:type="'button'"
                @click="addProduct"
                class="w-full items-center justify-center"
            >
                Add Product
            </BreezeButton>
        </div>

        <div class="my-4">
            <BreezeLabel for="status" value="Select Status" />
            <Multiselect
                v-model="form.status"
                :options="['Cancel', 'Pending', 'Complete']"
            />
        </div>
        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('orders.index')"
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
