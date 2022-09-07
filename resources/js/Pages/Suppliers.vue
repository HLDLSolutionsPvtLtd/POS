<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    props: ['suppliers'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            form: useForm({
                'name': '',
                'address': '',
                'pan_no': '',
                'gst_no': '',
                'state_code': ''
            }),
            name: '',
            key: 'product',
            active : '',
            headersData : [
                    {
                        name: 'id',
                        title: 'ID'
                    },
                    {
                        name: 'name',
                        title: 'Name',
                        type: 'text'
                    },
                    {
                        name: 'address',
                        title: 'ADDRESS',
                        type: 'text'
                    },
                    {
                        name: 'gst_no',
                        title: 'GST NO',
                        type: 'text'
                    },
                    {
                        name: 'pan_no',
                        title: 'PAN NO',
                        type: 'text'
                    },
                    {
                        name: 'state_code',
                        title: 'STATE CODE',
                        type: 'text'
                    },
                ],

            tabs : [
                {
                    name: 'All'
                },
                {
                    name: 'New'
                },
            ],
        }
    },
    components:{
        Table,
        Tabs,
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        SuccessMessage,
        SearchAndFilter,
    },
    methods:
    {
        changetab(data){
            console.log(data);
            this.active = data;
        },
        create()
        {
            this.form.post('/admin/supplier/add',{
                onSuccess:() => {
                    this.name = '';
                }
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
    <Head title="Suppliers" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2
                    class="font-bold text-gray-600 tracking-wider leading-tight"
                >
                    Suppliers/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'All'">
                        <SearchAndFilter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: true,
                            time: true,
                        }"
                        model="Supplier"/>
                        <div class="bg-gray-50">
                            <Table
                                :headers="headersData"
                                :actions="actions"
                                :data="suppliers"
                                id="supplier"
                            >
                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'New'">
                        <div style="height: calc(100vh - 180px)" class="mt-4">
                            <BreezeValidationErrors class="mb-4" />
                            <SuccessMessage class="" />
                            <div class="mt-2 py-4">
                                <form @submit.prevent="create()">
                                    <div class="mb-8 font-bold text-xs tracking-wide text-blue-700">
                                        <span>NEW SUPPLIER</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">NAME</label>
                                            <input v-model="form.name" type="text" class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>

                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">GST NO</label>
                                            <input v-model="form.gst_no" type="text" class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>

                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">PAN NO</label>
                                            <input v-model="form.pan_no" type="text" class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                   
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">STATE CODE</label>
                                            <input v-model="form.state_code" type="text" class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">ADDRESS</label>
                                            <input v-model="form.address" type="text"  class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <button type="submit" class="p-3 bg-green-400 text-white text-xs font-bold tracking-widest rounded-md">CREATE</button>
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
