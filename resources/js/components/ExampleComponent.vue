<template>
<div class="grid lg:grid-cols-5 grid-cols-3 mt-20">
    <div class="col-span-3 lg:col-start-2 text-xl h-48 items-center flex w-full justify-center" v-if="loading"> <i class='bx bx-loader-circle bx-spin'></i> Loading... </div>
    <div class="col-span-3 lg:col-start-2 " v-else>

        <!-- 開班區塊 -->
        <h1 class="text-center text-3xl font-extrabold mb-2">開班訊息</h1>
        <div class="h-48 relative overflow-hidden">
            <div id="slider-buton" class="w-full absolute z-10 flex justify-center items-center" style="bottom: -10px">
                <button class="text-3xl opacity-60 text-cyan-700" @click="slide_right()"><i class='bx bx-chevron-left bx-fade-left-hover'></i></button>
                <button v-for="num in (slidernumber + 1)" :key="'slidebutton' + num" class="text-xs opacity-60 text-cyan-700" :disabled="curslider == num" style="padding: 1px" @click="sliderbutton(num)"><i class='bx' :class="{ 'bxs-circle' : num == curslider , 'bx-circle' : num != curslider}"></i></button>
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
                            <div id="lessson-sign" class="absolute w-full h-full bg-gray-400 bg-opacity-50 text-center pt-4 text-2xl">
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

        <div class="h-12"></div>

        <div class="grid md:grid-cols-5 grid-cols-3">
            <!-- 新聞區塊 -->
            <div class="grid grid-cols-3 col-span-3 divide-y divide-cyan-600/20">
                <h1 class="col-span-3 text-center text-3xl font-extrabold mb-2 ">新聞</h1>
                <div class="col-span-3 grid grid-cols-3 py-1 self-center">
                    <div class="text-center text-lg font-semibold text text-cyan-800">日期</div>
                    <div class="text-center col-span-2 text-lg font-semibold text-cyan-800">標題</div>
                </div>
                <div class="col-span-3 grid grid-cols-3 py-1 gap-x-2 self-center" v-for="(news,index) in newsList" :key="'news' + index">
                    <div class="text-center">{{ news[0] }}</div>
                    <div class="col-span-2 truncate">
                        <a :href="news[1]" target="_blank" class="hover:text-cyan-700 ">{{ news[2] }}</a>
                    </div>
                </div>
                <div class="flex justify-center col-span-3 p-2 mb-5">
                    <button class="mx-1 px-1 border-2 rounded-md text-gray-400 disabled:bg-gray-600 disabled:text-white" v-for="num in 5" :key="'button' + num" :disabled="num == curPage" @click="changPage(num)"> 0{{num}}</button>
                </div>
            </div>
            <!-- 地圖區塊 -->
            <div class="md:col-span-2 col-span-3 mb-8">
                <h1 class="col-span-3 text-center text-3xl font-extrabold mb-2">聯絡我們</h1>
                <div class="col-span-3 px-4">
                    <googlemap class=""> </googlemap>
                </div>
            </div>
        </div>

    </div>
</div>

</template>

<script>
import googlemap from './/googlemap.vue';
export default {
    components:{
        'googlemap':googlemap
    },
    data() {
        return {
            sliderposition: 0,
            maxposition: 0,
            slidervalue: 1,
            slidernumber: 0,
            curslider: 1,

            lessons: null,
            teachers: null,
            studentcount: null,

            loading: true,

            newsAll: null,
            newsList: null,
            curPage: 1
        }
    },
    computed: {
        // 轉格式成字串
        sliderpositionpercent: function () {
            return (this.sliderposition * 100).toString() + "%"
        },
    },
    async beforeCreate() {
        this.loading = true;

        await axios.get('/api/lesson/current').then((res) => {
            this.lessons = res.data[0];
            this.teachers = res.data[1];
            this.studentcount = res.data[2]
        })

        console.log(window.innerWidth);
        //初始使窗大小
        if (window.innerWidth > 1600) {
            this.slidernumber = this.lessons.length % 3 ? Math.floor(this.lessons.length / 3) : Math.floor(this.lessons.length / 3)-1
            this.maxposition = (this.lessons.length - 3) * 1 / 3
        } else if (window.innerWidth > 650) {
            this.slidernumber = this.lessons.length % 2 ? Math.floor(this.lessons.length / 2) : Math.floor(this.lessons.length / 2)-1
            this.maxposition = (this.lessons.length - 2) * 1 / 2
        } else {
            this.slidernumber = this.lessons.length - 1
            this.maxposition = this.lessons.length - 1
        }
        //視窗大小偵測
        window.addEventListener('resize', () => {
            this.sliderposition = 0;
            if (window.innerWidth > 1600) {
                this.slidernumber = this.lessons.length % 3 ? Math.floor(this.lessons.length / 3) : Math.floor(this.lessons.length / 3)-1
                this.maxposition = (this.lessons.length - 3) * 1 / 3
                this.curslider = 1
            } else if (window.innerWidth > 650) {
                this.slidernumber = this.lessons.length % 2 ? Math.floor(this.lessons.length / 2) : Math.floor(this.lessons.length / 2)-1
                this.maxposition = (this.lessons.length - 2) * 1 / 2
                this.curslider = 1
            } else {
                this.slidernumber = this.lessons.length - 1
                this.maxposition = this.lessons.length - 1
                this.curslider = 1
            }
        });

        //python news
        await axios.get('/api/news').then(res => {
            // console.log(res.data)
            this.newsAll = res.data
            this.newsList = res.data.slice(0, 8)
        }).catch(err => {
            console.err(err.response.data.errors)
        })
        this.loading = false
    },
    methods: {
        slide_left() {
            this.sliderposition -= this.slidervalue;
            this.curslider += 1

            if (this.sliderposition == -this.maxposition - this.slidervalue) {
                this.sliderposition = 0;
                this.curslider = 1
                return
            } else if (this.sliderposition < this.slidernumber * (-this.slidervalue) + 0.1) {
                this.sliderposition = -this.maxposition;
                this.curslider = this.slidernumber + 1
                return;
            }
        },
        slide_right() {
            this.sliderposition += this.slidervalue;
            this.curslider -= 1

            if (this.sliderposition == 0 + this.slidervalue) {
                this.sliderposition = -this.maxposition;
                this.curslider = this.slidernumber + 1
                return
            } else if (this.sliderposition >= -0.1) {
                this.sliderposition = 0;
                this.curslider = 1
                return;
            }
        },
        sliderbutton(num) {
            if (num == 1) {
                this.sliderposition = 0
                this.curslider = 1
            } else if (num == this.slidernumber + 1) {
                this.sliderposition = -this.maxposition;
                this.curslider = this.slidernumber + 1
            } else {
                this.sliderposition = 0
                for (let i = 1; i < num; i += 1) {
                    this.slide_left()
                }
                this.curslider = num
            }

        },
        changPage(num) {
            this.curPage = num
            num = num - 1
            this.newsList = this.newsAll.slice(num * 8, num * 8 + 8)
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
    top: -100%;
    transition: 0.5s;
}

#slider-content div:hover #lessson-sign {
    top: 2rem
}
</style>
