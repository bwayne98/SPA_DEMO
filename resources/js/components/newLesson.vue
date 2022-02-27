<template>
<div class="flex justify-center items-center">
    <div class="w-3/5">
        <h1 class="mt-12 text-3xl font-black text-center">New Lesson create.</h1>

        <div class="grid grid-cols-5 mt-10 gap-x-4">
            <form id="checkform" class="lg:col-span-2 col-span-5">
                <div class="date-create">
                    <div>
                        <label for="">開課時間</label>
                        <input type="date" v-model="lessonstart">
                    </div>
                    <div class="checkbotton">
                        <button type="button" @click="dateCreate()" :disabled="creating">產生</button>
                    </div>
                </div>
                <div v-if="!created" class="guild">
                    --請先設定開課日期--
                </div>
                <div v-else class="date-set">
                    <div class="dates" v-for="lesson,index in form" :key="'lesson' + index">
                        <div>
                            <span>
                                {{ parseInt(index) >= 10 ? index : '0' + index}}
                            </span>
                        </div>
                        <div> {{ lesson }} </div>
                        <div><i class='bx bx-edit-alt'></i></div>
                    </div>
                    <div class="checkbotton">
                        <button type="button">檢查</button>
                    </div>

                </div>
            </form>

            <div class="lg:col-span-3 col-span-5">
                456
            </div>

        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                1: null,
                2: null,
                3: null,
                4: null,
                5: null,
                6: null,
                7: null,
                8: null,
                9: null,
                10: null,
                11: null,
                12: null,
            },
            days: {
                1: '一',
                2: '二',
                3: '三',
                4: '四',
                5: '五',
                6: '六',
                0: '日',
            },
            lessonstart: null,
            created: false,
            creating: false,
            create_error: false
        }
    },
    methods: {
        dateCreate() {
            this.creating = true;
            this.created = false;
            var cur = new Date(this.lessonstart);
            var week = cur.getDay();
            if (week === 0) {
                this.created = false;
                this.creating = false;
                return;
            }
            for (let i = 1; i <= 12; i++) {
                let date = cur.getDate() >= 10 ? cur.getDate().toString() : '0' + cur.getDate();
                let month = cur.getMonth() + 1 >= 10 ? (cur.getMonth() + 1).toString() : '0' + (cur.getMonth() + 1);
                let year = cur.getFullYear().toString();

                this.form[i] = year + '-' + month + '-' + date;
                console.log(year + '-' + month + '-' + date)
                console.log(cur.getDay())

                if (week <= 3) {
                    cur.setDate(cur.getDate() + 3);
                    week += 3;
                } else {
                    cur.setDate(cur.getDate() + 4);
                    week = (week + 4) % 7;
                }

            }
            setTimeout(() => {
                this.created = true;
                this.creating = false;
            }, 500);

        }
    }
}
</script>

<style lang="scss" scoped>
$color1: rgba(86, 85, 84, 1);
$color2: #2E86AB;
$color3: #F6F5AE;
$color4: #F5F749;
$color5: #F24236;

#checkform {
    // // border-bottom-width: 0;
    // border-radius: 5px 5px 2px 2px;

    div.date-create {
        padding: 4px 8px 12px 8px;
        border-style: solid;
        border-color: black;
        border-width: 0 0 1px 0;

        div {
            width: 100%;
            margin: 1px;
            margin-top: 6px;
            text-align: center;

            label {
                font-size: 1.2em
            }
        }

        input {
            padding: 2px 5px 2px 5px;
            width: 100%;
            font-size: 1.2em;
            border-radius: 3px;
        }
    }
}

div.guild {
    text-align: center;
    margin: 10px;
    font-size: 1.2em;
    font-weight: 200;
}

.checkbotton {
    button {
        color: white;
        box-shadow: 4px 5px black;
        border-style: solid;
        border-width: 1px;
        border-color: black;
        border-radius: 5px;
        width: 50%;
        background-color: $color2;
        font-size: 1.2em
    }

    button:hover {
        border-color: transparent white white transparent;
    }

    button:active {
        transform: translateX(2px) translateY(3px);
        box-shadow: 2px 3px black;
    }

    button:disabled {
        transform: translateX(2px) translateY(3px);
        box-shadow: 2px 3px black;
        opacity: 0.6;
    }
}

.date-set {
    text-align: center;

    .dates {
        display: grid;
        grid-template-columns: 50px 1fr 30px;
        column-gap: 3px;
        margin: 5px 0 5px 0;

        div:nth-child(1) {
            padding: 5px;
            text-align: right;
            font-weight: 600;

            span {
                position: relative;
                margin-right: 10px;
                color: white;
                background-color: $color1;
                padding: 5px;
            }

            span:after {
                position: absolute;
                content: "";
                border-style: solid;
                border-width: 15px;
                border-color: transparent transparent transparent $color1;
                top: 0;
                right: -30px;
                width: 30px;
                height: 100%;
            }
        }
        :nth-child(2) {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 0 3px 0 3px;
            border-radius: 3px;
        }
        :nth-child(3) {
            i {
                font-size: 30px;
                cursor: pointer;
                padding-top:5px;
            }
            i:hover {
                color: $color2;
            }
        }
    }
}


@media (max-width: 1024px) {
    .date-set {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 640px) {
    .date-set {
        grid-template-columns: 1fr;
    }
}
</style>
