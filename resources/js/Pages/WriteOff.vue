<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    props: ['products', 'writeoffs', 'inventories'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            key: 'product',
            data: '',
            active : '',
            ToWriteoff: useForm({
                type: '',
                id : '',
                remarks: '',
                quantity: ''
            }),
           
            Headers: [
                {
                    obj: 'wroteoffs',
                    exclude: false,
                    name: 'id',
                    title: 'ID'
                },
                {
                    exclude: false,
                    obj: 'item',
                    name: 'name',
                    title: 'Name',
                    type: 'text'
                },
                 {
                    obj: 'wroteoffs',
                    exclude: false,
                    name: 'quantity',
                    title: 'Quantity',
                    type: 'number'
                },
                {
                    obj: 'wroteoffs',
                    exclude: false,
                    name: 'remarks',
                    title: 'Remarks',
                    type: 'text',
                },
            ],
            tabs : [
                {
                    exclude: false,
                    name: 'Wrote Offs'
                },
                {
                    name: 'Write Off'
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
        submit(){
            this.ToWriteoff.post('/admin/writeoff',{

            });
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
        axios.get('/admin/wroteoff/items')
        .then(res => this.data = res.data);
    }
}
</script>
<template>
    <Head title="Inventory Management" />

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
                    <div v-if="active == 'Wrote Offs'">
                        <SearchAndFilter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time: true,
                        }"
                        model="Writeoff"/>
                        <div class="bg-gray-50">
                            <Table
                                :headers="Headers"
                                :actions="actions"
                                :data="data"
                                id="writeoff"
                            >
                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'Write Off'" class="min-h-screen">
                        <BreezeValidationErrors class="my-4" />
                        <SuccessMessage class="my-4" />
                        
                        <div  class="mt-6 sticky top-0 bg-gray-100">
                            <div>
                                <form @submit.prevent="submit()">
                                    <div class="flex gap-2">
                                        <div class="flex flex-col w-1/5 rounded-sm">
                                            <label class="font-bold text-xs tracking-wider text-gray-400">SELECT TYPE</label>
                                            <select required v-model="ToWriteoff.type" class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option value="inventory">Inventory</option>
                                                <option value="product">Products</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col w-1/5 rounded-sm">
                                            <label class="font-bold text-xs tracking-wider text-gray-400">SELECT ITEM</label>
                                            <select required v-model="ToWriteoff.id" class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option v-if="ToWriteoff.type == 'inventory'" v-for="product in inventories" :value="product.id">{{product.item.name}}</option>
                                                <option v-if="ToWriteoff.type == 'product'" v-for="product in products" :value="product.id">{{product.inventory.item.name}}</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col w-1/5 rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">QUANTITY</label>
                                            <input  type="number" required v-model="ToWriteoff.quantity"  class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>
                                        <div class="flex flex-col w-1/5 rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">REMARKS</label>
                                            <input  type="text" v-model="ToWriteoff.remarks" required class="border placeholder-gray-900 text-gray-500 tracking-wider text-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button type="submit" class="flex items-center leading-1 text-xs tracking-wider rounded text-white mt-4 p-3 bg-blend-color-burn bg-indigo-800 font-extrabold">
                                                WRITE OFF
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
                </Tabs>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
