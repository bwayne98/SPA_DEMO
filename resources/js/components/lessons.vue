<template>
<div class="flex justify-center items-center mt-20">
    <div class="lg:w-3/5 w-full px-4 relative">
        
        <div class="justify-center text-xl pb-4 leading-6 text-cyan-700 text-opacity-80 flex">
            <button class="px-1" @click="leftButton()"><i class='bx bxs-chevron-left'></i></button>
            <div class="pointer-events-none w-32 text-center font-semibold"> {{selector[curSelector]}} </div>
            <button class="px-1" @click="rightButton()"><i class='bx bxs-chevron-right'></i></button>
        </div>
        <div v-if="loading">Loading</div>
        <div v-else id="scoll" class="grid md:grid-cols-3 grid-cols-2 gap-2 h-60 overflow-auto p-2 border-2 shadow border-t-white/60  border-l-white/60 border-r-white/20 border-b-white/20 rounded-lg">
            <div class="grid grid-cols-3 shadow-md" v-for="lesson in lessonList" :key="'lesson' + lesson.id">
                <div class="whitespace-nowrap justify-between flex pl-1">
                    <span>課程</span>
                    <span>|</span>
                </div>
                <div class="col-span-2 px-1">{{ lesson.name }}</div>
                <div class="whitespace-nowrap justify-between flex pl-1">
                    <span>開始</span>
                    <span>|</span>
                </div>
                <div class="col-span-2 px-1">{{ lesson.start }}</div>
                <div class="whitespace-nowrap justify-between flex pl-1">
                    <span>結束</span>
                    <span>|</span>
                </div>
                <div class="col-span-2 px-1">{{ lesson.end }}</div>
                <div class="whitespace-nowrap justify-between flex pl-1">
                    <span>老師</span>
                    <span>|</span>
                </div>
                <div class="col-span-2 px-1">{{ lesson.teacher }}</div>
                <div class="whitespace-nowrap justify-between flex pl-1">
                    <span>教室</span>
                    <span>|</span>
                </div>
                <div class="col-span-2 px-1">{{ lesson.room }}</div>
            </div>
        </div>
<!--  -->
        <div class="text-center text-xl font-semibold mt-12 mb-2">教室狀況</div>
        <div v-if="!loading" class="border-2 rounded-md">

            <div class="grid grid-cols-10 text-center divide-x-2">
                <div></div>
                <div v-if="curSelector == 3 || curSelector == 0" class="col-span-9">Mon / Thu</div>
                <div v-if="curSelector == 1" class="col-span-9">Tue / Fri</div>
                <div v-if="curSelector == 2" class="col-span-9">Wed / Sat</div>
            </div>
            <div class="grid grid-cols-10 text-center border-t-2 border-b-2 divide-x-2 ">
                <div>
                    #
                </div>
                <div class="grid grid-cols-2 divide-x-2 col-span-9">
                    <div>18:00</div>
                    <div>20:00</div>
                </div>
            </div>
            <div v-for="room in rooms" :key="'room' + room" class="grid grid-cols-10 text-center  items-center hover:bg-cyan-700/20 rounded-md">
                <div class="col-start-1">{{room}}</div>
                <div class="col-span-9 grid grid-cols-2 items-center">
                    <div v-if="curSelector == 3 || curSelector == 0" class="">   
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Mon-Thur-18' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>
                    <div v-if="curSelector == 3 || curSelector == 0" class="">    
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Mon-Thur-20' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>
                    <div v-if="curSelector == 1" class="">    
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Tue-Fri-18' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>
                    <div v-if="curSelector == 1" class="">   
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Tue-Fri-20' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>
                    <div v-if="curSelector == 2" class="">  
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Wed-Sat-18' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>
                    <div v-if="curSelector == 2" class="">  
                        <div v-for="lesson in lessons.filter((item)=>{
                            return room == item.room & 'Wed-Sat-20' == item.period
                            })" :key="'lesson' + lesson.id">
                            <div>{{ lesson.name }} - {{ lesson.teacher }}</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="p-12">

        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            selector: ['Mon / Thu', 'Tue / Fri', 'Wed / Sat', 'All'],
            rooms: ["2A","2S","2B", "3A", "3S", "3B", "4A", "4S", "4B"],
            curSelector: 3,
            lessons: null,
            lessonList: null,
            loading: true
        }
    },
    async beforeCreate() {
        this.loading = true
        await axios.get('/api/lesson').then(res => {
            this.lessons = res.data
            this.lessonList = this.lessons
        })
        this.loading = false
    },
    methods: {
        leftButton() {
            if (this.curSelector == 0) {
                this.curSelector = 3
            } else {
                this.curSelector -= 1
            }
            this.setList(this.curSelector)
        },
        rightButton() {
            if (this.curSelector == 3) {
                this.curSelector = 0
            } else {
                this.curSelector += 1
            }
            this.setList(this.curSelector)
        },
        setList(num) {
            switch (num) {
                case 0:
                    this.lessonList = this.lessons.filter((item) => {
                        return item.period == 'Mon-Thur-18' | item.period == 'Mon-Thur-20'
                    })
                    return
                case 1:
                    this.lessonList = this.lessons.filter((item) => {
                        return item.period == 'Tue-Fri-18' | item.period == 'Tue-Fri-20'
                    })
                    return
                case 2:
                    this.lessonList = this.lessons.filter((item) => {
                        return item.period == 'Wed-Sat-18' | item.period == 'Wed-Sat-20'
                    })
                    return
                case 3:
                    this.lessonList = this.lessons
            }
        }
    }
}
</script>

<style scoped>
#scoll::-webkit-scrollbar {
    display: none;
}
</style>
