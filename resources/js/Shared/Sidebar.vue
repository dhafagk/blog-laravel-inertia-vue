<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";

const logout = () => {
    Inertia.post(route("logout"));
};
</script>

<template>
    <aside class="w-full md:w-1/3 flex flex-col items-center px-3">
        <div class="w-full bg-white shadow flex flex-col my-4 p-6">
            <p class="text-xl font-semibold pb-5">About Us</p>
            <p class="pb-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Maecenas mattis est eu odio sagittis tristique. Vestibulum ut
                finibus leo. In hac habitasse platea dictumst.
            </p>
            <a
                href="#"
                class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4"
            >
                Get to know us
            </a>
        </div>

        <div class="w-full bg-white shadow flex flex-col my-4 p-6">
            <p class="text-xl font-semibold pb-5">Category List</p>
            <!-- {{ console.log(catList) }} -->
            <ul class="pb2">
                <!-- <li v-for="cat in $page.props.categoryList" :key="cat.slug">
          <Link :href="`/category/${cat.slug}`">{{ cat.name }}</Link>
        </li> -->
            </ul>
        </div>

        <div class="w-full bg-white shadow flex flex-col my-4 p-6">
            <p class="text-xl font-semibold pb-5">Meta</p>
            <ul v-if="$page.props.user" class="pb2 pl-4 list-disc">
                <li><Link :href="route('dashboard')">Dashboard</Link></li>
                <li>
                    <form method="POST" @submit.prevent="logout()">
                        <button>Log Out</button>
                    </form>
                </li>
            </ul>
            <ul v-else class="pb2 pl-4 list-disc">
                <li><Link :href="route('login')">Login</Link></li>
                <li><Link :href="route('register')">Register</Link></li>
            </ul>
        </div>
    </aside>
</template>
