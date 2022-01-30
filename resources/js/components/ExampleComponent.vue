<template>
<div class="grid lg:grid-cols-5 grid-cols-3 mt-20">
    <div class="col-span-3 lg:col-start-2 text-xl h-48 items-center flex w-full justify-center" v-if="loading"> <i class='bx bx-loader-circle bx-spin'></i> Loading... </div>
    <div class="col-span-3 lg:col-start-2 " v-else>
        <h1 class="text-center text-3xl font-extrabold mb-2">開班訊息</h1>
        <div class="h-48 relative overflow-hidden">
            <div id="slider-buton" class="w-full absolute z-10 flex justify-center" style="bottom: -10px">
                <button class="text-3xl opacity-60 text-cyan-700" @click="slide_right()"><i class='bx bx-chevron-left bx-fade-left-hover'></i></button>
                <button class="text-3xl opacity-60 text-cyan-700" @click="slide_left()"><i class='bx bx-chevron-right bx-fade-right-hover'></i></button>
            </div>
            <div id="slider-content" class=" h-full w-full absolute whitespace-nowrap" style="letter-spacing: -0.3em" :style="{ left : sliderpositionpercent }">
                <div class=" h-full w-1/3 inline-block" v-for="(lesson, index) in lessons" :key="'lesson' + lesson.id">
                    <div class=" h-full w-full grid grid-cols-5 grid-rows-6 text-black relative" style="letter-spacing:0em">
                        <div class="px-2 py-1 text-center absolute right-4 bottom-10 border-2 rounded-full border-black flex">
                            <span v-if="studentcount[index] < 10">0</span>
                            <span>{{studentcount[index]}}</span>
                        </div>
                        <div class="col-span-5 text-center">--{{lesson.name}}--</div>
                        <div id="lessson-content" class="row-start-2 col-span-5 row-span-4 bg-cyan-600 bg-opacity-10 text-cyan-800 mx-2 rounded shadow-md relative overflow-hidden">
                            <div id="lessson-sign" class="absolute w-full h-full bg-gray-400 bg-opacity-50 text-center pt-4 text-2xl" >
                                <button class="bg-white bg-opacity-60 text-gray-600 px-16 active:bg-opacity-80">點擊報名</button> 
                            </div>
                            <div class="text-center pt-1  font-semibold text-xl">課程資訊</div>
                            <hr>
                            <div class="px-2 py-1">
                                <span>開課時間：</span>
                                <span>{{lesson.start}} ~ {{lesson.end}}</span>
                            </div>
                            <div class="px-2 pb-1">
                                <span>時　　段：</span>
                                <span>{{lesson.period}}</span>
                            </div>
                            <div class="px-2">
                                <span>老　　師：</span>
                                <span>{{teachers[index].enName}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            sliderposition: 0,
            slidervalue: 0,
            lessons: null,
            teachers: null,
            studentcount: null,
            loading: true
        }
    },
    computed: {
        // 轉格式成字串
        sliderpositionpercent: function () {
            return (this.sliderposition * 100).toString() + "%"
        },
        slidernumber() {
            if (this.slidervalue == 1) {
                return this.lessons.length - 1
            } else if (this.slidervalue == 1 / 2) {
                return this.lessons.length - 2
            } else {
                return this.lessons.length - 3
            }
        },
    },
    async beforeCreate() {
        this.loading = true;

        await axios.get('/api/lesson/current').then((res) => {
            this.lessons = res.data[0];
            this.teachers = res.data[1];
            this.studentcount = res.data[2]
        })

        this.loading = false;
    },
    mounted() {
        console.log(window.innerWidth);
        //初始使窗大小
        if (window.innerWidth > 1600) {
            this.slidervalue = 1 / 3
        } else if (window.innerWidth > 650) {
            this.slidervalue = 1 / 2
        } else {
            this.slidervalue = 1
        }
        //視窗大小偵測
        window.addEventListener('resize', () => {
            this.sliderposition = 0;
            if (window.innerWidth > 1600) {
                this.slidervalue = 1 / 3
            } else if (window.innerWidth > 650) {
                this.slidervalue = 1 / 2
            } else {
                this.slidervalue = 1
            }
        });
    },
    methods: {
        slide_left() {
            if (this.sliderposition <= this.slidernumber * (-this.slidervalue) + 0.1) {
                this.sliderposition = 0;
                return;
            }
            this.sliderposition -= this.slidervalue;
        },
        slide_right() {
            if (this.sliderposition >= -0.1) {
                this.sliderposition = this.slidernumber * (-this.slidervalue);
                return;
            }
            this.sliderposition += this.slidervalue;
        }
    }
};
</script>

<style scoped>
#slider-content {
    transition: all 0.5s ease;
}

@media (max-width:1600px) {
    #slider-content {
        width: 150%;
    }
}

@media (max-width: 650px) {
    #slider-content {
        width: 300%;
    }
}

#lessson-sign {
    top:-100%;
    transition: 0.5s;
}


#slider-content div:hover #lessson-sign {
    top:2rem
}

</style>
