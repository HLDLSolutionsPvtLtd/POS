<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import { computed } from '@vue/runtime-core';
export default {
    props: ['stores', 'transfers', 'products'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            transfer: useForm({
                item: '',
                quantity: '',
                remarks: '',
                store_id: computed(() => usePage().props.value.auth.store.id)
            }),
            key: 'product',
            active : '',
            transferHeaders: [
                {
                    name: 'id',
                    title: 'ID',
                },
                {
                    obj: 'inventory',
                    obj2: 'item',
                    name: 'name',
                    title: 'Item',
                },
                {
                    obj: 'destination',
                    name: 'name',
                    title: 'Destination'
                },
                {
                    name: 'quantity',
                    title: 'Quantity'
                },
                {
                    name: 'status',
                    title: 'Status'
                },
                {
                    name: 'remarks',
                    title: 'Remarks'
                },
            ],

            headersData : [
                    {
                        name: 'id',
                        title: 'ID'
                    },
                    {
                        exclude: true,
                        obj: 'inventory',
                        obj2: 'item',
                        name: 'name',
                        title: 'Name',
                        type: 'text'
                    },
                    {
                        name: 'quantity',
                        title: 'No of stocks',
                        type: 'number'
                    },
                    {
                        exclude: true,
                        obj: 'inventory',
                        icon: 'price',
                        name: 'unit_price',
                        title: 'Price',
                        type: 'number'
                    },
                    {
                        exclude: true,
                        obj: 'inventory',
                        icon: 'price',
                        name: 'selling_price',
                        title: 'Selling Price',
                        type: 'number',
                    },
                    {
                        exclude: true,
                        obj: 'inventory',
                        obj2: 'item',
                        name: 'unit_measurement',
                        title: 'Measurement',
                        type: 'option',
                        options: ['piece', 'kg', 'litre']
                    },
                    {
                        exclude: true,
                        obj: 'inventory',
                        name: 'gst_percent',
                        title: 'GST Percent',
                        type: 'number'
                    },
                ],

            tabs : [
                {
                    name: 'Products'
                },
                {
                    name: 'Transfer'
                },
                {
                    name: 'Incoming'
                },
            ],
        }
    },
    components:{
        Table,
        Tabs,
        SuccessMessage,
        BreezeValidationErrors,
        BreezeAuthenticatedLayout,
        SearchAndFilter,
    },
    methods:
    {
        changetab(data){
            console.log(data);
            this.active = data;
        },

        transferDo()
        {
            this.transfer.post('/product/transfer');
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    }
}
</script>
<template>
    <Head title="Product Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="font-bold tracking-wider leading-tight">
                    Product Management/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'Products'">
                        <SearchAndFilter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model="Product"/>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="products" id="product">

                            </Table>
                        </div>
                    </div>
                        
                    <div v-if="active == 'Transfer'">
                        <div style="height:calc(100vh - 180px)" class="mt-4">
                            <BreezeValidationErrors class="my-4" />
                            <SuccessMessage class="" />
                            <div class="mt-4 bg-gray-50">
                                <div class="sticky top-0">
                                    <form @submit.prevent="transferDo">
                                        <div class="flex gap-2">
                                            <div class="flex flex-col w-1/4 rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">SELECT ITEM</label>
                                                <select required v-model="transfer.item"  name="" id="" class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                    <option v-for="product in products.data" :value="product">{{product.inventory.item.name}}</option>
                                                </select>
                                            </div>
                                           
                                            <div class="flex flex-col w-1/4 rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">QUANTITY</label>
                                                <input  type="number" required v-model="transfer.quantity"  class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>

                                            <div class="flex flex-col w-1/4 rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">REMARKS</label>
                                                <input  type="text" v-model="transfer.remarks" required class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            <div class="flex items-center justify-center">
                                                <button type="submit" class="flex items-center leading-1 text-xs tracking-wider rounded text-white mt-4 p-3 bg-blend-color-burn bg-indigo-800 font-extrabold">
                                                    TRANSFER
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white ml-2 -rotate-90" width="24" height="24" viewBox="0 0 24 24">
                                                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm2 9h-4v-1h4v1zm0-3v1h-4v-1h4zm-2 13l-6-6h4v-3h4v3h4l-6 6z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="active == 'Incoming'">
                        <div>
                            <Table
                                :headers="transferHeaders"
                                :actions="{
                                    options: true,
                                }"
                                :data="transfers"
                                id = 'transfer'
                            >
                            </Table>
                        </div>
                    </div>
                </Tabs>
               
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
