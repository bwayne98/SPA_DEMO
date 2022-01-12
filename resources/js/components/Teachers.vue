<template>
    <div class="text-center m-8">
        <h1 class="text-5xl pb-4">Teachers</h1>
        <div>
            <input type="text" v-model="text">
            <button @click="teacherSearch()" class="text-sm bg-gray-600 bg-opacity-60 mt-2 px-2 py-1 rounded-full text-white active:bg-gray-300 shadow" > Search</button>
        </div>
        <div id="teachersTable" class="flex justify-center m-5">
            <div class="flex justify-center shadow p-4 rounded-xl">
                <table class="divide-y divide-gray-300">
                    <thead class="">
                        <tr>
                            <th class=""> # </th>
                            <th class=""> Name </th>
                            <th class=""> Birth </th>
                            <th class=""> Managemnet </th>
                        </tr>
                    </thead>
                    <tbody class="rounded-md">
                        <tr v-for="t in teachers" :key="t.id" class="hover:bg-gray-100 ">
                            <td class="py-2 px-4"> {{t.id}} </td>
                            <td class="py-2 px-4"> {{t.chName}} {{t.enName}} </td>
                            <td class="py-2 px-4"> {{t.birth}} </td>
                            <td class="py-2 px-4">
                                <button @click="listRemov(t.id)" class="m-1 px-2 bg-white rounded-full shadow">Detail</button>
                            </td>                   
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            teachers:{},
            teacherId: 4,
            text: "",

        }
    },

    methods: {

        teacherSearch(){
            if(this.text === ""){
                alert("無法查詢");
            }
            console.log(this.text);
        },
        listRemov(id){ 
            
            let n = this.teachers.filter(function(e){
                return e.id != id;
            });
            //console.log(n)
            this.teachers = n;
        }
    },

    mounted(){
        axios.get('/api/teachers').then(response => {
            //console.log(response.data);
            this.teachers = response.data;
        })
    },

        
}
</script>