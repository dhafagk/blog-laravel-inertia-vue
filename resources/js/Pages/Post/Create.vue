<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

export default {
    // props: {
    //     categories: Object,
    // },
    components: {
        AppLayout,
        Link,
        Multiselect,
    },
    setup() {
        const form = useForm({
            title: null,
            body: null,
            category: null,
            tag: null,
        });

        return { form };
    },
    data() {
        return {
            value: null,
            categories: [],
            tags: [],
            error: [],
        };
    },
    created() {
        axios
            .get("/posts/get_data_categories")
            .then((res) => {
                this.categories = res.data.map((e) => {
                    return {
                        value: e.id,
                        label: e.name,
                    };
                });
            })
            .catch((err) => {
                this.error = err;
            });

        axios
            .get("/posts/get_data_tags")
            .then((res) => {
                this.tags = res.data.map((e) => {
                    return {
                        value: e.id,
                        label: e.name,
                    };
                });
            })
            .catch((err) => {
                this.error = err;
            });
    },
    computed: {
        console: () => console,
        window: () => window,
    },
};
</script>

<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div
                        class="p-6 sm:px-20 bg-white border-b border-gray-200 pb-20"
                    >
                        <div class="mt-8 mb-8 text-2xl">Create New Post</div>
                        <div
                            class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                            role="alert"
                            v-if="$page.props.flash.message"
                        >
                            <div class="flex">
                                <div>
                                    <p class="text-sm">
                                        {{ $page.props.flash.message }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="form.post('/posts')">
                            <div class="bg-white">
                                <div class="">
                                    <!-- title -->
                                    <div class="mb-4">
                                        <label
                                            for="formTitle"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Title:</label
                                        >
                                        <input
                                            type="text"
                                            v-model="form.title"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="formTitle"
                                            placeholder="Enter Title"
                                        />
                                        <div
                                            v-if="form.errors.title"
                                            class="text-red-500"
                                        >
                                            {{ form.errors.title }}
                                        </div>
                                    </div>

                                    <!-- password -->
                                    <div class="mb-4">
                                        <label
                                            for="formBody"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Body:</label
                                        >
                                        <textarea
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="formBody"
                                            placeholder="Enter Body"
                                            v-model="form.body"
                                            rows="10"
                                        ></textarea>
                                        <div
                                            v-if="form.errors.body"
                                            class="text-red-500"
                                        >
                                            {{ form.errors.body }}
                                        </div>
                                    </div>

                                    <!-- categories -->
                                    <div class="mb-4">
                                        <label
                                            for="categoryIds"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Category:</label
                                        >
                                        <Multiselect
                                            v-model="form.category"
                                            mode="tags"
                                            :close-on-select="false"
                                            :searchable="true"
                                            :create-option="true"
                                            :options="categories"
                                        />
                                        <div
                                            v-if="form.errors.category"
                                            class="text-red-500"
                                        >
                                            {{ form.errors.category }}
                                        </div>
                                    </div>

                                    <!-- tags -->
                                    <div class="mb-4">
                                        <label
                                            for="formTags"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Tags:</label
                                        >
                                        <Multiselect
                                            v-model="form.tag"
                                            mode="tags"
                                            :close-on-select="false"
                                            :searchable="true"
                                            :create-option="true"
                                            :options="tags"
                                        />
                                        <div
                                            v-if="form.errors.tags"
                                            class="text-red-500"
                                        >
                                            {{ form.errors.tags }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                            >
                                <!-- save -->
                                <span
                                    class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                        :disabled="form.processing"
                                    >
                                        Save
                                    </button>
                                </span>
                            </div>

                            <!-- remember me -->
                            <!-- <input type="checkbox" v-model="form.remember" />
                            Remember Me -->
                            <!-- submit -->
                        </form>

                        <!-- <form>
                            <div class="bg-white">
                                <div class="">
                                    <div class="mb-4">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Title:</label
                                        >
                                        <input
                                            type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="exampleFormControlInput1"
                                            placeholder="Enter Title"
                                            v-model="form.title"
                                        />
                                        <div
                                            v-if="$page.errors.title"
                                            class="text-red-500"
                                        >
                                            {{ $page.errors.title[0] }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label
                                            for="exampleFormControlInput2"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Body:</label
                                        >
                                        <textarea
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="exampleFormControlInput2"
                                            placeholder="Enter Body"
                                            v-model="form.body"
                                            rows="10"
                                        ></textarea>
                                        <div
                                            v-if="$page.errors.body"
                                            class="text-red-500"
                                        >
                                            {{ $page.errors.body[0] }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label
                                            for="categoryIds"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Category:</label
                                        >
                                        <select
                                            multiple="true"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="categoryIds"
                                            v-model="form.category_ids"
                                        >
                                            <option
                                                v-for="category in categories"
                                                :key="category.id"
                                                v-bind:value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <div
                                            v-if="$page.errors.category_ids"
                                            class="text-red-500"
                                        >
                                            {{ $page.errors.category_ids[0] }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="block text-gray-700 text-sm font-bold mb-2"
                                            >Tags:</label
                                        >
                                        <input
                                            type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="exampleFormControlInput1"
                                            placeholder="Enter Tags separate by Comma"
                                            v-model="form.tags"
                                        />
                                        <div
                                            v-if="$page.errors.tags"
                                            class="text-red-500"
                                        >
                                            {{ $page.errors.tags[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                            >
                                <span
                                    class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                >
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                        v-show="!editMode"
                                        @click="save(form)"
                                    >
                                        Save
                                    </button>
                                </span>
                                <span
                                    class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                >
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                        v-show="editMode"
                                        @click="update(form)"
                                    >
                                        Update
                                    </button>
                                </span>
                                <span
                                    class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
                                >
                                    <inertia-link
                                        :href="`/posts`"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    >
                                        Cancel
                                    </inertia-link>
                                </span>
                            </div>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
