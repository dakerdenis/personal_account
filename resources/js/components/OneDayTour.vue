<template>
    <div class="__booking_block-booking-select">
        <!--ФОРМА с данными-->
        <form :action="checkout_route" method="get" class="form_s" >
            <div class="tour__form_block">
                <input type="hidden" name="type" value="3">
                <input type="hidden" name="id" :value="tour.id">
                <input type="hidden" name="tour_type" :value="tour.type">
                <div class="tour__chose_day">{{ translations.select_date }}:
                    <v-date-picker :locale="locale" @popoverWillShow="willShow" @update:to-page="onNext" :popover="{ visibility: 'click' }" :masks="masks" @dayclick="onDayClick" :minDate="min_date" color="orange" :value="value_in" :disabled-dates='disabled_dates' :attributes='attrs'>
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                name="date_from"
                                id="date-in"
                                autocomplete="off"
                                :placeholder="translations.select_date"
                                class="bg-white border px-2 py-1 rounded"
                                :value="inputValue"
                                v-on="inputEvents"
                            />
                        </template>
                        <template #day-popover="{ day, attributes }">
                            <div class="text-xs text-gray-300 font-semibold text-center">
                                <p>
                                    {{ translations.group_discount }} -{{attributes[0] ? attributes[0].customData.discount : ''}}%
                                </p>
                            </div>
                        </template>
                    </v-date-picker>
                </div>

                <div class="tour__peopleselect_wrapper">
                    <div class="tour__adults">{{ translations.adults }}: &nbsp;
                        <div class="custom-select" id="adults" style="width:60px;">
                            <select name="adults" v-model="adults">
                                <option v-for="adult in tour.max_adults" :key="adult" :value="adult">{{adult}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="tour__children">{{ translations.children }}: &nbsp;
                        <div class="custom-select" id="children" style="width:60px;">
                            <select name="children" v-model="children">
                                <option v-for="child in tour.max_children + 1" :value="child - 1">{{child - 1}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="tour__infants">
                        {{ translations.infants }}: &nbsp;
                        <div class="custom-select" id="infants" style="width:60px;">
                            <select name="infants" v-model="infants">
                                <option v-for="infant in tour.max_infants + 1"  :value="infant - 1">{{infant - 1}}</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" v-model="one_day_tour_type" name="one_day_tour_type">
            <div class="tour__final-price__booking">
                <div class="select__tour__block" id="select__tour__block" style="display:none">
                    <p class="select__tour__blokc-p">{{translations.select_type}}:</p>
                    <div class="select__tour__wrapper">
                        <div class="select__tour__element" style="background-color: rgb(255, 136, 0); color: white" id="select__tour__block1" @click="groupSelect" onclick="myFunction1()" >
                            <div class="selected__tour_name">{{ translations.group_tour }}</div>
                            <div class="selected__tour__price">{{ group_price }} {{ currency }}</div>
                        </div>
                        <div class="select__tour__element" @click="individualSelect" id="select__tour__block2" onclick="myFunction2()" >
                            <div class="selected__tour_name">{{ translations.individual_tour }}</div>
                            <div class="selected__tour__price">{{ individual_price }} {{ currency }}</div>
                        </div >
                    </div>
                </div>

                <div class="tour__booking-button">
                    <button type="submit"  class="__booking-button">
                        {{ translations.book }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import VCalendar from 'v-calendar';
    import moment from 'moment';
    export default {
        mounted() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        props: [
            'availability_link', 'translations', 'tour', 'currency', 'locale', 'checkout_route', 'csrf'
        ],
        computed: {
            group_price() {
                if (this.value_in) {
                    let price = this.recalculate();
                    let price_element = document.getElementById('select__tour__block');
                    if(!price_element.classList.contains('activated')) {
                        $(price_element).slideDown();
                        price_element.classList.add('activated');
                    }
                    return price;
                }
                return 0;
            },
            individual_price() {
                if (this.value_in) {
                    return this.recalculateIndividual();
                }
                return 0;
            }
        },
        data() {
            return {
                date: new Date(),
                selectAttribute: {
                    dot: true,
                },
                masks: {
                    input: 'DD-MM-YYYY',
                },
                attrs: [],
                disabled_dates: {days: []},
                value_in: null,
                min_date: new Date().toDateString(),
                adults: 1,
                children: 0,
                infants: 0,
                one_day_tour_type: 'group',
            };
        },
        methods: {
            recalculate(){
                let adults_price = this.value_in.attributes[0].customData.adult_group;
                let children_price = this.value_in.attributes[0].customData.child_group;
                let infants_price = this.value_in.attributes[0].customData.infant_group;
                let discount = this.value_in.attributes[0].customData.discount ?? 0;
                return Math.round(((this.adults * adults_price) + (this.children * children_price) + (this.infants * infants_price)) * (1 - (discount/100)));
            },
            recalculateIndividual(){
                let adults_price = this.value_in.attributes[0].customData.adult_price;
                let children_price = this.value_in.attributes[0].customData.child_price;
                let price = this.tour.price;
                let percent = this.tour.percent;
                let discount = this.value_in.attributes[0].customData.discount ?? 0;
                return Math.round(((price + (adults_price * this.adults)) + (price + (adults_price * this.adults)) * (percent/100)) + (children_price * this.children));
            },
            willShow(object) {
              $(object).prepend('<div class="spinner-overlay">\n' +
                  '<div class="lds-ring"><div></div><div></div><div></div><div></div></div>\n' +
                  '</div>');
            },
            onNext(page) {
                let month = page.month;
                let year = page.year;
                let entity = this.entity;
                this.disabled_dates.days = [];
                let disabled_d = this.disabled_dates;
                let popover = $('.vc-popover-content');
                if (popover.length) {
                    $(popover).prepend('<div class="spinner-overlay">\n' +
                        '<div class="lds-ring"><div></div><div></div><div></div><div></div></div>\n' +
                        '</div>');
                }
                $.ajax({
                    type: "POST",
                    url: this.availability_link,
                    data: {entity, month, year},
                    success: data => {
                        if(!data.length) {
                            disabled_d.days = Array.from(new Array(31), (x,i) => i+1);
                        }
                        this.attrs = data.filter(function(element) {
                            if (element.availability && moment(element.date).isSameOrAfter()) {
                                return true;
                            }
                            disabled_d.days.push(moment(element.date).date());
                            return false;
                        }).map(function (element) {
                            return {
                                key: moment(element.date).format('YYYY-MM-DD'),
                                popover: element.discount ? {
                                    label: 'T',
                                } : false,
                                highlight: element.discount ? 'red' : false,
                                customData: {
                                    adult_price: element.prices.adult_price,
                                    child_price: element.prices.child_price,
                                    infant_price: element.prices.infant_price,
                                    adult_group: element.prices.adult_group,
                                    child_group: element.prices.child_group,
                                    infant_group: element.prices.infant_group,
                                    discount: element.discount,
                                    availability: element.availability,
                                },
                                dates:  moment(element.date, 'YYYY-MM-DD').toDate()
                            }
                        });
                        $('.spinner-overlay').remove();
                    },
                });
            },
            onDayClick(day) {
                if(day.attributes.length) {
                    this.value_in = day
                }
            },
            groupSelect() {
                this.one_day_tour_type = 'group';
            },
            individualSelect() {
                this.one_day_tour_type = 'individual';
            }
        },
    }
</script>
<style>
.spinner-overlay{
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #2c3e50;
    left: 0;
    top: 0;
    z-index: 5;
    opacity: 0.55;
    border-radius: 10px
}
.lds-ring {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}
.lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 64px;
    height: 64px;
    margin: 8px;
    border: 8px solid #fff;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
}
@keyframes lds-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.vc-container {
    --font-normal:400;
    --font-medium:500;
    --font-semibold:600;
    --font-bold:700;
    --text-xs:12px;
    --text-sm:14px;
    --text-base:16px;
    --text-lg:18px;
    --leading-snug:1.375;
    --rounded:0.25rem;
    --rounded-lg:0.5rem;
    --rounded-full:9999px;
    --shadow:0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px 0 rgba(0,0,0,0.06);
    --shadow-lg:0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05);
    --shadow-inner:inset 0 2px 4px 0 rgba(0,0,0,0.06);
    --slide-translate:22px;
    --slide-duration:0.15s;
    --slide-timing:ease;
    --day-content-transition-time:0.13s ease-in;
    --weeknumber-offset:-34px;
    position:relative;
    display:inline-flex;
    width:350px;
    height:max-content;
    font-family:BlinkMacSystemFont,-apple-system,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Helvetica,Arial,sans-serif;
    color:var(--gray-900);
    background-color:var(--white);
    border:1px solid;
    border-color:var(--gray-400);
    border-radius:var(--rounded-lg);
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    -webkit-tap-highlight-color:transparent
}
.vc-popover-content{
    opacity: 1;
}
.vc-popover-content::after{
    content: '';
}
</style>
