<script setup>
const { usePage }=require("@inertiajs/inertia-vue3");
const { nextTick }=require("@vue/runtime-core");

function remove(){
    usePage().props.value.auth.message = '';
}

function check(dat)
{
    nextTick()
    {
        if(dat == '')
        {
            return false
        }
        return true;
    }
}


</script>

<template>

    <div v-if="$page.props.auth.message && $page.props.auth.message !== ''" class="my-1">
        <div class="transition transform duration-700 font-medium text-green-600 rounded-sm border border-green-400 bg-gray-100 p-2 flex justify-between">
            <p>{{$page.props.auth.message}}</p>
            <div @click="remove()" class="cursor-pointer">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="fill-current text-red-300" fill-rule="evenodd" clip-rule="evenodd">
                    <path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/>
                </svg>
            </div>
        </div>
    </div>
</template>
