<template>
    <div id="fromBaku" class="tabcontent">
        <form id="from_baku_form" :action="checkout_route" method="GET">
            <input type="hidden" :value="total_price ? total_price : location_price" class="last_price">
            <input type="hidden" name="type" value="2">
            <input type="hidden" name="id" :value="transfer.id">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="location_to" :value="selected_location_id">
            <input type="hidden" name="transfer_type" value="from">
            <div class="where_and_from_wrapper">
                <div class="where__car">
                    <span>{{translations._from}}:</span>
                    <p>{{translations.baku}}</p>
                </div>

                <!--Куда-->
                <div class="destination__car">
                    <span>{{translations._where}}:</span>
                    <div class="custom-select" style="width: 100%">
                        <select id="test2" @change="setLocation">
                            <option v-for="(location, index) in locations" :key="location.id" :value="index">{{location.title}}</option>
                        </select>
                    </div>
                </div>

                <div v-if="has_extras" class="destination__car">
                    <span>{{ translations.extra_options }}</span>
                    <div class="checkselect">
                        <label v-for="extra in locations[selected_location].extras">
                            <input type="checkbox" name="extra_options[]" @change="onExtraSelect(extra)" class="extra" :value="extra.id" :data-price="extra.converted_price"> {{extra.title}} + <span>{{extra.converted_price}} {{currency}}</span> </label>
                    </div>
                </div>
            </div>


            <!--Дата-->
            <div class="select__car___date__wrapper">
                <!--Дата туда-->
                <div class="select__car__date__to">
                    <span>{{translations.there}}</span>
                    <br>
                    <div class="tour__chose_day">
                        <v-date-picker  :popover="{ visibility: 'click' }"  :locale="locale" :masks="masks" @dayclick="onDayClick" :minDate="min_date" color="orange" :value="value_in" :attributes='attrs'>
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    name="date_from"
                                    id="date-in"
                                    autocomplete="off"
                                    class="bg-white border px-2 py-1 rounded"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                            <template #day-popover="{ day, attributes }">
                                <div class="text-xs text-gray-300 font-semibold text-center">
                                    <p>{{ location_price }}</p>
                                </div>
                            </template>
                        </v-date-picker>
                    </div>
                </div>

                <div v-if="extra_night_price > 0" class="extranight__select__car">
                    <div class="extranight__select__car_desc">
                        {{translations.extra_night}} + <span>{{extra_night_price}} {{ currency }}</span>
                    </div>
                    <div class="custom-select" style="width: 35%">
                        <select  name="extra_night"  @change="recalculate" v-model="extra_nights_count">
                            <option v-for="index in 11" :value="index - 1">{{ index - 1 }}</option>
                        </select>
                    </div>
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
            'locations', 'translations', 'currency', 'extra_night_price', 'locale', 'transfer', 'csrf', 'checkout_route'
        ],
        computed: {
            min_out_date() {
                return this.value_in ? this.value_in.date.setDate(this.value_in.date.getDate() + 1) : new Date().toDateString();
            },
            location_price() {
                return this.locations[this.selected_location].converted_price_with_symbol
            },
            raw_price() {
                return this.locations[this.selected_location].converted_price
            },
            has_extras() {
                return this.locations[this.selected_location].extras.length
            },
            selected_location_id() {
                return this.locations[this.selected_location].id
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
                min_date: new Date().toDateString(),
                selected_location: 0,
                total_price: null,
                total_price_raw: null,
                selected_extras: [],
                extra_nights_count: 0
            };
        },
        methods: {
            onDayClick(day) {
                this.value_in = day;
                this.recalculate();
            },
            setLocation() {
                this.selected_location = document.getElementById('test2').value;
                this.recalculate();
            },
            recalculate() {
                let location_price = this.raw_price;
                let extra_nights_price = 0;
                if (this.extra_nights_count > 0) {
                     extra_nights_price = this.extra_night_price * this.extra_nights_count;
                }
                location_price = this.selected_extras.reduce(
                    (previousValue, currentValue) => previousValue + currentValue.converted_price,
                    location_price
                );
                this.total_price = (location_price + extra_nights_price) + this.currency;
                document.getElementById('total_price').innerHTML = this.total_price;
            },
            onExtraSelect(extra) {
                let index = this.selected_extras.indexOf(extra);
                if (index !== -1) {
                    this.selected_extras.splice(index, 1);
                    return this.recalculate();
                }
                this.selected_extras.push(extra);
                this.recalculate();
            }
        },
    }
</script>
<style>
.select__car__date__to span{
    font-size: 22px;
}
label.container{
    margin-bottom: 0;
}
.disabled-return{
    height: 34px;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgb(0,0,0,.15);
    width: 70%;
    padding: 0 25px;
    border-radius:20px;
    margin-top: 10px;
    border: 2px solid rgb(0,0,0,.25);
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
</style>
