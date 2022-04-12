<template>
<div class="flex justify-center items-center pb-8">
    <div class="md:w-3/5 w-full">
        <h1 class="mt-12 text-3xl font-black text-center">New Lesson create.</h1>

        <div class="grid grid-cols-5 mt-10 gap-x-4">
            <form id="checkform" class="lg:col-span-2 col-span-5">
                <div class="date-create">
                    <div>
                        <label for="">開課時間</label>
                        <input type="date" v-model="lessonstart" min="2022-01-01">
                    </div>
                    <div class="checkbotton">
                        <button type="button" @click="dateInit()" :disabled="creating">
                            <span v-if="created">重置</span>
                            <span v-else>產生</span>
                        </button>
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
                        <div v-if="edit_control !== index"> {{ lesson }} </div>
                        <div v-else class="edit">
                            <input type="date" v-model="form[index]" min="2022-01-01">
                            <div></div>
                            <button type="button" class='bx bx-check-circle' @click="editConfirm( index )"></button>
                            <button type="button" class='bx bx-x-circle' @click="editCancel( index )"></button>
                        </div>
                        <div v-if="edit_control !== index"><button class='bx bx-edit-alt' @click="editDate( index )" :disabled="editing || index == 1 || detail_set"></button></div>
                    </div>
                    <div class="checkbotton">
                        <button type="button" @click="detailSet()">
                            <span v-if="!detail_set"> 詳細設定</span>
                            <span v-else> 調整日期</span> </button>
                    </div>

                </div>
            </form>

            <div class="lg:col-span-3 col-span-5 detail-set">
                <div v-if="!detail_set"></div>
                <newlessondetial v-else :form="form" :days="days"></newlessondetial>
            </div>

        </div>
    </div>
</div>
</template>

<script>
import newlessondetial from './newLessonDetail.vue'

export default {
    components: {
        "newlessondetial": newlessondetial,
    },
    data() {
        return {
            form: {},
            days: {
                num: 0,
                text: '',
            },
            lessonstart: null,
            created: false,
            creating: false,
            editing: false,
            edit_control: 0,
            edit_temp: '',
            checked: false,
            detail_set: false,
        }
    },
    methods: {
        detailSet() {
            this.detail_set = !this.detail_set;
        },
        editDate(index) {
            this.edit_control = index;
            this.edit_temp = this.form[index];
            this.editing = true;
        },
        editConfirm(index) {
            this.creating = true;
            this.created = false;

            let cur = new Date(this.form[index]);
            let new_week = cur.getDay();
            let week = this.days.num;
            console.log(new_week);

            if (new_week === week) {
                cur.setDate(cur.getDate() + 3);
                new_week += 3;
            } else if (new_week === week + 3) {
                cur.setDate(cur.getDate() + 4);
                new_week += 4;
            } else if (new_week > week && new_week > week + 3) {
                cur.setDate(cur.getDate() + (7 + week - new_week));
                new_week = week;
            } else if (new_week > week && new_week < week + 3) {
                cur.setDate(cur.getDate() + (3 + week - new_week));
                new_week = week + 3
            } else {
                // new_week < week
                cur.setDate(cur.getDate() + (week - new_week));
                new_week = week;
            }

            console.log(new_week);

            this.dateCreate(cur, new_week, (parseInt(index) + 1));

            this.edit_control = 0;
            this.editing = false;
            this.creating = false;
            this.created = true;
        },
        editCancel(index) {
            setTimeout(() => {
                this.form[index] = this.edit_temp;
                this.edit_temp = '';
                this.edit_control = 0;
                this.editing = false;
            }, 300);
        },
        dateCreate(cur, week, index) {
            for (let i = index; i <= 24; i++) {
                let date = cur.getDate() >= 10 ? cur.getDate().toString() : '0' + cur.getDate();
                let month = cur.getMonth() + 1 >= 10 ? (cur.getMonth() + 1).toString() : '0' + (cur.getMonth() + 1);
                let year = cur.getFullYear().toString();
                this.form[i] = year + '-' + month + '-' + date;
                // console.log(year + '-' + month + '-' + date);
                // console.log(cur.getDay());
                if (week <= 3) {
                    cur.setDate(cur.getDate() + 3);
                    week += 3;
                } else {
                    cur.setDate(cur.getDate() + 4);
                    week = (week + 4) % 7;
                }
            }
        },
        dateInit() {
            this.form = {};
            this.detail_set = false,
                this.creating = true;
            this.created = false;
            this.edit_control = 0;
            this.editing = false;

            var cur = new Date(this.lessonstart);
            var week = cur.getDay();

            if (week === 0) {
                this.created = false;
                this.creating = false;
                return;
            }
            if (week === 1 || week === 4) {
                this.days.num = 1;
                this.days.text = 'Mon-Thur'
            } else if (week === 2 || week === 5) {
                this.days.num = 2;
                this.days.text = 'Tue-Fri'
            } else {
                this.days.num = 3;
                this.days.text = 'Wed-Sat'
            }

            this.dateCreate(cur, week, 1);

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

::-webkit-calendar-picker-indicator {
    margin-left: 0px;
}

::-webkit-datetime-edit {
    text-align: center;
}

#checkform {

    // // border-bottom-width: 0;
    // border-radius: 5px 5px 2px 2px;
    div.date-create {
        padding: 4px 8px 12px 8px;
        // border-style: solid;
        // border-color: black;
        // border-width: 0 0 1px 0;

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
    display: grid;
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
            place-self: center;

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
            justify-content: center;
            align-items: center;
            background-color: white;
            padding: 0 3px 0 3px;
            border-radius: 3px;
            font-size: 1.2em;
            width: 100%;
            position: relative;
        }

        .edit {
            grid-column: 2/-1;
            position: relative;
            display: block;

            input {
                width: 100%;
                height: 100%;
                padding: 4px 0 4px 0;
            }

            div {
                pointer-events: none;
            }

            button {
                position: absolute;
                color:$color2;
                background-color: rgba(0, 0, 0, 0.1);
                border-radius: 3px 0 0 3px;
                top: -100%;
                height: 100%;
                width: 50%;
                left: 0px;
                z-index: 10;
                opacity: 0;
                pointer-events: none;
            }

            button:nth-child(4) {
                border-radius: 0 3px 3px 0;
                left:auto;
                right: 0px;
                color: red;
            }
        }

        .edit:hover {
            button {
                pointer-events: all;
                opacity: 1;
                transition: all 0.5s;
            }

            button:hover {
                border-radius: 3px;
                width: 100%;
                z-index: 15;
                background-color: $color2;
                color: white;
                transition: all 0.3s;
            }

            button:hover:nth-child(4) {
                background-color: red;
            }
        }

        :nth-child(3) {
            button {
                font-size: 30px;
                cursor: pointer;
                margin-top: 5px;
            }

            button:hover {
                color: $color2;
            }

            button:disabled {
                cursor: auto;
                opacity: 0.5;
            }

            button:disabled:hover {
                color: black;
            }
        }
    }
}

.checkbotton {
    padding-bottom: 16px;
    border-style: solid;
    border-width: 0 0 1px 0;
    border-color: black;
}

.detail-set {
    margin-top: 10px;
    font-size: 1.2em;
}

@media (max-width: 1024px) {
    .date-set {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(13, 1fr);
        grid-auto-flow: column;

        :nth-child(25) {
            grid-row: 13;
            grid-column: 1 / span 2;
        }
    }
}

@media (max-width: 400px) {
    .dates {
        :nth-child(2) {
            font-size: 1em !important;
        }
    }
}
</style>
