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
    categories: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({
    _method: props.editing ? 'put' : 'post',
    preview: props.editing ? props.data.image : "",
    image: null,
    name: props.editing ? props.data.name : "",
    categories: props.editing ? props.data.categories : [],
    description: props.editing ? props.data.description : "",
    price: props.editing ? props.data.price : "",
    stock: props.editing ? props.data.stock : "",
    status: props.editing ? props.data.status : "",
});
const update = () => {
    form.post(route("products.update", props.data.id));
};
const create = () => {
    form.post(route("products.store"));
};
const previewImage = (e) => {
    const file = e.target.files[0];
    form.image = file;
    form.preview = URL.createObjectURL(file);
};
</script>
<template>
    <form
        @submit.prevent="!props.editing ? create() : update()"
        enctype="multipart/form-data"
    >
        <div class="mb-4">
            <label class="inline-block mb-2 text-gray-500">File Upload</label>
            <div class="flex items-center justify-center w-full space-x-4">
                <label
                    class="flex flex-col w-1/2 h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300"
                    for="image"
                >
                    <div class="flex flex-col items-center justify-center pt-7">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                            />
                        </svg>
                        <p
                            class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600"
                            v-text="
                                props.editing ? 'Change Image' : 'Upload Image'
                            "
                        ></p>
                    </div>
                    <input
                        type="file"
                        name="image"
                        id="image"
                        @change="previewImage"
                        ref="image"
                        class="opacity-0"
                        accept="image/png, image/jpeg, image/webp"
                    />
                </label>
                <img
                    :src="form.preview ? form.preview : '/no-image.png'"
                    class="w-1/2 mt-4 max-h-64"
                />
            </div>
        </div>
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
            <BreezeLabel for="categories" value="Select Categories" />
            <Multiselect v-model="form.categories" mode="tags" :options="props.categories" :object="true" />
        </div>

        <div class="mb-4">
            <BreezeLabel for="description" value="Description" />
            <BreezeTextarea
                id="description"
                class="mt-1 block w-full"
                v-model="form.description"
                required
                autocomplete="description"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="price" value="Price" />
            <BreezeInput
                id="price"
                type="text"
                class="mt-1 block w-full"
                v-model="form.price"
                required
                autofocus
                autocomplete="price"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="stock" value="Stock" />
            <BreezeInput
                id="stock"
                type="number"
                class="mt-1 block w-full"
                v-model="form.stock"
                required
                autofocus
                autocomplete="stock"
            />
        </div>

        <div class="mb-4">
            <BreezeLabel for="status" value="Status" />
            <select
                id="status"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                v-model="form.status"
                required
            >
                <option>Select Status</option>
                <option v-bind:value="false">Draft</option>
                <option v-bind:value="true">Published</option>
            </select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('products.index')"
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
