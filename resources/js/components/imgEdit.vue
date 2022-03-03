<template>
<div v-show="img_src !== ''" class="mt-4">
    <div class="flex justify-center">

        <div v-show="img_onload" class="grid grid-clos-2 gap-x-20 gap-y-2">
            <div class="relative">
                <input id="img-input" type="file" accept="image/png, image/jpeg" style="display:none">
                <div id="source-shape" draggable="false" class="overflow-hidden relative bg-black/60 rounded-md " style="width:250px; height:250px">
                    <div id="source-control" class="absolute top-0">
                        <img draggable="false" class="cursor-grab" id="source" :src="img_src" alt="請選擇檔案" style="top: 0px">
                    </div>
                </div>
                <img src="/images/blur.png" alt="blur" class="absolute top-0 pointer-events-none rounded-md border-2 border-white" width="250" height="250">
                <div class="absolute bottom-2 w-full flex justify-center items-center">
                    <button type="button" class='text-white/50 bx bx-minus-circle disabled:opacity-50' @click="canvasScale(-1)" :disabled="scale_set == 1"></button>
                    <input type="range" min="1" max="10" v-model="scale_set" class="mx-1 pointer-events-none">
                    <button type="button" class='text-white/50 bx bx-plus-circle disabled:opacity-50' @click="canvasScale(1)" :disabled="scale_set == 10"></button>
                </div>
            </div>
            <div class="flex justify-center relative">
                <canvas id="canvas" class="" :width="canvas_size" :height="canvas_size" style="width:250px; height:250px"></canvas>
            </div>
            <div class="sm:col-start-2 flex items-center justify-center col-start-1 sm:flex-col flex-col-reverse">
                <div class="text-center my-1 font-light">
                    預覽圖片
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
            canvas_size: 500,
            img_onload: false,
            img_src: '',
            preimg_src: '',
            cutRadio: 150,
            scale: 1,
            transformX: 0,
            transformY: 0,
            scale_set: 1,
        }
    },
    methods: {
        loadImg() {
            this.img_onload = false;
            document.getElementById('img-input').click();
        },
        draw(x, y, scale, rotate) {
            let canvas = document.getElementById('canvas');
            let img = document.getElementById('source');

            let ctx = canvas.getContext('2d');

            ctx.mozImageSmoothingEnabled = true;
            ctx.clearRect(0, 0, this.canvas_size, this.canvas_size);

            let w = img.naturalWidth;
            let h = img.naturalHeight;

            ctx.beginPath();
            ctx.arc((this.canvas_size / 2), (this.canvas_size / 2), this.cutRadio + 5, 0, Math.PI * 2);
            ctx.clip();

            ctx.save();
            ctx.scale(scale, scale);
            ctx.drawImage(img, x, y, w, h);
            ctx.restore();

            // this.drawblur();

            ctx.beginPath();
            ctx.lineWidth = 5;
            ctx.strokeStyle = '#2E86AB';
            ctx.arc(this.canvas_size / 2, this.canvas_size / 2, (this.cutRadio + 3), 0, Math.PI * 2);
            ctx.stroke();

        },
        drawblur() {
            let canvas = document.getElementById('canvas');
            let ctx = canvas.getContext('2d');

            let radio = this.cutRadio;
            //上半部
            ctx.fillStyle = 'rgba(0,0,0,0.4)';
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.lineTo(0, (canvas.height / 2));
            ctx.lineTo((canvas.width / 2 - radio), canvas.height / 2);
            //arc(x, y, radius, startAngle, endAngle, anticlockwise)

            ctx.arc(canvas.width / 2, canvas.height / 2, radio, Math.PI, 0)

            ctx.lineTo((canvas.width / 2 + radio), canvas.height / 2);
            ctx.lineTo(canvas.width, canvas.height / 2);
            ctx.lineTo(canvas.width, 0);
            ctx.closePath();
            ctx.fill();
            //下半部
            ctx.beginPath();
            ctx.moveTo(0, canvas.height);
            ctx.lineTo(0, (canvas.height / 2));
            ctx.lineTo((canvas.width / 2 - radio), canvas.height / 2);
            //arc(x, y, radius, startAngle, endAngle, anticlockwise)

            ctx.arc(canvas.width / 2, canvas.height / 2, radio, Math.PI, 0, true)

            ctx.lineTo((canvas.width / 2 + radio), canvas.height / 2);
            ctx.lineTo(canvas.width, canvas.height / 2);
            ctx.lineTo(canvas.width, canvas.height);
            ctx.closePath();
            ctx.fill();

            //圓框
            ctx.strokeStyle = '#2E86AB';
            ctx.beginPath();
            ctx.lineWidth = 4;
            ctx.arc(canvas.width / 2, canvas.height / 2, radio + ctx.lineWidth / 2, 0, Math.PI * 2, true);
            ctx.stroke();
        },
        canvasScale(num) {
            let canvas = document.getElementById('canvas');
            let ctx = canvas.getContext('2d');

            let img = document.getElementById('source');

            let control = document.getElementById('source-control');

            if (num === 1) {
                this.scale *= 1.2;
                this.scale_set = parseInt(this.scale_set) + 1
            }

            if (num === -1) {
                this.scale /= 1.2;
                this.scale_set = parseInt(this.scale_set) - 1
            }

            if (this.transformY > ((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) {
                this.transformY = ((this.canvas_size - this.cutRadio * 2) / 2) / this.scale;
            } else if (this.transformY < ((((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) + (this.cutRadio * 2 / this.scale) - control.offsetHeight)) {
                this.transformY = ((((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) + (this.cutRadio * 2 / this.scale) - control.offsetHeight)
            }
            if (this.transformX > ((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) {
                this.transformX = ((this.canvas_size - this.cutRadio * 2) / 2) / this.scale;
            } else if (this.transformX < ((((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) + (this.cutRadio * 2 / this.scale) - control.offsetWidth)) {
                this.transformX = ((((this.canvas_size - this.cutRadio * 2) / 2) / this.scale) + (this.cutRadio * 2 / this.scale) - control.offsetWidth)
            }

            control.style.transform = "scale(" + this.scale / (this.canvas_size / 250) + ")translate(" + this.transformX + 'px,' + this.transformY + 'px)';
            this.draw(this.transformX, this.transformY, this.scale, 0);
        },
        // drawpre() {
        //     let pre_canvas = document.getElementById('hidden-canvas');
        //     pre_canvas.width = this.cutRadio * 2;
        //     pre_canvas.height = this.cutRadio * 2;
        //     let pre_ctx = pre_canvas.getContext('2d')
        //     let img = new Image();
        //     img.onload = () => {

        //         pre_ctx.beginPath();
        //         //arc(x, y, radius, startAngle, endAngle, anticlockwise)
        //         pre_ctx.arc(this.cutRadio, this.cutRadio, this.cutRadio, 0, Math.PI * 2);
        //         //限制繪畫部分
        //         pre_ctx.clip();
        //         //drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
        //         pre_ctx.drawImage(img, this.canvas_size / 2 - this.cutRadio, this.canvas_size / 2 - this.cutRadio, this.cutRadio * 2, this.cutRadio * 2, 0, 0, this.cutRadio * 2, this.cutRadio * 2)
        //         this.preimg_src = pre_canvas.toDataURL();
        //     }
        //     img.src = document.getElementById('canvas').toDataURL();
        // }

    },
    mounted() {

        let img = document.getElementById('source');
        let control = document.getElementById('source-control');

        let originX = 0;
        let originY = 0;
        let vm = this;

        control.addEventListener('mouseup', () => {
            window.removeEventListener('mousemove', mouseMove);
            document.body.style.userSelect = '';
            // this.draw(this.transformX, this.transformY, this.scale, 0);
        });

        control.addEventListener('mouseleave', () => {
            window.removeEventListener('mousemove', mouseMove);
            document.body.style.userSelect = '';
            // this.draw(this.transformX, this.transformY, this.scale, 0);
        });

        control.addEventListener('mousedown', function (e) {
            originX = e.pageX;
            originY = e.pageY;
            window.addEventListener('mousemove', mouseMove);
            document.body.style.userSelect = 'none';
        })

        function mouseMove(e) {
            e.preventDefault();
            vm.transformY = vm.transformY + (e.pageY - originY) * 2 / vm.scale;
            vm.transformX = vm.transformX + (e.pageX - originX) * 2 / vm.scale;

            if (vm.transformY > ((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) {
                vm.transformY = ((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale;
            } else if (vm.transformY < ((((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) + (vm.cutRadio * 2 / vm.scale) - control.offsetHeight)) {
                vm.transformY = ((((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) + (vm.cutRadio * 2 / vm.scale) - control.offsetHeight)
            }
            if (vm.transformX > ((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) {
                vm.transformX = ((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale;
            } else if (vm.transformX < ((((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) + (vm.cutRadio * 2 / vm.scale) - control.offsetWidth)) {
                vm.transformX = ((((vm.canvas_size - vm.cutRadio * 2) / 2) / vm.scale) + (vm.cutRadio * 2 / vm.scale) - control.offsetWidth)
            }

            control.style.transform = "scale(" + vm.scale / (vm.canvas_size / 250) + ")translate(" + vm.transformX + 'px,' + vm.transformY + 'px)';
            vm.draw(vm.transformX, vm.transformY, vm.scale, 0);
            originX = e.pageX;
            originY = e.pageY;
        }

        img.onload = () => {
            this.scale = 1;
            this.scale_set = 1;

            control.style.top = 0 + 'px';
            control.style.left = 0 + 'px';

            this.transformX = 0;
            this.transformY = 0;

            //canvas 解析度500*500 顯示 250*250

            let ntW = img.naturalWidth;
            let ntH = img.naturalHeight;

            if (ntW < 500 && ntH < 500) {
                this.scale = ntW > ntH ? this.canvas_size / ntW : this.canvas_size / ntH;
            } else if (ntW > ntH) {
                this.scale = this.canvas_size / ntH;
            } else {
                this.scale = this.canvas_size / ntW;
            }

            control.style.width = ntW + 'px';
            control.style.height = ntH + 'px';
            control.style.transformOrigin = 'top left';
            control.style.transform = "scale(" + this.scale / (this.canvas_size / 250) + ")";

            this.draw(control.offsetLeft * (this.canvas_size / 250) / this.scale, control.offsetTop * (this.canvas_size / 250) / this.scale, this.scale, 0);
            // this.drawblur();
            // this.drawpre();
        }

        let img_input = document.getElementById('img-input');
        img_input.addEventListener('change', () => {
            this.img_onload = false;
            this.img_src = '';
            if (img_input.files && img_input.files[0]) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.img_src = e.target.result;
                    this.img_onload = true;
                }
                reader.readAsDataURL(img_input.files[0]);
            }
        })
    }
}
</script>

<style scoped>
input[type="range"] {
    -webkit-appearance: none;
    /* overflow: hidden; */
    /* 限定範圍 */
    width: 100px;
    height: 1px;
    outline: none;
    /* 避免點選會有藍線或虛線 */
    background: rgba(255, 255, 255, 0.6);
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    position: relative;
    /* 設為相對位置，為了前後區塊的絕對位置而設定 */
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    transition: .2s;
    /* 點選放大時候的漸變時間 */
}

#source-shape {
    box-shadow: 0 0 0 2px rgba(21, 94, 117, 0.4);
}
</style>
