<template>
    <article class="message">
        <div class="message-body">
            <h1 class="title is-5">Ship to</h1>

            <template v-if="selecting">
                <ShippingAddressSelector 
                    :addresses="addresses"
                    :selectedAddress="selectedAddress"
                    @click="addressSelected"
                />
            </template>   
            
            <template v-else-if="creating">
                <ShippingAddressCreator 
                    @cancel="creating = false"
                    @created="created"
                />
            </template>                     

            <template v-else>
                <template v-if="selectedAddress">
                    <p>
                        {{ selectedAddress.name }}<br>
                        {{ selectedAddress.address_1 }}<br>
                        {{ selectedAddress.city }}<br>
                        {{ selectedAddress.postal_code }}<br>
                        {{ selectedAddress.country.name }}<br>
                    </p>

                    <br>
                </template>      

                <div class="field is-grouped">
                    <p class="control">
                        <a href="" class="button is-info" @click.prevent="selecting = true">Change shipping address</a>
                    </p>
                    <p class="control">
                        <a href="" class="button is-info" @click.prevent="creating = true">Add an address</a>
                    </p>                    
                </div>                          
            </template>


        </div>
    </article>
</template>

<script>
    import ShippingAddressCreator from './ShippingAddressCreator'
    import ShippingAddressSelector from './ShippingAddressSelector'

    export default {
        data () {
            return {
                selecting: false, 
                creating: false, 
                localAddresses: this.addresses,
                selectedAddress: null
            }
        },

        watch: {
            selectedAddress (address) {
                this.$emit('input', address.id);
            }
        },

        components: {
            ShippingAddressSelector,
            ShippingAddressCreator
        },

        props: {
            addresses: {
                required: true,
                type: Array
            }
        },

        computed: {
            defaultAddress () {
                return this.localAddresses.find(a => a.default === 1) // MySQL doesn't save bools as text so 1 represents true
            }
        },

        methods: {
            // Method to select an address
            addressSelected (address) {
                this.switchAddress(address)
                this.selecting = false
            },
            // Method which switches between selected addresses
            switchAddress (address) {
                this.selectedAddress = address
            },
            // When address is created, push it to the localaddress and return to checkout view
            created (address) {
                this.localAddresses.push(address)
                this.creating = false

                this.switchAddress(address)
            }
        },

        // On creation hook
        created () {
            if (this.addresses.length) {
                this.switchAddress(this.defaultAddress)
            }
        }
    }
</script>