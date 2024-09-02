<template>
    <form method="GET" :action="checkout_route">
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="id" :value="apartment.id">
        <input type="hidden" name="_token" :value="csrf">
        <div class="tour__form_block">
            <!--Выбор дня приезда и уезда-->
            <div class="apartment__chooseday">
                <div class="tour__chose_day">{{ translations.date_in }}:
                    <v-date-picker @popoverWillShow="willShow" :popover="{ visibility: 'click' }"  @update:to-page="onNext" :masks="masks" @dayclick="onDayClick" :minDate="min_date" color="orange" :value="value_in" :disabled-dates='disabled_dates' :attributes='attrs'>
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                name="date_from"
                                autocomplete="off"
                                id="date-in"
                                :placeholder="translations.date_in"
                                class="bg-white border px-2 py-1 rounded"
                                :value="inputValue"
                                v-on="inputEvents"
                            />
                        </template>
                        <template #day-popover="{ day, attributes }">
                            <div class="text-xs text-gray-300 font-semibold text-center">
                                <p v-for="{key, customData} in attributes"
                                   :key="key">
                                    {{ customData.price }}
                                </p>
                            </div>
                        </template>
                    </v-date-picker>
                </div>
                <div class="tour__chose_day">{{ translations.date_out }}:
                    <v-date-picker @popoverWillShow="willShow" :popover="{ visibility: 'click' }"  @update:to-page="onNext" @dayclick="onValueOutClick" :masks="masks" :minDate="value_in ? min_out_date : min_date" color="orange" is-expanded :value="value_out" :disabled-dates='disabled_dates'  :attributes='attrs'>
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                name="date_to"
                                autocomplete="off"
                                id="date-in"
                                :placeholder="translations.date_out"
                                class="bg-white border px-2 py-1 rounded"
                                :value="inputValue"
                                v-on="inputEvents"
                            />
                        </template>
                        <template #day-popover="{ day, attributes }">
                            <div class="text-xs text-gray-300 font-semibold text-center">
                                <p v-for="{key, customData} in attributes"
                                   :key="key">
                                    {{ customData.price }}
                                </p>
                            </div>
                        </template>
                    </v-date-picker>
                </div>
            </div>
            <div class="notice_apart__block">
                {{ translations.apartment_max_people }}
            </div>
            <div class="tour__peopleselect_wrapper">
                <div class="tour__adults">{{ translations.adults }}: &nbsp;
                    <div class="custom-select" style="width:60px;">
                        <select name="adults">
                            <option v-for="adult in apartment.max_adults" :key="adult" :value="adult">{{adult}}</option>
                        </select>
                    </div>
                </div>
                <div class="tour__children">{{ translations.children }}: &nbsp;
                    <div class="custom-select" style="width:60px;">
                        <select name="children">
                            <option v-for="child in apartment.max_children + 1" :value="child - 1">{{child - 1}}</option>
                        </select>
                    </div>
                </div>
                <div class="tour__infants">
                    {{ translations.infants }}: &nbsp;
                    <div class="custom-select" style="width:60px;">
                        <select name="infants">
                            <option v-for="infant in apartment.max_infants + 1"  :value="infant - 1">{{infant - 1}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="button__block__apart">
                <div class="tour__final-price" id="tour__final-price" style="display:none;">
                    {{translations.total_cost }}: <span :data-price="total_price" id="apart-price"></span> <span>{{ currency }}</span>
                </div>
                <button id="submit" disabled class="disabled" type="submit">{{ translations.book }}</button>

            </div>
        </div>
    </form>
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
            'availability_link', 'translations', 'apartment', 'currency', 'checkout_route', 'csrf'
        ],
        computed: {
            min_out_date() {
                return this.value_in ? this.value_in.date.setDate(this.value_in.date.getDate() + 1) : new Date().toDateString();
            },
            total_price() {
                if (this.value_in && this.value_out) {
                    $('#apart-price').html('');
                    $('#apart-price').addClass('loading');
                    let from_date = this.value_in.date;
                    let to_date = this.value_out.date;
                    $.ajax({
                        type: "POST",
                        url: '',
                        data: {in: moment(from_date.setDate(from_date.getDate() - 1)).format('YYYY-MM-DD'), out: moment(to_date.setDate(to_date.getDate() - 1)).format('YYYY-MM-DD')},
                        success: data => {
                            $('#apart-price').html(data);
                            $('#apart-price').removeClass('loading');
                            let price_element = document.getElementById('tour__final-price');
                            if(!price_element.classList.contains('activated')) {
                                $(price_element).slideDown();
                                price_element.classList.add('activated');
                                $('button#submit').removeClass('disabled');
                                $('button#submit').removeAttr('disabled');
                            }
                        },
                    });
                    return 0;
                }
                let price_element = document.getElementById('tour__final-price');
                if (price_element) {
                    $('#apart-price').html(0);
                    if(price_element.classList.contains('activated')) {
                        $(price_element).slideUp();
                        price_element.classList.remove('activated');
                        $('button#submit').addClass('disabled');
                        $('button#submit').prop('disabled', 'true');
                    }
                }
            }
        },
        data() {
            return {
                date: new Date(),
                masks: {
                    input: 'DD-MM-YYYY',
                },
                attrs: [],
                disabled_dates: {days: []},
                value_in: null,
                value_out: null,
                min_date: new Date().toDateString(),
            };
        },
        methods: {
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
                                popover: {
                                    label: 'T',
                                },
                                customData: {
                                    price: element.prices.price,
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
                if (!this.value_in || (moment(this.value_in.date.setDate(this.value_in.date.getDate() - 1)).format('YYYY-MM-DD') !== moment(day.date).format('YYYY-MM-DD'))) {
                    return this.value_in = day
                }
                return this.value_in = null;
            },
            onValueOutClick(day) {
                if (!this.value_out || moment(this.value_out.date).format('YYYY-MM-DD') !== moment(day.date).format('YYYY-MM-DD')) {
                    return this.value_out = day
                }
                return this.value_out = null;
            }
        },
    }
</script>
<style>
#submit.disabled{
    border-color: grey;
    color: grey;
    background-color: white;
}
.loading:after {
    content: ' .';
    animation: dots 1s steps(5, end) infinite;}

@keyframes dots {
    0%, 20% {
        color: rgba(0,0,0,0);
        text-shadow:
            .25em 0 0 rgba(0,0,0,0),
            .5em 0 0 rgba(0,0,0,0);}
    40% {
        color: white;
        text-shadow:
            .25em 0 0 rgba(0,0,0,0),
            .5em 0 0 rgba(0,0,0,0);}
    60% {
        text-shadow:
            .25em 0 0 white,
            .5em 0 0 rgba(0,0,0,0);}
    80%, 100% {
        text-shadow:
            .25em 0 0 white,
            .5em 0 0 white;}}

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
