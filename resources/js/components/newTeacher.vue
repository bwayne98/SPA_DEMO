<template>
<div>
    <H2 class="text-3xl text-center pt-8">New Teacher Info.</H2>
    <div class="flex justify-center">
        <form id="newTeacherForm" action="#" method="GET" class="mx-w-3/5 m-8 p-4 shadow rounded-md bg-gray-100 bg-opacity-30" v-on:submit.prevent>
            <div class="flex justify-center flex-wrap">
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="chName">Chinese Name</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="chName" v-model="formData.chName" required>
                    <div class="m-1">
                        <label for="enName">English Name</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="enName" v-model="formData.enName">
                </div>
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="birth">Birth</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="date" id="birth" v-model="formData.birth">
                    <div class="m-1">
                        <label for="idNumber">Identity Number</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="idNumber" v-model="formData.idNumber">
                </div>
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="phone">Phone</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="phone" v-model="formData.phone">
                    <div class="m-1">
                        <label for="address">Address</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="address" v-model="formData.address">
                </div>
                <div class="w-full h-2"></div>
                <imgedit ref="canvas"></imgedit>

                <!-- <div v-show="img_src !== ''" class="mt-4">
                    <div class="flex justify-center">
                        <input id="img-input" type="file" accept="image/png, image/jpeg" style="display:none">
                        <img id="source" :src="img_src" alt="請選擇檔案" style="display:none">

                        <div v-show="img_onload" class="grid grid-clos-2 gap-6">
                            <div class="flex justify-center relative">
                                <canvas id="canvas" class="bg-black rounded-md border-2 border-cyan-800/60" :width="canvas_size" :height="canvas_size" style="width:250px; height:250px" @click="canvasScale(1)"></canvas>
                                <div class="absolute">
                                    <button type="button">-</button><input type="range" min="1" max="10" value="1" class="pointer-events-none"><button type="button">-</button>
                                </div>
                                <canvas id="hidden-canvas" style="display:none"></canvas>
                            </div>
                            <div class="sm:col-start-2 flex items-center justify-center col-start-1 sm:flex-col flex-col-reverse">
                                <img id="pre" :src="preimg_src" alt="請選擇檔案" v-show="preimg_src !== ''" class="rounded-full border-2 border-cyan-800/60" width="150" height="150">
                                <div class="text-center my-2 font-light">
                                    預覽圖片
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="grid sm:grid-cols-3 mx-6 my-4 gap-4 grid-rows-3 sm:grid-rows-1">
                <button @click="canvasLoad()" type="button" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white"><span v-if="img_onload">更換圖片</span> <span v-else>載入圖片</span> </button>
                <button @click="sendFormData()" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white">Save</button>
                <button @click="resetConfirm()" type="button" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white">Reset</button>
            </div>
        </form>

    </div>
</div>
</template>

<script>
import imgedit from './imgEdit.vue';

export default {
    components: {
        'imgedit': imgedit
    },
    data() {
        return {
            formData: {
                chName: "",
                enName: "",
                birth: "",
                idNumber: "",
                phone: "",
                address: "",
            },
            canvas_size: 1000,
            img_onload: false,
            img_src: '',
            preimg_src: '',
            cutRadio: 200,
            scale: 1,
        }
    },

    methods: {
        sendFormData() {
            console.log(this.formData)
        },

        resetConfirm() {
            if (confirm("Clean Data ?") === true) {
                this.formData.chName = "";
                this.formData.enName = "";
                this.formData.birth = "";
                this.formData.idNumber = "";
                this.formData.phone = "";
                this.formData.address = "";
                console.log("Yes");
                return;
            }

            console.log("No");
            return;
        },
        canvasLoad() {
            this.$refs.canvas.loadImg();
        }

        //     loadImg() {
        //         this.img_onload = false;
        //         document.getElementById('img-input').click();
        //     },
        //     draw() {
        //         let canvas = document.getElementById('canvas');
        //         let img = document.getElementById('source');

        //         let ctx = canvas.getContext('2d');

        //         ctx.mozImageSmoothingEnabled = true;
        //         ctx.clearRect(0, 0, this.canvas_size, this.canvas_size);

        //         let w = img.naturalWidth;
        //         let h = img.naturalHeight;

        //         if (w < h) {
        //             // w = this.canvas_size;
        //             // h = h * (w / img.naturalWidth);
        //             this.scale = (this.canvas_size / w);
        //         } else {
        //             // h = this.canvas_size;
        //             // w = w * (h / img.naturalHeight);
        //             this.scale = (this.canvas_size / h);
        //         }

        //         ctx.save();
        //         ctx.scale(this.scale, this.scale);
        //         ctx.drawImage(img, 0, 0, w, h);
        //         ctx.restore();
        //     },
        //     darwblur() {
        //         let canvas = document.getElementById('canvas');
        //         let ctx = canvas.getContext('2d');

        //         let radio = this.cutRadio;
        //         //上半部
        //         ctx.fillStyle = 'rgba(255,255,255,0.8)';
        //         ctx.beginPath();
        //         ctx.moveTo(0, 0);
        //         ctx.lineTo(0, (canvas.height / 2));
        //         ctx.lineTo((canvas.width / 2 - radio), canvas.height / 2);
        //         //arc(x, y, radius, startAngle, endAngle, anticlockwise)

        //         ctx.arc(canvas.width / 2, canvas.height / 2, radio, Math.PI, 0)

        //         ctx.lineTo((canvas.width / 2 + radio), canvas.height / 2);
        //         ctx.lineTo(canvas.width, canvas.height / 2);
        //         ctx.lineTo(canvas.width, 0);
        //         ctx.closePath();
        //         ctx.fill();
        //         //下半部
        //         ctx.beginPath();
        //         ctx.moveTo(0, canvas.height);
        //         ctx.lineTo(0, (canvas.height / 2));
        //         ctx.lineTo((canvas.width / 2 - radio), canvas.height / 2);
        //         //arc(x, y, radius, startAngle, endAngle, anticlockwise)

        //         ctx.arc(canvas.width / 2, canvas.height / 2, radio, Math.PI, 0, true)

        //         ctx.lineTo((canvas.width / 2 + radio), canvas.height / 2);
        //         ctx.lineTo(canvas.width, canvas.height / 2);
        //         ctx.lineTo(canvas.width, canvas.height);
        //         ctx.closePath();
        //         ctx.fill();

        //         //圓框
        //         ctx.strokeStyle = '#2E86AB';
        //         ctx.beginPath();
        //         ctx.lineWidth = 4;
        //         ctx.arc(canvas.width / 2, canvas.height / 2, radio + ctx.lineWidth / 2, 0, Math.PI * 2, true);
        //         ctx.stroke();
        //     },
        //     canvasScale(num) {

        //         let canvas = document.getElementById('canvas');
        //         let ctx = canvas.getContext('2d');

        //         let img = document.getElementById('source');

        //         if (num === 1) {
        //             this.scale *= 1.1;
        //         }

        //         if (num === -1) {
        //             this.scale *= 0.9
        //         }

        //         ctx.save();
        //         ctx.clearRect(0, 0, this.canvas_size, this.canvas_size);
        //         ctx.scale(this.scale, this.scale);
        //         ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);
        //         ctx.restore();
        //         console.log(this.scale)
        //         this.darwblur();
        //         this.drawpre();

        //     },
        //     drawpre() {
        //         let pre_canvas = document.getElementById('hidden-canvas');
        //         pre_canvas.width = this.cutRadio * 2;
        //         pre_canvas.height = this.cutRadio * 2;
        //         let pre_ctx = pre_canvas.getContext('2d')
        //         let img = new Image();
        //         img.onload = () => {

        //             pre_ctx.beginPath();
        //             //arc(x, y, radius, startAngle, endAngle, anticlockwise)
        //             pre_ctx.arc(this.cutRadio, this.cutRadio, this.cutRadio, 0, Math.PI * 2);
        //             //限制繪畫部分
        //             pre_ctx.clip();
        //             //drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
        //             pre_ctx.drawImage(img, this.canvas_size / 2 - this.cutRadio, this.canvas_size / 2 - this.cutRadio, this.cutRadio * 2, this.cutRadio * 2, 0, 0, this.cutRadio * 2, this.cutRadio * 2)
        //             this.preimg_src = pre_canvas.toDataURL();
        //         }
        //         img.src = document.getElementById('canvas').toDataURL();
        //     }

    },
    // mounted() {

    //     let img = document.getElementById('source');
    //     img.onload = () => {
    //         console.log(img.naturalWidth);
    //         this.draw();
    //         this.darwblur();
    //         this.drawpre();
    //     }

    //     let img_input = document.getElementById('img-input');
    //     img_input.addEventListener('change', (e) => {
    //         this.img_src = '';
    //         if (img_input.files && img_input.files[0]) {
    //             let reader = new FileReader();
    //             reader.onload = (e) => {
    //                 console.log(e);
    //                 this.img_src = e.target.result;
    //                 this.img_onload = true;
    //             }
    //             reader.readAsDataURL(img_input.files[0]);
    //         }
    //     })
    // }

}
</script>

<style lang="scss" scoped>
#newTeacherForm {
    div {
        button {
            box-shadow: 1px 2px black, 3px 5px black;
            border-style: solid;
            border-width: 0 1px 1px 0;
            border-color: transparent;
        }

        button:hover {
            border-color: white;
        }

        button:active {
            color: black;
        }

        div.up-section {
            width: 30%;

            input,
            div {
                width: 100%;
            }
        }

        // div:nth-child(4) {
        //     width: 30%;
        //     input{
        //         width: 100px;
        //     }
        // }
    }
}

@media (max-width:1024px) {
    #newTeacherForm {
        div {

            div.up-section {
                width: 90%
            }
        }
    }
}

@media (max-width:500px) {
    #newTeacherForm {
        div:nth-child(2) {
            button {}
        }
    }
}
</style>
