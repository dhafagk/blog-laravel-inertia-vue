<script setup>
import Sidebar from "@/Shared/Sidebar.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div>
        <!-- Top Bar Nav -->
        <nav class="w-full py-4 bg-blue-800 shadow">
            <div
                class="w-full container mx-auto flex flex-wrap items-center justify-between"
            >
                <nav>
                    <ul
                        class="flex items-center justify-between font-bold text-sm text-white uppercase no-underline"
                    >
                        <li>
                            <a
                                class="hover:text-gray-200 hover:underline px-4"
                                href="#"
                                >Shop</a
                            >
                        </li>
                        <li>
                            <a
                                class="hover:text-gray-200 hover:underline px-4"
                                href="#"
                                >About</a
                            >
                        </li>
                    </ul>
                </nav>

                <div
                    class="flex items-center text-lg no-underline text-white pr-6"
                >
                    <a class="" href="#">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Text Header -->
        <header class="w-full container mx-auto">
            <div class="flex flex-col items-center py-12">
                <Link
                    class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl"
                    :href="route('blog.posts')"
                >
                    Minimal Blog
                </Link>
                <p class="text-lg text-gray-600">Lorem Ipsum Dolor Sit Amet</p>
            </div>
        </header>

        <!-- Topic Nav -->
        <nav
            class="w-full py-4 border-t border-b bg-gray-100"
            x-data="{ open: false }"
        >
            <div class="block sm:hidden">
                <a
                    href="#"
                    class="md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                >
                    Topics
                    <i class="fas ml-2"></i>
                </a>
            </div>
            <div class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
                <div
                    class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2"
                >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Technology</a
                    >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Automotive</a
                    >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Finance</a
                    >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Politics</a
                    >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Culture</a
                    >
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2"
                        >Sports</a
                    >
                </div>
            </div>
        </nav>

        <div class="container mx-auto flex flex-wrap py-6">
            <!-- Posts Section -->
            <section class="w-full md:w-2/3 flex flex-col items-center px-3">
                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </section>

            <!-- Sidebar Section -->
            <Sidebar />
        </div>

        <footer class="w-full border-t bg-white pb-12">
            <div class="w-full container mx-auto flex flex-col items-center">
                <div
                    class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-6"
                >
                    <a href="#" class="uppercase px-3">About Us</a>
                    <a href="#" class="uppercase px-3">Privacy Policy</a>
                    <a href="#" class="uppercase px-3">Terms & Conditions</a>
                    <a href="#" class="uppercase px-3">Contact Us</a>
                </div>
                <div class="uppercase pb-6">&copy; myblog.com</div>
            </div>
        </footer>
    </div>
</template>
