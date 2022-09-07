<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
export default {
    props: ['transactions'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            active : '',
            headersData : [
                    {
                        name: 'id',
                        title: 'Order ID'
                    },
                    {
                        name: 'customer',
                        title: 'Customer'
                    },
                    {
                        name: 'created_at',
                        title: 'Date'
                    },
                    {
                        name: 'status',
                        title: 'Status'
                    },
                ],

            tabs : [
                {
                    name: 'Cash Transaction'
                },
                {
                    name: 'Online Transaction'
                },
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
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    }
}
</script>
<template>
    <Head title="Transactions" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="font-bold text-gray-600 tracking-wider leading-tight">
                    Transactions/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'Cash Transaction'">
                        <search-and-filter :options = "
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
                        model="Transaction">
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="transactions">
                            </Table>
                        </div>
                    </div>
                        
                   <div v-if="active == 'Online Transaction'">
                        <search-and-filter
                        :options = "
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
                        model="Transaction">
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <Table :headers="headersData" :actions="actions" :data="transactions">
                            </Table>
                        </div>
                    </div>
                </Tabs>
               
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
