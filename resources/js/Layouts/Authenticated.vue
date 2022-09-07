<script setup>
import { ref } from 'vue';
import BreezeNavLink from '@/Components/NavLink.vue';

const showingNavigationDropdown = ref(false);
</script>
<template>
    <div class="grid h-screen overflow-hidden grid-cols-12">
        <div style="scrollbar-width:thin;" class="h-screen overflow-y-scroll min-h-screen col-span-2 bg-[#232944]">
            <nav class="mx-2">
                <div class="flex justify-center items-center w-full mt-4">
                    <!-- <div class="mr-2 p-2 bg-gray-100 rounded-lg shadow-sm flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path d="M9 6h-2v-2c0-1.104.896-2 2-2h6c1.104 0 2 .896 2 2v2h-2v-1.5c0-.276-.224-.5-.5-.5h-5c-.276 0-.5.224-.5.5v1.5zm7 6v2h8v8h-24v-8h8v-2h-8v-5h24v5h-8zm-2-1h-4v4h4v-4z"/>
                        </svg>
                    </div> -->
                    <h6 class="font-bold tracking-wide text-white">SHAIWAVE<span class="text-red-400"> POS</span></h6>
                </div>
                <div class="m-1 mt-16 p-2 rounded-sm flex flex-col gap-1">
                    <BreezeNavLink :href="route('statistics')" class="w-full mt-2 rounded-md" :class="route().current('statistics') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <span class="text-sm font-semibold">Dashboard</span>
                        </div>
                    </BreezeNavLink>
                    <!-- <div class="mt-4 px-3">
                        <span class="text-xs text-gray-400">Pages</span>
                    </div> -->
                    <BreezeNavLink :href="route('products')" v-if="$page.props.auth.roles.includes('admin') || $page.props.auth.roles.includes('manager')" class="w-full mt-2 rounded-md" :class="route().current('products') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-rectangle-list"></i>
                            </div>
                            <span class="text-sm font-semibold">Products</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('purchase')" v-if="$page.props.auth.roles.includes('admin')" class="w-full mt-2 rounded-md" :class="route().current('purchase') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            <span class="text-sm font-semibold"> Purchases</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('orders')" class="w-full mt-2 rounded-md" :class="route().current('orders') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <span class="text-sm font-semibold">Orders</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('suppliers')" class="w-full mt-2 rounded-md" v-if="$page.props.auth.roles.includes('admin')" :class="route().current('suppliers') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-users-line"></i>
                            </div>
                            <span class="text-sm font-semibold">Suppliers</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('items')" class="w-full mt-2 rounded-md" v-if="$page.props.auth.roles.includes('admin')" :class="route().current('items') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-bars-staggered"></i>
                            </div>
                            <span class="text-sm font-semibold">Items</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('users')" class="w-full mt-2 rounded-md" :class="route().current('users') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-address-card"></i>
                            </div>
                            <span class="text-sm font-semibold">Employees</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('customers')" class="w-full mt-2 rounded-md" :class="route().current('customers') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-users-rectangle"></i>
                            </div>
                            <span class="text-sm font-semibold">Customer</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('transactions')" class="w-full mt-2 rounded-md" :class="route().current('transactions') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-money-check"></i>
                            </div>
                            <span class="text-sm font-semibold">Transaction</span>
                        </div>
                    </BreezeNavLink>

                    <BreezeNavLink :href="route('writeoff')" class="w-full mt-2 rounded-md" :class="route().current('writeoff') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>
                            <span class="text-sm font-semibold">Write Off</span>
                        </div>
                    </BreezeNavLink>

                     <!-- <BreezeNavLink :href="route('dashboard')" class="w-full mt-2 rounded-md" :class="route().current('order') ? 'bg-gray-800 text-white ' : 'text-gray-600 font-semibold'">
                        <div class="flex items-center m-2 font-custom">
                            <div class="p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 fill-current text-gray-800" :class="route().current('order') ? 'text-white ' : 'text-gray-800'" width="16" height="16" viewBox="0 0 24 24">
                                    <path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"/>
                                </svg>
                            </div>
                            <h6 class=" font-playfair">Setting</h6>
                        </div>
                    </BreezeNavLink> -->
                    <BreezeNavLink :href="route('logout')" as="button" method="post" class="w-full mt-2 rounded-md" :class="route().current('logout') ? 'bg-gray-700 text-white ' : 'text-gray-200'">
                        <div class="flex items-center justify-center p-2 gap-2">
                            <div class="flex items-center justify-right">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </div>
                            <span class="text-sm">Logout</span>
                        </div>
                    </BreezeNavLink>
                   
                </div>
                
                <!-- Primary Navigation Menu -->
                <!-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex"> -->
                            <!-- Logo -->
                            <!-- <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div> -->

                            <!-- Navigation Links -->
                            <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6"> -->
                            <!-- Settings Dropdown -->
                            <!-- <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div> -->

                        <!-- Hamburger -->
                        <!-- <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div> -->

                <!-- Responsive Navigation Menu -->
                <!-- <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </BreezeResponsiveNavLink>
                    </div> -->

                    <!-- Responsive Settings Options -->
                    <!-- <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div> -->
                <!-- </div> -->
            </nav>

        </div>
        <div class="col-span-10 h-screen bg-blue-50">
            <!-- Page Heading -->
            <div class="flex items-center justify-between text-gray-700 bg-white border-b border-gray-50 shadow-lg">
                <header class="" v-if="$slots.header">
                    <div class="mx-auto w-full py-2 px-4 font-playfair">
                        <slot name="header" />
                    </div>
                </header>
                <div>
                    <div class="p-2">
                        <div class="font-medium text-base uppercase">{{ $page.props.auth.user.name }}</div>
                        <div class="font-medium text-sm uppercase">{{ $page.props.auth.roles[0] }}</div>
                        <div v-if="$page.props.auth.permissions[0]" class="font-medium text-sm uppercase">{{ $page.props.auth.permissions[0] }}</div>
                        <!-- <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div> -->
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main style="height:calc(100vh - 76px);scrollbar-width:thin;" class="overflow-y-scroll m-2">
                <slot />
            </main>
        </div>
    </div>
</template>

