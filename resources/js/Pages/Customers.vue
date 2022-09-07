<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import {useForm } from '@inertiajs/inertia-vue3';
export default {
    props : ['users', 'roles', 'permissions'],
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
                        array: 'roles',
                        name: 'name',
                        title: 'Role',
                        type: 'option',
                        options: this.roles.map(role => role.name)
                        
                    },
                    {
                        name: 'email',
                        title: 'Email',
                        type: 'text'
                    },
                ],

            tabs : [  
                {
                    name: 'Customers'
                },
            ],
            newU: false,
            newUser: useForm({
                name: '',
                phone_no: '',
                store: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: ''
            })
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
        addUser()
        {
            this.newUser.post('/admin/users/new',{

            })
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
                   Customers
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
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
                            time: true,
                        }"

                        model="Customer"
                        >
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
