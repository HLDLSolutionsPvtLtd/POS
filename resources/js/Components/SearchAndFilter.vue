<template>
    <div class="flex mt-6">
        <div class="flex w-1/2 relative">
            <input type="search" v-model="key" @input="search" class="w-full pl-10 border border-gray-400 focus:ring-0 rounded-lg shadow-sm" :placeholder="'Search '+model+' by id or name'" name="" id="">
            <svg width="20" height="20" viewBox="0 0 24 20" class="fill-current text-blue-300 absolute top-2 left-2" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                <path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z"/>\
            </svg>
        </div>
        <div class="flex gap-2 ml-2 font-semibold">
            <div v-show="options.filter" class="flex relative">
                <div @click="filter = !filter; exportPop = false" class="flex items-center cursor-pointer gap-2 justify-center px-2 text-sm border border-gray-400 rounded-md shadow-sm bg-white text-gray-500 tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 24 24">
                        <path d="M7.445 7.48V5.672L5.665 7.48h1.78zm1.09-4.42c.304.12.465.39.465.706v16.437a.784.784 0 01-.783.797.762.762 0 01-.772-.781V8.982H4.003a.832.832 0 01-.765-.204.759.759 0 01.002-1.105L7.652 3.23a.832.832 0 01.882-.17zm8.02 15.269l1.78-1.81h-1.78v1.81zm4.207-3.107a.76.76 0 01-.002 1.106l-4.412 4.442a.832.832 0 01-.882.17c-.305-.12-.466-.39-.466-.706V3.797c0-.432.332-.797.783-.797.45 0 .772.35.772.781v11.237h3.442a.833.833 0 01.765.204z"/>
                    </svg>
                    <span class="text-xs">SORT</span>
                </div>
                <div v-show="filter" class="absolute top-10 w-40 -left-26 mt-2 flex cursor-pointer rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <div v-show="sortOptions.name" @click="sort.var = 'name'; sort.val = 'DESC'; filter = false; search()" class="text-gray-700 px-4 py-2 text-sm flex items-center gap-6" role="menuitem" tabindex="-1" id="menu-item-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                                <path d="M6 22l6-8h-4v-12h-4v12h-4l6 8zm11.694-19.997h2.525l3.781 10.997h-2.421l-.705-2.261h-3.935l-.723 2.261h-2.336l3.814-10.997zm-.147 6.841h2.736l-1.35-4.326-1.386 4.326zm-.951 11.922l3.578-4.526h-3.487v-1.24h5.304v1.173l-3.624 4.593h3.633v1.234h-5.404v-1.234z"/>
                            </svg>
                            Name A-Z
                        </div>
                        <div v-show="sortOptions.name" @click="sort.var = 'name'; sort.val = 'ASC'; filter = false; search()" class="text-gray-700 px-4 py-2 text-sm flex items-center gap-6" role="menuitem" tabindex="-1" id="menu-item-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                                <path d="M6 2l-6 8h4v12h4v-12h4l-6-8zm18 9v2h-8v-1.984l.009-.012 5.086-7.004h-5.095v-1.993h7.985v1.887l-5.318 7.106h5.333zm-4.946 4.011h1.586l2.374 6.989h-1.521l-.442-1.436h-2.471l-.455 1.436h-1.466l2.395-6.989zm-.093 4.348h1.719l-.848-2.75-.871 2.75z"/>
                            </svg>
                            Name Z-A
                        </div>
                        <div @click="sort.var = 'created_at'; sort.val = 'DESC'; filter = false; search()" v-show="sortOptions.time" class="text-gray-700 px-4 py-2 text-sm flex items-center gap-6" role="menuitem" tabindex="-1" id="menu-item-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" class="flex items-center" viewBox="0 0 24 24">
                                <path d="M12 5.173l2.335 4.817 5.305.732-3.861 3.71.942 5.27-4.721-2.524-4.721 2.525.942-5.27-3.861-3.71 5.305-.733 2.335-4.817zm0-4.586l-3.668 7.568-8.332 1.151 6.064 5.828-1.48 8.279 7.416-3.967 7.416 3.966-1.48-8.279 6.064-5.827-8.332-1.15-3.668-7.569z"/>
                            </svg>
                            Latest
                        </div>
                        <div @click="sort.var = 'created_at'; sort.val = 'ASC'; filter = false; search()" v-show="sortOptions.time" class="text-gray-700 px-4 py-2 text-sm flex items-center gap-6" role="menuitem" tabindex="-1" id="menu-item-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            Oldest
                        </div>
                    </div>
                </div>   
            </div>

            <div class="flex">
                <div v-show="options.export" class="flex items-center justify-center text-sm border border-gray-400 rounded-md shadow-sm bg-white text-gray-500 tracking-wide relative">
                    <div @click="exportPop = !exportPop; filter = false" class="flex px-2 items-center justify-center cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" class="mr-1" viewBox="0 0 24 24">
                            <path d="M16 2v7h-2v-5h-12v16h12v-5h2v7h-16v-20h16zm2 9v-4l6 5-6 5v-4h-10v-2h10z"/>
                        </svg>
                        <span class="text-xs">EXPORT</span>
                    </div>
                    <div v-show="exportPop" class="absolute top-10 w-56 left-0 mt-2 flex cursor-pointer rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <div>
                                <div class="text-gray-700 px-4 py-2 text-sm flex items-center gap-6" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <div>
                                    <span class="text-sm font-thin text-blue-500 tracking-wider py-2 border-b flex items-center flex-nowrap">
                                        <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" height="17" width="17" class="fill-current text-green-400 mr-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m12.002 21.534c5.518 0 9.998-4.48 9.998-9.998s-4.48-9.997-9.998-9.997c-5.517 0-9.997 4.479-9.997 9.997s4.48 9.998 9.997 9.998zm0-1.5c-4.69 0-8.497-3.808-8.497-8.498s3.807-8.497 8.497-8.497 8.498 3.807 8.498 8.497-3.808 8.498-8.498 8.498zm0-6.5c-.414 0-.75-.336-.75-.75v-5.5c0-.414.336-.75.75-.75s.75.336.75.75v5.5c0 .414-.336.75-.75.75zm-.002 3c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z" fill-rule="nonzero"/>
                                        </svg>
                                        Please pick date range
                                    </span>

                                        <div class="flex gap-2 flex-col mt-2">
                                            <label for="" class="text-sm text-gray-600 tracking-wider">From</label>
                                            <input v-model="from" class="border text-gray-500 text-sm border-gray-300 rounded-md focus:ring-0 focus:border-gray-400" type="date">
                                        </div>

                                        <div class="flex gap-2 flex-col mt-2">
                                            <label for="" class="text-sm text-gray-600 tracking-wider">To</label>
                                            <input v-model="to" class="border text-gray-500 text-sm border-gray-300 rounded-md focus:ring-0 focus:border-gray-400" type="date">
                                        </div>
                                        <div class="mt-6 mb-2 flex justify-between">
                                            <button @click="exportPop = false" class="p-1 border-green-500 text-red-600 border text-xs font-bold tracking-wider rounded">
                                                CLOSE
                                            </button>
                                            <a :href="'/admin/export/'+model.toLowerCase()+'?from='+from+'&to='+to" class="p-1 border-green-500 text-red-600 border text-xs font-bold tracking-wider rounded">
                                                EXPORT
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
const { Inertia } = require("@inertiajs/inertia");
const {ref} = require("@vue/runtime-core");

const props = defineProps({
        model: String,
        options: Object,
        sortOptions: Object,
    });

var key = ref('');
var filter = ref(false);
var exportPop = ref(false);
var from = ref('');
var to = ref('');

var sort = ref({
    var : '',
    val : ''
})

const search =  function()
{
    if(sort.value.var)
    {
        Inertia.get('/admin/search', {
            key : key.value,
            model : props.model,
            val: sort.value.val,
            var: sort.value.var
        }, {preserveState:true})
    }
    else
    {
        Inertia.get('/admin/search', {
            key : key.value,
            model : props.model,
        }, {preserveState:true})
    }
}
</script>
