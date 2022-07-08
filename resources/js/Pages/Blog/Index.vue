<!-- <script>
import BlogLayout from "@/Layouts/BlogLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    posts: Object,
    user_posts: String,
    category: String,
    tag: String,
  },
  components: {
    BlogLayout,
    Link,
  },
  computed: {
    console: () => console,
    window: () => window,
  },
  methods: {
    // parseData: (data) => JSON.parse(JSON.stringify(data))[0].name,
    // getUserName() {
    //   return this.parseData(this.user);
    // },
  },
};
</script> -->

<script setup>
import BlogLayout from "@/Layouts/BlogLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    posts: Object,
    user_posts: String,
    category: String,
    tag: String,
});
</script>

<template>
    <BlogLayout title="Blog">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Blog
            </h2>
        </template> -->

        <div v-if="$page.url.startsWith('/user')">user : {{ user_posts }}</div>
        <div v-if="$page.url.startsWith('/category')">
            category: {{ category }}
        </div>
        <div v-if="$page.url.startsWith('/tag')">tag: {{ tag }}</div>

        <article
            v-for="post in posts"
            :key="post.id"
            class="flex flex-col shadow my-4"
        >
            <!-- Article Image -->
            <Link :href="`/${post.slug}`" class="hover:opacity-75">
                <img
                    src="https://source.unsplash.com/collection/1346951/1000x500?sig=1"
                />
            </Link>
            <div class="bg-white flex flex-col justify-start p-6">
                <div class="text-blue-700 text-sm font-bold uppercase pb-4">
                    <template
                        v-for="(category, index) in post.categories"
                        :key="category.slug"
                    >
                        <template v-if="index > 0">, </template>
                        <Link :href="`/category/${category.slug}`">{{
                            category.name
                        }}</Link>
                    </template>
                </div>
                <Link
                    :href="`/${post.slug}`"
                    class="text-3xl font-bold hover:text-gray-700 pb-4"
                    >{{ post.title }}</Link
                >
                <p class="text-sm pb-3">
                    By
                    <Link
                        :href="`/user/${post.user.id}`"
                        class="font-semibold hover:text-gray-800"
                        >{{ post.user.name }}</Link
                    >, Published on {{ post.created_at }}
                </p>
                <Link :href="`/${post.slug}`" class="pb-6">{{
                    post.body
                }}</Link>
                <Link
                    :href="`/${post.slug}`"
                    class="uppercase text-gray-800 hover:text-black"
                    >Continue Reading <i class="fas fa-arrow-right"></i
                ></Link>
            </div>
        </article>
    </BlogLayout>
</template>
