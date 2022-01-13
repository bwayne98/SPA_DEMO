<template>
    <div >
        <router-view name="nav"></router-view>
        <router-view></router-view>
        <p>rooo = {{ rooo }}</p>
        <p>roo = {{ roo }}</p>
    </div>
</template>

<script>
export default {
    props: ["rooo"],
    data() {
        return{
            roo: 1
        }
    },
}
</script>