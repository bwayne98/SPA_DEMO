<template>
<div>
    <h2>課程設定選項</h2>
    <form class="detail-set" action="#">

        <div class="input-gird">
            <label for="">課程名稱</label>
            <div class="name-grid">
                <select class="input-box select-arrow" name="" id="" :disabled="checking">
                    <option value="Y">Y</option>
                    <option value="R">R</option>
                </select>
                <input class="input-box input-number" id="level" type="number" value="1" min="1" max="12" :disabled="checking" v-model="level" @blur="checkLevel()">
                <select class="input-box select-arrow" name="" id="" :disabled="checking">
                    <option value="X">X</option>
                    <option value="Y">Y</option>
                    <option value="Z">Z</option>
                </select>
            </div>

        </div>
        <div class="input-gird">
            <label for="">課程時間</label>
            <span>{{form[1]}} ~ {{form[24]}}</span>
        </div>
        <div class="input-gird">
            <label for="">課程時段</label>
            <div class="period-gird">
                <span> {{ days.text }}</span>
                <select class="input-box select-arrow" name="" id="period" v-model="period" :disabled="checking">
                    <option value="">請選擇</option>
                    <option value="18:">18:00</option>
                    <option value="20">20:00</option>
                </select>
            </div>

        </div>
        <div class="input-gird">
            <label for="">授課老師</label>
            <select class="input-box select-arrow" name="" id="" v-model="teacher_id" :disabled="checking">
                <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{ teacher.enName }}</option>
            </select>
        </div>
        <div class="input-gird">
            <label for="">教室</label>
            <select class="input-box select-arrow" name="" id="" v-model="room" :disabled="checking">
                <option v-for="(room,index) in rooms" :key="'room' + index" :value="room">{{ room }}</option>
            </select>
        </div>

    </form>
</div>
</template>

<script>
export default {
    props: ["form", 'days'],
    data() {
        return {
            level: 1,
            rooms: ['請先選擇時段'],
            room: '請先選擇時段',
            teachers: [{
                id: 'choose',
                enName: '請先選擇時段'
            }],
            teacher_id: 'choose',
            period: '',
            checking: false,
        }
    },
    mounted() {

        let period_select = document.getElementById('period');
        period_select.addEventListener('change', (e) => {

            this.checking = true;

            this.period = e.target.value;
            this.teachers = [{
                id: 'choose',
                enName: '請先選擇時段'
            }];
            this.teacher_id = 'choose';
            this.rooms = ['請先選擇時段'];
            this.room = '請先選擇時段';

            if (e.target.value === '') {
                this.checking = false;
                return;
            }

            axios.post('/api/checknewlesson', {
                    dates: this.form,
                    days: this.days.text,
                    period: this.period
                }).then((e) => {
                    e.data[1].map(teacher => this.teachers.push(teacher));
                    let rooms = Object.keys(e.data[2])
                            .map(function (key) {
                                return e.data[2][key];
                            });
                    rooms.map(room => this.rooms.push(room));
                }).catch((err) => {
                    console.log(err)
                })
                .then(() => {
                    this.checking = false;
                })
        })
    },

    methods: {
        filterTeacher() {

        },
        checkLevel() {
            if (parseInt(this.level) > 12) {
                this.level = 12;
                return;
            }
            if (parseInt(this.level) < 1) {
                this.level = 1;
                return;
            }

            this.level = parseInt(this.level) ? parseInt(this.level) : 1;
        }
    }
}
</script>

<style lang="scss" scoped>
h2 {
    text-align: center;
    font-size: 2em;
    font-weight: 400;
}

.detail-set {
    display: grid;
    grid-template-columns: 1fr;
    row-gap: 5px;
    padding: 0 10px 0 10px;
    width: 100%;

    .input-gird {
        display: grid;
        grid-template-columns: 100px 1fr;

        .period-gird {
            display: grid;
            grid-template-columns: 100px 100px;
        }

        .name-grid {
            display: grid;
            column-gap: 5px;
            grid-template-columns: repeat(3, 60px);
        }
    }
}

.select-arrow {
    text-align: center;
    font-weight: 400;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.input-box {
    border-radius: 3px;
}

.input-number {
    text-align: center;
    font-weight: 400;
}
</style>
