<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import Table from '@/Components/Table.vue';
import Tabs from '@/Components/Tabs.vue';
import SearchAndFilter from '@/Components/SearchAndFilter.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    props: ['items'],
    data() {
        return {
            actions : {
                edit: 'true',
                delete: 'true',
            },
            form: useForm({
                'name': '',
                'unit_measurement': '',
                'description': '',
                'product_code': '',
                'image' : ''
            }),
            name: '',
            key: 'item',
            preview: '',
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
                        name: 'img',
                        title: 'Image',
                        type: 'image'
                    },
                    {
                        name: 'unit_measurement',
                        title: 'Measurement',
                        type: 'option',
                        options: [
                            'kg',
                            'piece',
                            'litre'
                        ]
                    },
                    {
                        name: 'description',
                        title: 'Description',
                        type: 'text'
                    },
                    {
                        name: 'product_code',
                        title: 'Product Code',
                        type: 'text'
                    }
                   
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
        newfile(e)
        {
            let selectedFiles = e.target.files;

            if(!selectedFiles.length) {
                return false;
                console.log('err');
            }

            this.form.image = selectedFiles[0];
        },   
        removeImg()
        {
            this.form.image = '';
        },
        changetab(data){
            console.log(data);
            this.active = data;
        },
        create()
        {
            this.form.post('/admin/items/add',{
                onSuccess:() => {
                    this.name = '';
                }
            });
        }
    },
    mounted()
    {
        this.active = this.tabs[0].name;
    },

    watch:{
        'form.image'()
        {
            if(this.form.image !== '')
            {
                this.preview = URL.createObjectURL(this.form.image);
            }
            else{
                this.preview = ''
            }
        }
    }
}
</script>
<template>
    <Head title="Items" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="">
                <h2
                    class="font-bold text-gray-600 tracking-wider leading-tight"
                >
                    Items/<span class="italic">{{ active }}</span>
                </h2>
            </div>
        </template>

        <div class="py-6 bg-gray-50">
            <div class="mx-auto sm:px-6 lg:px-8">
                <Tabs :tabs="tabs" :active="active" v-on:changetab="changetab">
                    <div v-if="active == 'All'">
                        <SearchAndFilter model="Item" :options = "
                        { 
                            filter : true, 
                            search: true, 
                            export: false
                        }"
                        :sortOptions = "
                        { 
                            name: true,
                            time:true,
                        }"
                        />
                        <div class="bg-gray-50">
                            <Table
                                :headers="headersData"
                                :actions="actions"
                                :data="items"
                                id="items"
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
                                        <span>NEW ITEM</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">Name</label>
                                            <input v-model="form.name" type="text" class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">Unit Measurement</label>
                                            <select required v-model="form.unit_measurement" name="" id="" class="border rounded-md border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-green-500">
                                                <option value="piece">Piece</option>
                                                <option value="kg">Kg</option>
                                                <option value="litre">Litre</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">Description</label>
                                            <input v-model="form.description" type="text"  class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                        <div class="flex flex-col rounded-sm relative my-2">
                                            <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">Product Code</label>
                                            <input v-model="form.product_code" type="text"  class="border-1 rounded-md border-gray-200 h-full w-full focus:ring-0 focus:border-green-500">
                                        </div>
                                        <div class="flex flex-col rounded-sm relative my-2">
                                                <div v-if="!preview" class="bg-white rounded-xl">
                                                    <label for="" class="font-semibold absolute -top-3 bg-white left-2 p-1 text-xs tracking-wider text-gray-500 italic">Image</label>
                                                    <div class="border  border-gray-300 border-dashed rounded-md cursor-pointer">
                                                        <div class="relative">
                                                            <input type="file" @change="newfile" class="absolute -z-1 w-full cursor-pointer opacity-0">
                                                        </div>
                                                        <div class="flex flex-col items-center w-full justify-center">
                                                            <div class="flex flex-col items-center justify-center">
                                                                <button class="rounded-md text-gray-500 p-2 text-sm">Choose File</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <img class="h-16 w-16 border" :src="preview" alt="">
                                                    <div @click="removeImg" class="absolute top-0">
                                                        <span class="text-red-500 cursor-pointer">Remove</span>
                                                    </div>
                                                </div>
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
