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
                        name: 'role',
                        key: 'name',
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
                    name: 'Employees'
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
                            time: true,
                        }"
                        model="User">
                        </search-and-filter>
                        <div class="bg-gray-50">
                            <div class="mx-6 mt-4">
                                <button v-if="!newU" @click="newU = !newU" class="text-xs mt-4 p-2 text-white font-bold rounded tracking-wider bg-blue-400">NEW EMPLOYEE</button>
                                <button v-else @click="newU = !newU" class="text-xs mt-4 p-2 text-white font-bold rounded tracking-wider bg-red-400">BACK</button>
                            </div>
                            <BreezeValidationErrors class="my-2" />
                            <SuccessMessage class="" />
                            <div v-if="!newU">
                                 <Table  :headers="headersData" :actions="{edit: 'true', delete: 'true'}" :data="users" id="users">
                                </Table>
                            </div>
                            <div v-else class="my-4 p-2 rounded w-full">
                                <div>
                                    <span class="text-xs tracking-widest p-4 font-bold text-blue-500">NEW USER</span>
                                </div>
                                <form @submit.prevent="addUser">
                                    <div class="p-4">
                                        <div class="grid grid-cols-6 gap-2">
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">NAME</label>
                                                <input required v-model="newUser.name" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">ROLE</label>
                                                <select required v-model="newUser.role" name="" id="" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                    <option v-for="role in roles" :value="role.name">{{role.name}}</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">STORE</label>
                                                <select required v-model="newUser.store" name="" id="" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                                    <option v-for="permission in permissions" :value="permission.name">{{permission.name}}</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">PHONE NUMBER</label>
                                                <input required v-model="newUser.phone_no" type="text" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">EMAIL</label>
                                                <input required v-model="newUser.email" type="email" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">PASSWORD</label>
                                                <input required v-model="newUser.password" type="password" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                            <div class="flex flex-col rounded-sm ">
                                                <label for="" class="font-semibold text-xs tracking-wider text-blue-400">CONFIRM PASSWORD</label>
                                                <input required v-model="newUser.password_confirmation" type="password" class="border border-gray-200 h-full w-full bg-gray-50 focus:ring-0 focus:border-0">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div>
                                                <button type="submit" class="p-2 text-xs bg-green-700 font-bold tracking-wider rounded text-white">CREATE</button>
                                            </div>
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
