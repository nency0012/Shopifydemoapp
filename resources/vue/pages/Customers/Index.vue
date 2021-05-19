<template>
    <PLayoutSection>
        <PStack>
            <PStackItem fill>
                <PHeading element="h1">Customers</PHeading>
            </PStackItem>

            <PStackItem style="flex: 0.7 0 0; text-align: right;">
                <PButton @click="addOpenModal()" primary>Add New Customer</PButton>
            </PStackItem>
        </PStack>
        <PCard sectioned>
            <PDataTable
                :headings="customerTableHeaders"
                :rows="customers"
                :loading="!isDataLoaded"
                :hasFilter="true"
                searchPlaceholder="Search by customer">

                <template slot="body">
                    <tr v-for="(customer, index) in customers" :key="`row-${index}`"  class="Polaris-DataTable__TableRow">

                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ customer.name}} </td>

                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">   {{ customer.email }} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ customer.phone}} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">  {{ customer.created_at}} </td>
                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell&#45;&#45;verticalAlignMiddle Polaris-DataTable__Cell&#45;&#45" style="width: 30%">
                        <PButtonGroup segmented>
                            <PButton icon="EditMinor" @click="editOpenModal(customer)"></PButton>
<!--                            <PButton icon="DeleteMinor"  @click="deleteHoliday(customer.id)"></PButton>-->
                            <PButton icon="DeleteMinor"  @click="deleteConfirm(customer.id)"></PButton>
                        </PButtonGroup>
                        </td>

                    </tr>
                </template>

            </PDataTable>
        </PCard>



            <PModal :open="openModal"
                          :title="modalTitle"
                           @close="close"
                          sectioned
                          :primaryAction="primaryActions"
                          :secondaryActions="secondaryActions"
                          class="customer-modal">
                <PFormLayout>
                    <PTextField label="Customer Name" id="name" v-model="form.name" aria-placeholder="Enter customer name"/>
                    <PTextField label="Email" type="email" id="email" v-model="form.email" aria-placeholder="Enter customer email"/>
                    <PTextField label="Phone" type="number" id="phone" v-model="form.phone" aria-placeholder="Enter customer phone"/>

                </PFormLayout>




            </PModal>









    </PLayoutSection>
</template>

<script>
    import axios from 'axios';
    import {Button,Modal} from "@shopify/app-bridge/actions";

    export default {
        name: "Customers",
        data() {
            return {
                tableFooter: '',
                customerTableHeaders: [

                    { content: "Customer Name", value: "name"},
                    { content: "Email", value: "email}"},
                    { content: "Phone", value: "phone"},
                    { content: "Created On", value: "created_at"},
                    { content: "Action", value: "#", sortable:false}
                ],
                customers: [],
                tableOptions:{},
                isDataLoaded:true,
                openModal: false,
                modalTitle: "Add New Customer",
                form: {

                    name: null,
                    email: null,
                    phone: null
                },
                primaryActions: {
                    content: "Add",
                    onAction: this.saveCustomer,
                },
                secondaryActions: [
                    {
                        content: 'Cancel',
                        onAction: this.close,
                    }],
            }
        },
        watch: {
        },
        methods: {
            async loadData(){
                try {
                    // this.isDataLoaded = false;

                    let {data}  =await axios.get(process.env.MIX_APP_URL+'/api/customer/list');
                    this.customers = data.data;
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
            close() {
                this.openModal = false;
            },

            addOpenModal() {
                // this.form.id = null;
                 this.form.name = null;
                 this.form.email = null;
                 this.form.phone = null;
                this.primaryActions.content = "Add";
                this.modalTitle = "Add New Customer";

                this.openModal =true;
            },
            editOpenModal: function (slot) {
                this.form.id = slot.id;

                this.form.name = slot.name;
                this.form.email = slot.email;
                this.form.phone = slot.phone
                this.primaryActions.content = "Save";
                this.modalTitle = "Edit Customer";
                this.openModal = true;
            },
            async saveCustomer() {
                try{
                    let method = "post";
                    let segment = "create";

                     if(this.primaryActions.content == 'Save'){
                         method = 'put';
                        segment = 'update';
                     }

                    let {data} = await axios[method](process.env.MIX_APP_URL + '/api/customer/'+segment, this.form);
                    // this.$root.$toast(data.message);
                    this.loadData();
                    this.openModal = false;

                }catch ({response}) {
                    // if (response.data.message) {
                    //     this.$root.$toast(response.data.message, true);
                    // }
                }
            },
            async deleteConfirm(id) {
                  let self=this;
                  const okButton = Button.create(self.$root.$shopifyApp, {label: 'Yes, Delete', style: Button.Style.Danger});
                 const cancelButton = Button.create(self.$root.$shopifyApp, {label: 'No, Keep'});
                const modalOptions = {
                    title: 'Remove Holiday',
                    message: 'Are you sure you want to remove holiday?',
                    footer: {
                        buttons: {
                            primary: okButton,
                            secondary: [cancelButton],
                            style: "danger"
                        },
                    },
                };
                 const bundleModal = Modal.create(self.$root.$shopifyApp, modalOptions);
                 bundleModal.dispatch(Modal.Action.OPEN);

                cancelButton.subscribe(Button.Action.CLICK, data => {
                    bundleModal.dispatch(Modal.Action.CLOSE);
                });
                okButton.subscribe(Button.Action.CLICK, data => {
                    bundleModal.dispatch(Modal.Action.CLOSE);
                    self.deleteHoliday(id);
                });

            },
            async deleteHoliday(id){
                try {
                    let {data} = await axios.delete(process.env.MIX_APP_URL + '/api/customer/delete/' + id);
                 //   this.$root.$toast(data.message);
                    this.loadData();
                } catch ({response}) {
                    // if (response.data.message) {
                    //     this.$root.$toast(response.data.message, true);
                    // }
                }
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
