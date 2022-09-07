<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import {useForm } from '@inertiajs/inertia-vue3';
export default {
    props : ['users'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            active : '',
            data : [
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },

                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
                    {
                        id: 'ORD2342',
                        customer: 'Lalruatpuia',
                        price: '56',
                        date: '12.06.2022',
                        payment: 'Bank Transfer',
                        status: 'complete',
                    },
            ],
            headersData : [
                    {
                        name: 'id',
                        title: 'ID',
                    },
                    {
                        name: 'name',
                        title: 'Name',
                        type: 'text'
                    },
                    {
                        name: 'phone_no',
                        title: 'Phone Number',
                        type: 'text'
                    },
                    {
                        name: 'email',
                        title: 'Email',
                        type: 'text'
                    },
                ],

            tabs : [
                {
                    name: 'Employees'
                },
                {
                    name: 'Customers'
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
            this.active = data;
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    }
}
</script>
<template>
    <Head title="Order Details" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="font-bold text-gray-600 tracking-wider leading-tight">
                    <span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                     <div v-if="active == 'Employees'">
                        <search-and-filter
                        :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: true,
                            time:false,
                        }"
                        >
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <BreezeValidationErrors class="my-4" />
                            <SuccessMessage class="" />
                            <Table :headers="headersData" :actions="{edit: 'false', delete: 'true'}" :data="users">

                            </Table>
                        </div>
                    </div>
                    <div v-if="active == 'Customers'">
                        <search-and-filter
                        :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: true,
                            time:false,
                        }"
                        model="User">
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="users" id="users">

                            </Table>
                        </div>
                    </div>
                </Tabs>
               
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
