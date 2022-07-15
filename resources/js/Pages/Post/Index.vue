<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Shared/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    posts: Object,
});

const deletePost = (prop) => {
    if (!confirm("Are you sure want to delete?")) return;

    Inertia.delete("/posts/" + prop.id);
};
</script>

<template>
    <AppLayout title="Post Lists">
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
                        <div class="mt-8 mb-8 m text-2xl">Lists of Posts</div>
                        <div class="mt-8 mb-8">
                            <Link
                                :href="`/posts/create`"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
                                >Create New Post</Link
                            >
                        </div>
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
                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        >
                            <table
                                class="w-full text-sm text-left text-gray-500 overflow-hidden"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-200"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Author
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Published At
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="post in posts.data"
                                        :key="post.id"
                                        class="bg-white border-b"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900"
                                        >
                                            {{ post.title }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ post.user.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ post.created_at }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <Link
                                                v-show="
                                                    $page.props.user.id ==
                                                    post.user_id
                                                "
                                                :href="
                                                    route('posts.edit', post.id)
                                                "
                                                preserve-state
                                                class="font-medium text-blue-600 hover:underline"
                                                >Edit
                                            </Link>
                                            <button
                                                @click="deletePost(post)"
                                                v-show="
                                                    $page.props.user.id ==
                                                    post.user_id
                                                "
                                                class="font-medium text-red-500 hover:underline"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <Pagination :links="posts.links" />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
