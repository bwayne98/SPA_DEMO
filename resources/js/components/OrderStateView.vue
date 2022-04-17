<template>
<div class="order-container">

    <div class="lesson" v-if="lesson">
        <h5>課程資訊</h5>
        <label for="">課程名稱</label>
        <div>{{lesson.name}}</div>

        <label for="">上課日期</label>
        <div>{{lesson.start}} ~ {{lesson.end}}</div>

        <label for="">上課時段</label>
        <div>{{lesson.period}}</div>
        <label for="">授課老師</label>
        <div>{{lesson.teacher}}</div>
        <label for="">課程費用</label>
        <div>NT$ 3600</div>
    </div>

    <div class="form">
        <h5>報名資訊</h5>

        <label for="">姓名</label>
        <div>{{order.name}}</div>

        <label for="">聯絡信箱</label>
        <div>{{order.email}}</div>

        <label for="">聯絡電話</label>
        <div>{{order.phone}}</div>

        <label for="">付款狀態</label>
        <div v-if="order.paid === 1">付款成功</div>
        <div v-else>待付款</div>

        <label for=""></label>
    </div>

    <button @click="clickButton()" :disabled="order.paid === 1">前往付款</button>

    <p v-if="err_meg !== ''">{{err_meg}}</p>

</div>
</template>

<script>
export default {
    data() {
        return {
            order: {},
            lesson: {},
            err_meg: ''
        }
    },
    methods: {
        clickButton() {
            axios.post('/api/greenworldcredit',{
                id:this.order.id,
                lesson_id:this.order.lesson_id
            }).then(res=>console.log(res.data)).catch(err=> console.log(err.response.data.meg))
        }
    },
    async beforeMount() {
        console.log(this.$route.params.id)

        await axios.get('/api/orderstate/' + this.$route.params.id)
            .then(res => this.order = res.data)
            .then(() => {
                axios.get('/api/lesson/' + this.order.lesson_id).then(res => this.lesson = res.data[0])
            })

        // this.lesson = 1;

    },
}
</script>

<style lang="scss" scoped>
.order-container {
    width: 1000px;
    max-width: 100vw;
    height: 100vh;
    margin: 0 auto;
    // background-color: gray;
    text-align: center;
    padding: 30px 50px;

    >button {
        font-weight: 100;
        margin-top: 20px;
        width: 120px;
        height: 55px;
        background-color: gray;
        color: white;
        border-radius: 3px;
    }

    P {
        margin: 10px;
        color: palevioletred;
    }
}

.lesson,
.form {
    display: grid;
    grid-template-columns: .4fr 1fr;
    font-size: 20px;
    line-height: 28px;
    row-gap: 10px;
    border-style: none none solid none;
    border-width: 1px;
    border-color: darkcyan;

    >h5 {
        grid-column: 1/3;
        font-size: 32px;
        line-height: 40px;
        margin: 15px 0;
    }

    >input {
        min-width: 10px;
    }
}
</style>
