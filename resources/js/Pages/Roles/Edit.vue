<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import FormRoles from "@/Pages/Roles/Form.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
</script>
<template>
    <Head title="Edit Roles" />
    <BreezeAuthenticatedLayout>
        <template #header class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Roles
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <BreezeValidationErrors class="mb-4" />
                <div
                    v-if="$page.props.flash.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <FormRoles v-bind:editing="true" :data="$page.props.roles" :permissions="$page.props.permissions"/>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
