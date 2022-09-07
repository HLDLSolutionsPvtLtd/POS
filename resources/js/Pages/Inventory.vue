<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    props: ['inventories', 'stores', 'transfers'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            key: 'product',
            transfer: useForm({
                item: '',
                quantity: '',
                remarks: '',
                store_id:''
            }),
            active : '',
            
            headersData : [
                    {
                        name: 'id',
                        title: 'ID',
                        type: 'text',

                    },
                    {
                        obj: 'item',
                        name: 'name',
                        title: 'Name',
                        type: 'text',
                    },
                    {
                        name: 'hsn',
                        title: 'HSN',
                        type: 'text',
                    },
                    {
                        name: 'gst_percent',
                        title: 'GST %',
                        type: 'text'
                    },
                    {
                        name: 'quantity',
                        title: 'Quantity',
                        type: 'number'
                    },
                    {
                        icon: 'price',
                        name: 'unit_price',
                        title: 'Unit Price'
                    },
                    {
                        icon: 'price',
                        name: 'selling_price',
                        title: 'Selling Price',
                        type: 'number'
                    },
                    {
                        name: 'expiry_date',
                        title: 'Expiration',
                        type: 'date'
                    },
                ],
            transferHeaders: [
                {
                    name: 'id',
                    title: 'ID',
                    type: 'hidden'
                },
                {
                    obj: 'inventory',
                    obj2: 'item',
                    name: 'name',
                    title: 'Item',
                    exclude: true
                },
                {
                    obj: 'destination',
                    name: 'name',
                    title: 'Destination',
                    exclude: true
                },
                {
                    name: 'quantity',
                    title: 'Quantity',
                    type : 'text',
                },
                {
                    name: 'status',
                    title: 'Status',
                    type: 'text',
                },
                
                {
                    name: 'remarks',
                    title: 'Remarks',
                    type: 'text',
                },
            ],
            tabs : [
                {
                    name: 'Inventory'
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
        BreezeAuthenticatedLayout,
        SearchAndFilter,
        SuccessMessage,
        BreezeValidationErrors
    },
    methods:
    {
        changetab(data){
            console.log(data);
            this.active = data;
        },
        transferFromInventory()
        {
            this.transfer.post('/admin/transfer',{

            });
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    }
}
</script>
<template>
    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2
                    class="font-bold text-gray-600 tracking-wider leading-tight"
                >
                    Inventory Management/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'Inventory'">
                        <SearchAndFilter model='Inventory' :options = "
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
                        />
                        <div class="">
                            <Table
                                :headers="headersData"
                                :actions="actions"
                                :data="inventories"
                                id="inventory"
                            >
                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'Transfer'">
                        <BreezeValidationErrors class="my-4" />
                        <SuccessMessage/>
                        <div class="mt-4 bg-gray-100">
                            <div class="sticky top-0">
                                <form @submit.prevent="transferFromInventory">
                                    <div class="flex gap-2">
                                        <div class="flex flex-col w-1/4 rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">SELECT ITEM</label>
                                            <select required v-model="transfer.item"  name="" id="" class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option v-for="product in inventories.data" :value="product">{{product.item.name}}</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col w-1/4 rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">QUANTITY</label>
                                            <input  type="number" required v-model="transfer.quantity"  class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>

                                        <div class="flex flex-col w-1/4 rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">DESTINATION STORE</label>
                                            <select required v-model="transfer.store_id" name="" id="" class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option v-for="store in stores" :value="store.id">{{store.name}}</option>
                                            </select>
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
                            <div class="bg-gray-200 mt-4">
                                <div class="p-4 border-b-2 border-blue-200">
                                    <h6 class="text-xs tracking-wider font-bold text-blue-500">TRANSFER HISTORY</h6>
                                </div>
                                <Table
                                    :headers="transferHeaders"
                                    :actions="actions"
                                    :data="transfers"
                                    id = 'transfer'
                                >
                                </Table>
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
