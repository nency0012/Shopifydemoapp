<template>
    <PLayoutSection>
        <PStack>
            <PStackItem fill>
                <PHeading element="h1">Orders</PHeading>
            </PStackItem>
        </PStack>
        <PCard sectioned>
            <PDataTable
                :headings="orderTableHeaders"
                :rows="orders"
                :loading="!isDataLoaded"
                :hasFilter="true"
                searchPlaceholder="Search by orders">

                <template slot="body">
                    <tr v-for="(order, index) in orders" :key="`row-${index}`"  class="Polaris-DataTable__TableRow">

                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ order.order_name}} </td>

                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">   {{ order.customer_name }} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ order.Total}} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ order.Payment}} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ order.created_at}} </td>
                    </tr>
                </template>

            </PDataTable>

<!--            <polaris-data-table class="discount-table"-->
<!--                                :headers="showroomTableHeaders"-->
<!--                                :items="showrooms"-->
<!--                                :tableOptions="tableOptions"-->
<!--                                searchPlaceholder="Search by orders"-->
<!--                                :loading="!isDataLoaded"-->
<!--                                @reloadData="(options) => loadData(options)">-->
<!--                <template v-slot:item="props">-->
<!--                    <tr class="Polaris-DataTable__TableRow dashboard-reviews-row">-->
<!--                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle">{{props.item.order_name}}</td>-->
<!--                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle">{{props.item.customer_name}}</td>-->
<!--                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle">{{props.item.Total}}</td>-->
<!--                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle">{{props.item.Payment}}</td>-->
<!--                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle">{{props.item.created_at}}</td>-->
<!--&lt;!&ndash;                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle" style="padding-left: 35px;">&ndash;&gt;-->
<!--&lt;!&ndash;                            <PButton slim :to="`/app/showroom/${props.item.id}/details`" style="padding: .2rem 0.7rem; min-height: 3rem;">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div style="&#45;&#45;top-bar-background:#00848e; &#45;&#45;top-bar-background-lighter:#1d9ba4; &#45;&#45;top-bar-color:#f9fafb; &#45;&#45;p-frame-offset:0px;">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <span class="Polaris-Icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">&ndash;&gt;-->
<!--&lt;!&ndash;                                            <path d="M17.928 9.628C17.837 9.399 15.611 4 10 4S2.162 9.399 2.07 9.628a1.017 1.017 0 0 0 0 .744C2.163 10.601 4.389 16 10 16s7.837-5.399 7.928-5.628a1.017 1.017 0 0 0 0-.744zM10 14a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-6a2 2 0 1 0 .002 4.001A2 2 0 0 0 9.999 8z"></path>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </svg>&ndash;&gt;-->
<!--&lt;!&ndash;                                    </span>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </PButton>&ndash;&gt;-->
<!--&lt;!&ndash;                        </td>&ndash;&gt;-->
<!--                    </tr>-->
<!--                </template>-->
<!--            </polaris-data-table>-->
        </PCard>
    </PLayoutSection>
</template>

<script>
    import axios from 'axios';
    import {Button,Modal} from "@shopify/app-bridge/actions";
    export default {
        name: "Orders",
        data() {
            return {
                tableFooter: '',
                orderTableHeaders: [
                    { content: "Order", value: "order_name"},
                    { content: "Customer Name", value: "customer_name"},
                    { content: "Total", value: "Total}"},
                    { content: "Payment", value: "Payment"},
                    { content: "Created On", value: "created_at"},
                    { content: "Action", value: "#", sortable:false}
                ],
                orders: [],
                tableOptions:{},
                isDataLoaded:true,
            }
        },
        watch: {
        },
        methods: {
            async loadData(){
                try {
                    // this.isDataLoaded = false;
                    // let {data}  = await axios.get(process.env.MIX_APP_URL + '/api/order/list');
                    let {data}  =await axios.get(process.env.MIX_APP_URL+'/api/order/list');
                    this.orders = data.data;
                 //   console.log(data.data);
                    // this.isDataLoaded = true;
                    // this.tableOptions = data;
                } catch ({response}) {
                    // if (response.data.message) {
                    //     this.$root.$toast(response.data.message, true);
                    // }
                }
            },
            redirect(path){
                this.$router.push(path);
            },
        },
        created() {
            this.loadData();
        }
    }
</script>

<style scoped>
    .Polaris-Heading {
        font-size: 2.6rem;
        margin-bottom: 10px;
    }
    .Polaris-Layout__Section {
        margin-right: 2rem;
    }
    .Polaris-Stack {
        margin-bottom: 10px;
    }
</style>
