<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SalesChart from '@/Components/SalesChart.vue'
import SalesDaily from '@/Components/SalesDaily.vue'
import TrafficChart from '@/Components/TrafiicChart.vue'
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import RevenueChart from '@/Components/RevenueChart.vue';
export default {
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            pdf: '',
            active : '',
            headersData : [
                    {
                        name: 'id',
                        title: 'ID'
                    },
                    {
                        name: 'customer',
                        title: 'Customer'
                    },
                    {
                        name: 'price',
                        title: 'Price'
                    },
                    {
                        name: 'date',
                        title: 'Date'
                    },
                    {
                        name: 'payment',
                        title: 'Payment'
                    },
                    {
                        name: 'status',
                        title: 'Status'
                    }
                ],

            tabs : [
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
    SalesChart,
    SalesDaily,
    TrafficChart,
    RevenueChart,
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
    <Head title="Statistic" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="font-semibold font-playfair">
                    Dashboard
                </h2>
            </div>
        </template>
        <div class="py-6 w-full">
            <div class="mx-4">
                <div class="w-full p-4" >
                    <p class="text-4xl tracking-wider font-semibold text-gray-400">Here is what is happpening with your store today</p>
                </div>
                <div class="p-4 flex gap-2">
                    <div class="p-4 w-1/3 bg-gray-200 rounded shadow-sm">
                        <SalesDaily/>
                    </div>

                    <div class="p-4 w-1/3 bg-gray-200 rounded shadow-sm">
                        <revenue-chart/>
                    </div>

                    <div class="p-4 w-1/3 bg-gray-200 rounded shadow-sm">
                        <TrafficChart/>
                    </div>
                </div>
            </div>
            <div class="m-8">
                <SalesChart/>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
