<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
export default {
    props: ['stores'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
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
            this.$inertia.post('/admin/store/add',{
                name : this.name,
                
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
    <Head title="Store" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2
                    class="font-bold text-gray-600 tracking-wider leading-tight"
                >
                    Store/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'All'">
                        <SearchAndFilter model="Store" :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"

                        :sortOptions = "
                        { 
                            name: true,
                            time:false,
                        }"/>
                        <div class="bg-gray-50">
                            <Table
                                :headers="headersData"
                                :actions="actions"
                                :data="stores"
                                id="store"
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
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex flex-col rounded-sm">
                                            <label for="" class="font-bold text-xs tracking-wider text-blue-400">NAME</label>
                                            <input type="text" v-model="name" required class="border border-blue-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                        </div>
                                        <div class="flex items-center ">
                                            <button type="submit" class="bg-blue-400 mt-4 p-3 text-white font-bold tracking-wider text-sm">CREATE</button>
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
