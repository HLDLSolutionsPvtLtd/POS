<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import {useForm} from '@inertiajs/inertia-vue3';

export default {

    props: ['purchases', 'suppliers', 'items'],

    data() {
        return {
            actions : {
                edit: 'false',
                delete: 'true',
            },
            preview: '',
            key: 'product',
            active : '',
            purchase: useForm({
                supplier_id : '',
                supplier_invoice: '',
                total_amount: '',
                payment_method: '',
                transaction_id: '',
                payment_date: '',
                particulars: [],
            }),
            particular: useForm({
                    item_id: '',
                    unit_price: '',
                    quantity: '',
                    gst_percent: '',
                    mfg_date: '',
                    expiry_date: '',
                    selling_price: '',
                    hsn: '',
                    description: '', 
                }),
           
            headersData : [
                    {
                        name: 'id',
                        title: 'ID'
                    },
                   
                    {
                        name: 'supplier_id',
                        title: 'Supplier'
                    },
                    {
                        name: 'supplier_invoice',
                        title: 'Supplier Invoice'
                    },
                    {
                        name: 'total_amount',
                        title: 'Total'
                    },
                    {
                        name: 'payment_method',
                        title: 'Payment Method'
                    },
                    {
                        name: 'transaction_id',
                        title: 'Transaction ID'
                    },
                     {
                        name: 'payment_date',
                        title: 'Payment Date'
                    },
                ],

            tabs : [
                {
                    name: 'Purchases'
                },
                {
                    name: 'New Purchase'
                },
            ],
        }
    },
    components:{
        Table,
        Tabs,
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        SearchAndFilter,
        SuccessMessage
    },
    methods:
    {
        changetab(data){
            console.log(data);
            this.active = data;
        },
        removeParticular(item)
        {
            var index = this.purchase.particulars.findIndex(el => {
                if(el.id = item.id)
                {
                    return true
                }
            })

            this.purchase.particulars.splice(index, 1);
        },
        addParticular()
        {
            this.purchase.particulars.push({
                    item_id: this.particular.item_id,
                    unit_price: this.particular.unit_price,
                    quantity: this.particular.quantity,
                    gst_percent: this.particular.gst_percent,
                    mfg_date: this.particular.mfg_date,
                    expiry_date: this.particular.expiry_date,
                    selling_price: this.particular.selling_price,
                    hsn: this.particular.hsn,
                    description: this.particular.description,
            });
        },
        submit(){
            this.purchase.post('/admin/purchase/add',{
               
            });
        },
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    },
    watch:{
        
    }
}
</script>
<template>
    <Head title="Product Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="font-bold text-gray-600 tracking-wider leading-tight">
                    Purchase Management/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'Purchases'">
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
                        
                        model="Purchase"/>
                        <div class="bg-white">
                            <Table :headers="headersData" :actions="actions" :data="purchases" id="purchase">

                            </Table>
                        </div>
                    </div>
                        
                    <div v-if="active == 'New Purchase'">
                        <div style="" class="mt-4">   
                            <div class="p-4 bg-white rounded">
                                <div>
                                    <span class="text-xs tracking-wider font-bold text-gray-400 p-4">PURCHASE DETAILS</span>
                                </div>
                                <BreezeValidationErrors class="mb-4 mx-4" />
                                <SuccessMessage class="" />
                                <div class="mt-2 p-4">
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">SUPPLIER</label>
                                            <select required v-model="purchase.supplier_id" name="" id="" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option v-for="supplier in suppliers" :value="supplier.id">{{supplier.name}}</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">SUPPLIER INVOICE</label>
                                            <input v-model="purchase.supplier_invoice" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>
                                   
                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">TOTAL AMOUNT</label>
                                            <input v-model="purchase.total_amount" type="text" placeholder="&#8377;" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>

                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">PAYMENT METHODS</label>
                                            <select required v-model="purchase.payment_method" name="" id="" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                <option value="upi">UPI</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="cash">Cash</option>
                                                <option value="card">Card</option>
                                            </select>
                                        </div>

                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">TRANSACTION ID</label>
                                            <input v-model="purchase.transaction_id" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>

                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-gray-400">PAYMENT DATE</label>
                                            <input v-model="purchase.payment_date" type="date" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 p-4 bg-white rounded w-full">
                                <div>
                                    <span class="text-xs tracking-widest p-4 font-bold text-gray-400">PARTICULARS</span>
                                </div>
                                <form @submit.prevent="addParticular()">
                                    <div class="p-4">
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">NAME</label>
                                                <select required v-model="particular.item_id" name="" id="" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                    <option v-for="item in items" :value="item.id">{{item.name}}</option>
                                                </select>
                                            </div>

                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">UNIT PRICE</label>
                                                <input required v-model="particular.unit_price" type="text" placeholder="&#8377;" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>

                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">QUANTITY</label>
                                                <input required v-model="particular.quantity" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>

                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">GST PERCENT</label>
                                                <input required v-model="particular.gst_percent" type="text" placeholder="&#8377;" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            
                                            <div class="flex flex-col rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">MFG DATE</label>
                                                <input required v-model="particular.mfg_date" type="date" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>

                                            <div class="flex flex-col rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">EXPIRY DATE</label>
                                                <input required v-model="particular.expiry_date" type="date" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>

                                            <div class="flex flex-col rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">SELLING PRICE</label>
                                                <input required v-model="particular.selling_price" type="text" placeholder="&#8377;" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                       
                                            <div class="flex flex-col rounded-sm">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">HSN</label>
                                                <input required v-model="particular.hsn" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                        </div>
                                        <div>
                                            
                                        </div>
                                        <div class="mt-4">
                                            <div>
                                                <button type="submit" class="p-2 text-xs bg-green-700 font-bold tracking-wider rounded text-white">ADD</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div style="width:100%" class="grid grid-cols-9 border-b-2 pb-2">
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">ID</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">UNIT PRICE</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">QUANTITY</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">GST PERCENT</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">MFG</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">EXPIRY</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">SELLING PRICE</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">HSN</label>
                                            </div>
                                            <div class="">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">ACTIONS</label>
                                            </div>
                                        </div>
                                        <div v-for="item in purchase.particulars" style="width:100%" class="grid grid-cols-9 border-b-2 pb-2">
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.item_id}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold  text-xs tracking-wider text-gray-400">{{item.unit_price}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.quantity}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.gst_percent}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.mfg_date}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.expiry_date}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.selling_price}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label for="" class="font-bold text-xs tracking-wider text-gray-400">{{item.hsn}}</label>
                                            </div>
                                            <div class=" flex items-center">
                                                <label @click="removeParticular(item)" for="" class="font-bold text-xs tracking-wider text-red-400">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="mx-4 mt-4">
                                    <button @click="submit()" class="bg-blue-700 rounded-sm p-2 px-3 text-white font-bold tracking-widest text-sm">CREATE</button>
                                </div>
                            </div>
                            
                           
                        </div>
                       
                    </div>
                </Tabs>
               
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
