<template>
    <div id="baku" class="tabcontent">
        <form :action="checkout_route" method="GET" id="in_baku_form">
            <input type="hidden" :value="total_price ? total_price : location_price" class="last_price">
            <input type="hidden" name="type" value="2">
            <input type="hidden" name="transfer_type" value="in">
            <input type="hidden" name="id" :value="transfer.id">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="location_from" :value="selected_location_id">
            <div class="where_and_from_wrapper">
                <div class="where__car">
                    <span>{{translations._from}}:</span>
                    <p>{{translations.baku}}</p>
                </div>

                <!--Куда-->
                <div class="destination__car">
                    <span>{{translations._where}}:</span>
                    <div class="custom-select" style="width: 100%">
                        <select id="test3" @change="setLocation">
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
            <div class="select__car___date__wrapper select__car___date__wrapper2">
                <!--Дата туда-->
                <div class="select__car__date__to">
                    <span>{{translations.there}}</span>
                    <br>
                    <div class="tour__chose_day">
                        <v-date-picker :locale="locale" :masks="masks" @dayclick="onDayClick" :minDate="min_date" color="orange" :value="value_in" :attributes='attrs'>
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
            document.getElementById('total_price').innerHTML = this.raw_price + this.currency;
        },
        props: [
            'locations', 'translations', 'currency', 'locale', 'checkout_route', 'csrf', 'transfer'
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
                value_out: null,
                min_date: new Date().toDateString(),
                selected_location: 0,
                return_disabled: true,
                total_price: null,
                total_price_raw: null,
                selected_extras: [],
            };
        },
        methods: {
            onDayClick(day) {
                this.value_in = day;
                this.recalculate();
            },
            onDayClickReturn(day) {
                this.value_out = day
            },
            setLocation() {
                this.selected_location = document.getElementById('test3').value;
                this.recalculate();
            },
            oneWay() {
                document.getElementById('date-out').value = '';
                document.getElementById('date-out').dispatchEvent(new Event('change'));
                this.return_disabled = true;
                this.recalculate();
            },
            onReturnEnable() {
                this.return_disabled = false
                this.recalculate();
            },
            recalculate() {
                let price = this.raw_price;
                if(!this.return_disabled) {
                    price = price*2;
                }
                price = this.selected_extras.reduce(
                    (previousValue, currentValue) => previousValue + currentValue.converted_price,
                    price
                );
                this.total_price = price + this.currency;
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
.tabcontent .tour__chose_day {
    text-align: left;
    font-size: 25px;
    margin-bottom: 20px;
    margin-top: 0;
}
.tabcontent .tour__chose_day input {
    font-family: 'Montserrat';
    margin-top: 10px;
    font-weight: 600;
    font-size: 20px;
    background-color: #fff;
    padding: 5px 25px 5px 25px;
    border-radius: 20px;
    text-transform: uppercase;
    cursor: pointer;
    border: 2px solid rgb(255, 136, 0);
    color: rgb(255, 136, 0);
    width: 70%;
    margin-left: 0;
}
</style>
