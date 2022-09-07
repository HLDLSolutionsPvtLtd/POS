<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';

export default {
        
    props: ['orders'],
    
    data() {
        return {
            actions : {
                edit: 'false',
                delete: 'true',
            },
            active : '',
        
            headersData : [
                    {
                        name: 'id',
                        title: 'ID'
                    },
                    // {
                    //     name: 'customer',
                    //     title: 'Customer'
                    // },
                    {
                        icon: 'price',
                        name: 'total_without_gst',
                        title: 'Price',
                        type: 'number'
                    },
                    {
                        icon: 'price',
                        name: 'total_with_gst',
                        title: 'Total with tax',
                        type: 'number'
                    },
                    {
                        name: 'status',
                        title: 'Status',
                        type: 'text'
                    },
                    {
                        name: 'created_at',
                        title: 'Date',
                        type: 'date'
                    }
                ],

            tabs :
            [
                {
                    name: 'All Orders'
                },
                {
                    name: 'Daily Orders'
                },
                {
                    name: 'Weekly Orders'
                },
                {
                    name: 'Monthly Orders'
                },
                {
                    name: 'Yearly Orders'
                }
            ],
            
        }
    },
    components:{
    Table,
    Tabs,
    BreezeAuthenticatedLayout,
    SearchAndFilter,
},
    methods:
    {
        changetab(data){
            console.log(data);
            this.active = data;
        },
        
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
                    Order Details/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'All Orders'">
                        <search-and-filter
                        :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: true
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model='Sale'
                        >
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="orders" id="sales">

                            </Table>
                        </div>
                    </div>
                        
                    <div v-if="active == 'Daily Orders'">
                        <search-and-filter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: true
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model='Sale'>
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="{edit: 'false', delete: 'true'}" :data="orders">

                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'Weekly Orders'">
                        <search-and-filter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: true
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model='Sale'>
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="orders">

                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'Monthly Orders'">
                        <search-and-filter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: true
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model='Sale'>
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="orders">

                            </Table>
                        </div>
                    </div>

                    <div v-if="active == 'Yearly Orders'">
                        <search-and-filter :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: true
                        }"

                        :sortOptions = "
                        { 
                            name: false,
                            time:true,
                        }"
                        model='Sale'>
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="orders">

                            </Table>
                        </div>
                    </div>
                </Tabs>
               
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
