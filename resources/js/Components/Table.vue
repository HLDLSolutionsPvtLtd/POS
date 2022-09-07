<script setup>
import {ref} from 'vue';
import {useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
        headers: Array,
        data: Object,
        id: String,
        actions: {},
    });

let edit = ref(false);
let headerTitles = props.headers.map( header => header.title).filter(header => ![].includes(header));
let headerNames = props.headers.map( header => header.name).filter(header => ![].includes(header));
let headerTypes = props.headers.map( header => header.type).filter(header => ![].includes(header));

let h = {};
headerNames.forEach(element => {
    h[element] = '';
});

let preview = ref('');

let form = useForm(h);

function formatDate(val){
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var d = new Date(val)
    return d.toLocaleDateString("en-US", options); 
};

function indexFind(key)
{
    let index = props.headers.findIndex(el => {
        if(el.name == key)
        {
            return true;
        }
    });

    return index;
};

function editData(items)
{
    headerNames.forEach(el =>
    {   if(props.headers[indexFind(el)].hasOwnProperty('array') && !props.headers[indexFind(el)].exclude)
        {
            form[el] = items[props.headers[indexFind(el)].array][0]['name']
        }
        else if(props.headers[indexFind(el)].hasOwnProperty('obj') && !props.headers[indexFind(el)].exclude)
        {
            form[el] = items[props.headers[indexFind(el)].obj][el];
        }
        else if(el != 'image' && !props.headers[indexFind(el)].exclude)
        {
            form[el] = items[el];
        }
        
    });
};

function submit()
{
    form.post('/admin/'+props.id+'/'+form.id+'/update',{
        onSuccess: () =>{
            closeEdit();
        }
    });
}

function sdelete(haha)
{
    Inertia.post('/admin/'+props.id+'/'+haha+'/delete',{
        store_id: usePage().props.value.auth.store.id
    });
}

function acceptProduct(iid)
{
    Inertia.post('/admin/transfer/'+iid+'/accept')
}

function newfile(e)
{
    let selectedFiles = e.target.files;

    if(!selectedFiles.length) {
        return false;
    }
    
    form.img = selectedFiles[0];
    preview.value = URL.createObjectURL(selectedFiles[0]);
}

function closeEdit()
{
    edit.value = !edit.value;
};

 function fetchData(url)
{
    Inertia.get(url)
}
</script>

<template>
    <div v-if="edit" class="mt-6 bg-gray-50 p-4 rounded">
        <div style="width:100%" class="grid grid-cols-5 gap-2 ">
            <div v-for="(header, index) in headerNames" v-show="header != 'id' && !headers[indexFind(header)].exclude" class="flex flex-col rounded-sm">
                <template v-if="headerTypes[index] == 'option'" >
                    <label for="" class="font-bold text-xs tracking-wider text-gray-400 uppercase">{{headers[index].title}}</label>
                    <select v-model="form[headers[index].name]">
                        <option v-for="option in headers[index].options" :value="option">{{option}}</option>
                    </select>
                </template>

                <template v-else-if="headerTypes[index] == 'image'">
                    <label class="font-bold text-xs tracking-wider text-gray-400 uppercase">{{headers[indexFind(header)].title}}</label>
                    <div v-if="!preview" class="bg-white rounded-xl">
                        <div class="border h-10 border-gray-300 border-dashed rounded-md cursor-pointer">
                            <div class="relative">
                                <input style="height:12" type="file" @change="newfile" class="absolute -z-1 w-full cursor-pointer opacity-0">
                            </div>
                            <div class="flex flex-col items-center w-full justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <button class="rounded-md text-gray-500 p-2 text-sm">Choose File</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <img class="h-10 w-16 border" :src="preview" alt="">
                    </div>
                </template>
                <template v-else>
                    <label for="" class="font-bold text-xs tracking-wider text-gray-400 uppercase">{{headers[indexFind(header)].title}}</label>
                    <input :type="headerTypes[index]" v-model="form[header]" :checked="form[header]" class="border border-gray-200 bg-gray-50 focus:ring-0 focus:border-0">
                </template>
            </div>
        </div>
        <div class="flex justify-start gap-4 mt-6">
            <div class="flex">
                <span class="bg-red-400 p-2 cursor-pointer rounded font-bold text-xs text-white tracking-wider" @click="closeEdit">CLOSE</span>
            </div>
            <div class="flex">
                <button class="bg-green-400 p-2 cursor-pointer rounded font-bold text-xs text-white tracking-wider" @click="submit">UPDATE</button>
            </div>
        </div>
    </div>
    <div style="height:calc(100vh - 300px);scrollbar-width:thin" v-else class="mt-4 p-4 overflow-y-scroll w-full  font-playfair">
        <div class="h-full">
            <table class="w-full">
                <tr class="text-sm font-bold border-b-2 border-gray-300 text-gray-700 pr-2 tracking-wide">
                    <th v-for="header in headers" class="p-2 text-left">
                        <span class="uppercase text-xs">{{header.title}}</span>
                    </th>
                    
                    <th v-if="actions" class="p-2">
                        <span>Actions</span>
                    </th>
                </tr>
                
                <tbody >
                    <tr v-for="rows in data.data" class="">
                        <td v-for="header in headers" class="p-2 text-sm py-2 border-b border-gray-100 text-gray-600 text-left">
                            <span v-if="header.name == 'date' || header.name == 'payment_date' || header.name == 'created_at'">
                                {{formatDate(rows[header.name])}}
                            </span>
                            
                            <img :src="'/storage/'+rows[header.name]" v-else-if="header.type == 'image'" class="h-14 w-14"/>
                            
                            <span v-else-if="header.obj">
                                <span v-if="header.icon == 'price'">&#8377;</span>
                                <span v-if="header.obj2">{{rows[header.obj][header.obj2][header.name]}}</span>
                                <span else>{{rows[header.obj][header.name]}}</span>
                            </span>
                            
                            <span v-else-if="header.array">
                                {{rows[header.array][0][header.name]}}
                            </span>
                            <p class="break-normal" v-else>
                                <span v-if="header.icon == 'price'">&#8377;</span>
                                {{rows[header.name]}}
                            </p>
                        </td>

                        <td v-if="actions">
                            <div class="flex items-center justify-center gap-2 p-2">
                                <div @click="closeEdit(), editData(rows)" class="cursor-pointer" v-if="actions.edit == 'true'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" class="fill-current text-green-500" height="20" viewBox="0 0 24 24">
                                        <path d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                                    </svg>
                                </div>

                                <div @click="sdelete(rows.id)" v-if="actions.delete == 'true'" class="cursor-pointer">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="fill-current text-red-500" viewBox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M19 24h-14c-1.104 0-2-.896-2-2v-16h18v16c0 1.104-.896 2-2 2m3-19h-20v-2h6v-1.5c0-.827.673-1.5 1.5-1.5h5c.825 0 1.5.671 1.5 1.5v1.5h6v2zm-12-2h4v-1h-4v1z"/>
                                    </svg>
                                </div>

                                <div v-if="actions.options">
                                    <div v-if="rows['status'] == 'send'">
                                        <button @click="acceptProduct(rows['id'])" class="text-xs tracking-widest font-bold text-white p-2 bg-green-500 rounded">ACCEPT</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="data.links" class="w-full flex items-center justify-center mt-8">
        <div class="flex justify-center items-center bg-gray-800 rounded-full gap-4 py-2 px-8">
            <div class="flex justify-center items-center text-white" v-for="(link, index) in data.links">
                <button @click="fetchData(link.url)" :disbled="link.active" :class="{'bg-gray-300 text-gray-800': link.active}" v-if="index == 0" class="rounded-full cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="p-1 fill-current " width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13 12l11-7v14l-11-7zm-11 0l11-7v14l-11-7zm-2 6h2v-12h-2v12z"/>
                    </svg>
                </button>
                <button @click="fetchData(link.url)" :disbled="link.active" :class="{'bg-gray-300 text-gray-800 ': link.active}" v-else-if="index == data.links.length - 1" class="rounded-full cursor-pointer">
                    <svg class="p-1 fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M0 19v-14l11 7-11 7zm11 0v-14l11 7-11 7zm13-13h-2v12h2v-12z"/>
                    </svg>
                </button>
                <button @click="fetchData(link.url)" :disbled="link.active" :class="{'bg-gray-300 text-gray-800': link.active}" v-else class="px-2 font-bold rounded-full cursor-pointer">
                    <span>{{link.label}}</span>
                </button>
            </div>
        </div>
    </div>
</template>