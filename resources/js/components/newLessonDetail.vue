<template>
<div>
    <form class="detail-set" action="#">
        <div>
            <label for="">課程名稱</label>
            <input type="text">
        </div>
        <div>
            <label for="">課程時間</label>
            <span>{{form[1]}} ~ {{form[24]}}</span>
        </div>
        <div>
            <label for="">課程時段</label>
            <span> {{ days.text }}</span>
            <select name="" id="">
                <option value="">18:00</option>
                <option value="">20:00</option>
            </select>
        </div>
        <div>
            <label for="">授課老師</label>
        </div>
        <div>
            <label for="">教室</label>
        </div>

    </form>
</div>
</template>

<script>
export default {
    props:["form",'days'],
    data(){
        return{

        }
    }
}
</script>

<style scoped>

</style>
