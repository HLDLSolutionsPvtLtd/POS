<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

emits: ['changetab']
const props = defineProps({
        tabs: Array,
        active: String,
    });


</script>
<template>
     <div>
         <div style="width:100%" class="flex sticky top-0 border-b-2 gap-12 text-sm w-full">
            <div @click="$emit('changetab', tab.name)" v-for="tab in tabs" :key="tab" :style="[active == tab.name ? {'border-color': '#406694'} : '']" :class="{'border-b-4': active == tab.name}" class="border-0 cursor-pointer py-2 -mb-1">
                <span  class="font-bold uppercase text-xs tracking-wider text-gray-500">{{tab.name}}</span>
            </div>
        </div>
        <div>
            <slot/>
        </div>
     </div>
</template>